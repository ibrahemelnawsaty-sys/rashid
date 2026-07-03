<?php

namespace App\Services;

use App\Models\DecisionOutcome;
use App\Models\DecisionSession;
use App\Services\Support\FinanceMath;
use Illuminate\Support\Carbon;

/**
 * يشغّل «شجرة القرار المالي العقلاني»: يوازن غرض التمويل مقابل القدرة على السداد
 * عبر قواعد حتمية صريحة، ويُنتج حكماً (avoid_borrowing / rationalize_borrowing)
 * مع مبرّرات ومسار قابل لإعادة الإنتاج. لا LLM.
 */
class DecisionTreeService
{
    /** المدة الافتراضية للتقدير حين عدم تحديدها في الإجابات. */
    private const DEFAULT_TENOR_MONTHS = 24;

    /** حدّ أشهر تكوين المبلغ ادخاراً لاعتبار الاقتراض غير ضروري. */
    private const SAVE_FEASIBLE_MONTHS = 8;

    public function __construct(
        private readonly FinancialAnalysisService $analysisService,
    ) {}

    /**
     * يشغّل الشجرة على الجلسة ويخزّن decision_outcomes ويعيده.
     *
     * @param  array<string,mixed>  $answers  إجابات/مدخلات إضافية (مثل tenor_months)
     */
    public function run(DecisionSession $session, array $answers = []): DecisionOutcome
    {
        $profile = $this->analysisService->analyzeProfile($session->user);

        $amount = max(0, (int) $session->requested_amount_halalas);
        $disposable = (int) $profile->disposable_income_halalas;
        $dti = (float) $profile->dti_ratio;

        // أشهر تكوين المبلغ ادخاراً = المبلغ / أقصى(1، الدخل المتاح)
        $monthsToSave = (int) ceil($amount / max(1, $disposable));
        // إن كان الدخل المتاح صفراً أو سالباً فالتكوين غير ممكن عملياً
        if ($disposable <= 0) {
            $monthsToSave = PHP_INT_MAX;
        }

        $tenor = $this->resolveTenor($answers);

        // درجة القدرة على السداد (0..100)
        $affordability = $this->affordabilityScore($amount, $tenor, $disposable, $dti);

        // الحكم: تجنّب الاقتراض إذا (DTI<=33) و(أمكن تكوين المبلغ خلال <=8 أشهر)
        $canSaveSoon = $monthsToSave <= self::SAVE_FEASIBLE_MONTHS;
        $verdict = ($dti <= 33.0 && $canSaveSoon)
            ? 'avoid_borrowing'
            : 'rationalize_borrowing';

        // تقدير كلفة الفائدة لو اقترض: عند حدّ السوق الأعلى (سيناريو محافظ)
        $interestAtMarketMax = FinanceMath::totalInterestHalalas($amount, $tenor, FinanceMath::MARKET_APR_MAX);
        $interestAtCheapest = FinanceMath::totalInterestHalalas($amount, $tenor, FinanceMath::APR_MIN);
        $cheapestApr = FinanceMath::APR_MIN;

        // اختيار البدائل الموصى بها حسب الأولوية وملاءمة الغرض
        $recommendedSlugs = $this->recommendedAlternatives($session->purpose);

        $rationale = $this->buildRationale(
            $verdict,
            $amount,
            $disposable,
            $dti,
            $monthsToSave,
            $tenor,
            $interestAtMarketMax,
            $interestAtCheapest,
        );

        // تخزين المخرَج (decision_session_id فريد)
        $outcome = DecisionOutcome::updateOrCreate(
            ['decision_session_id' => $session->id],
            [
                'verdict' => $verdict,
                'affordability_score' => $affordability,
                'recommended_alternative_slugs' => $recommendedSlugs,
                'cheapest_apr' => $cheapestApr,
                'rationale_ar' => $rationale,
            ]
        );

        // إغلاق الجلسة
        $session->forceFill([
            'status' => 'completed',
            'completed_at' => Carbon::now(),
        ])->save();

        return $outcome;
    }

    /**
     * درجة القدرة على السداد (0..100): مزيج من فسحة DTI وتغطية الدخل المتاح للقسط.
     */
    private function affordabilityScore(int $amount, int $tenor, int $disposable, float $dti): float
    {
        // فسحة DTI: كلما قلّت النسبة عن 45 زادت الأريحية
        $dtiHeadroom = FinanceMath::clamp((45.0 - $dti) / 45.0, 0.0, 1.0);

        // تغطية القسط: الدخل المتاح مقابل قسط تقديري عند حدّ السوق الأعلى
        $installment = FinanceMath::monthlyInstallmentHalalas($amount, $tenor, FinanceMath::MARKET_APR_MAX);
        $coverage = FinanceMath::clamp($disposable / max(1, $installment), 0.0, 2.0) / 2.0;

        $score = (0.5 * $dtiHeadroom + 0.5 * $coverage) * 100.0;

        return round(FinanceMath::clamp($score, 0.0, 100.0), 2);
    }

    /**
     * استخراج المدة من الإجابات ضمن السقف 60، وإلا الافتراضية.
     */
    private function resolveTenor(array $answers): int
    {
        $tenor = (int) ($answers['tenor_months'] ?? self::DEFAULT_TENOR_MONTHS);

        return max(1, min($tenor, FinanceMath::MAX_TENOR_MONTHS));
    }

    /**
     * ترتيب البدائل الخمسة حسب ملاءمة الغرض ثم الأولوية الجوهرية.
     *
     * @return array<int,string>
     */
    private function recommendedAlternatives(?string $purpose): array
    {
        // الأولوية الجوهرية للبدائل (1 = الأعلى)
        $basePriority = [
            'digital_savings_circles' => 1,
            'gov_development_finance' => 2,
            'proactive_investing' => 3,
            'insurance_protection' => 4,
            'community_relief' => 5,
        ];

        // تعزيز الملاءمة حسب الغرض (كلما زاد الوزن تقدّم البديل)
        $purposeFit = [
            'emergency' => ['digital_savings_circles' => 3, 'insurance_protection' => 2, 'community_relief' => 1],
            'marriage' => ['gov_development_finance' => 3, 'digital_savings_circles' => 2],
            'car' => ['proactive_investing' => 3, 'digital_savings_circles' => 2],
            'debt_consolidation' => ['community_relief' => 3, 'gov_development_finance' => 2],
            'business' => ['gov_development_finance' => 3, 'proactive_investing' => 2],
            'education' => ['gov_development_finance' => 3, 'proactive_investing' => 1],
            'other' => [],
        ];

        $fit = $purposeFit[$purpose] ?? [];

        $slugs = array_keys($basePriority);
        usort($slugs, function (string $a, string $b) use ($basePriority, $fit) {
            $fitA = $fit[$a] ?? 0;
            $fitB = $fit[$b] ?? 0;
            // ملاءمة أعلى أولاً
            if ($fitA !== $fitB) {
                return $fitB <=> $fitA;
            }

            // ثم الأولوية الجوهرية الأقل رقماً أولاً
            return $basePriority[$a] <=> $basePriority[$b];
        });

        return array_values($slugs);
    }

    /**
     * بناء نص المبرّرات العربي الموجز.
     */
    private function buildRationale(
        string $verdict,
        int $amount,
        int $disposable,
        float $dti,
        int $monthsToSave,
        int $tenor,
        int $interestMax,
        int $interestMin,
    ): string {
        $amountSar = number_format($amount / 100, 0);
        $dispSar = number_format(max(0, $disposable) / 100, 0);
        $interestMaxSar = number_format($interestMax / 100, 0);
        $interestMinSar = number_format($interestMin / 100, 0);
        $monthsText = $monthsToSave === PHP_INT_MAX ? 'غير ممكن حالياً' : "{$monthsToSave} شهراً";

        if ($verdict === 'avoid_borrowing') {
            return "نوصي بتجنّب الاقتراض. نسبة التزامك الحالية {$dti}% ضمن الحدّ الآمن، "
                ."ويمكنك تكوين المبلغ المطلوب ({$amountSar} ريال) عبر الادخار خلال {$monthsText} "
                ."من دخلك المتاح ({$dispSar} ريال شهرياً)، فتتفادى كلفة فائدة قد تصل إلى {$interestMaxSar} ريال.";
        }

        return "إن كان الاقتراض حتمياً فرشّده. المبلغ المطلوب {$amountSar} ريال ونسبة التزامك {$dti}%. "
            ."على مدى {$tenor} شهراً تتراوح كلفة الفائدة التقديرية بين {$interestMinSar} ريال (بأقل APR) "
            ."و{$interestMaxSar} ريال (بحدّ السوق الأعلى)؛ قارن العروض واختر الأقل كلفةً إجمالية، "
            .'وراجع البدائل قبل اتخاذ القرار.';
    }
}
