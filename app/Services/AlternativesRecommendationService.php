<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\DecisionSession;
use App\Models\Recommendation;
use App\Models\User;
use App\Services\Support\FinanceMath;
use Illuminate\Support\Carbon;

/**
 * العمود الفقري: يختار ويرتّب البدائل الخمسة حسب الأولوية وملاءمة حالة المستخدم/الهدف،
 * ويولّد recommendations + recommendation_items مع التكلفة/التوفير المتوقّع. لا LLM.
 */
class AlternativesRecommendationService
{
    /** المدة المرجعية لتقدير الفائدة المُتجنَّبة (بالأشهر). */
    private const REFERENCE_TENOR_MONTHS = 24;

    /** مبرّرات عربية موجزة لكل بديل. */
    private const REASONS = [
        'digital_savings_circles' => 'سيولة فورية بدون فوائد عبر دوائر ادخارية موثّقة قانونياً برسوم رمزية.',
        'gov_development_finance' => 'تمويل حكومي تنموي بصفر فوائد (بنك التنمية الاجتماعية) لأغراض مؤهّلة.',
        'proactive_investing' => 'بناء سيولة مستقبلية عبر صكوك وبرامج ادخار محفّزة بدل الاستدانة.',
        'insurance_protection' => 'حماية تأمينية وقائية تقيك الحاجة للاقتراض الطارئ.',
        'community_relief' => 'تكافل مجتمعي لمعالجة التعثّر الفعلي عبر منصات معتمدة.',
    ];

    /** البدائل التي تُتيح تجنّب كلفة فائدة مباشرة (توفير متوقّع). */
    private const INTEREST_AVOIDING = [
        'digital_savings_circles',
        'gov_development_finance',
        'proactive_investing',
        'community_relief',
    ];

    /**
     * يولّد توصية مرتّبة للمستخدم (اعتراض قرار اقتراض أو تحليل دوري) ويعيدها.
     */
    public function recommend(User $user, ?DecisionSession $session = null): Recommendation
    {
        $context = $session ? 'borrow_intercept' : 'periodic';

        // مبلغ مرجعي لتقدير التوفير: من الجلسة أو من أعلى هدف مالي أو صفر
        $referenceAmount = $this->resolveReferenceAmount($user, $session);
        $baseInterestAvoided = FinanceMath::totalInterestHalalas(
            $referenceAmount,
            self::REFERENCE_TENOR_MONTHS,
            FinanceMath::MARKET_APR_MAX,
        );

        $recommendation = Recommendation::create([
            'user_id' => $user->id,
            'decision_session_id' => $session?->id,
            'context' => $context,
            'generated_at' => Carbon::now(),
        ]);

        // ترتيب البدائل الخمسة حسب الأولوية
        $alternatives = Alternative::query()
            ->where('is_active', true)
            ->with(['providers' => fn ($q) => $q->orderBy('sort_order')])
            ->orderBy('priority')
            ->get();

        $rank = 1;
        foreach ($alternatives as $alternative) {
            $provider = $alternative->providers->first();

            // التوفير المتوقّع: الفائدة المُتجنَّبة للبدائل غير الربحية، متناقصة مع الرتبة
            $projectedSaving = null;
            if ($referenceAmount > 0 && in_array($alternative->slug, self::INTEREST_AVOIDING, true)) {
                // تخفيض تدريجي حسب الرتبة (الأعلى أولوية يحصد الحصّة الأكبر)
                $projectedSaving = (int) round($baseInterestAvoided / $rank);
            }

            $recommendation->items()->create([
                'alternative_slug' => $alternative->slug,
                'provider_type' => $provider?->provider_type,
                'provider_id' => $provider?->provider_id,
                'rank' => $rank,
                'projected_cost_halalas' => null,
                'projected_saving_halalas' => $projectedSaving,
                'reason_ar' => self::REASONS[$alternative->slug] ?? $alternative->summary_ar,
                'cta_route' => "/app/alternatives/{$alternative->slug}",
            ]);

            $rank++;
        }

        return $recommendation->load('items');
    }

    /**
     * المبلغ المرجعي لتقدير التوفير المتوقّع.
     */
    private function resolveReferenceAmount(User $user, ?DecisionSession $session): int
    {
        if ($session && $session->requested_amount_halalas) {
            return max(0, (int) $session->requested_amount_halalas);
        }

        // أعلى هدف مالي نشط (المبلغ المتبقّي للهدف)
        $goal = $user->financialGoals()
            ->where('status', 'active')
            ->orderByDesc('priority')
            ->first();

        if ($goal) {
            $remaining = (int) $goal->target_amount_halalas - (int) $goal->saved_amount_halalas;

            return max(0, $remaining);
        }

        return 0;
    }
}
