<?php

namespace App\Services;

use App\Models\FinancialProfile;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * يبني ملخّص الوضع المالي (دخل/مصروفات/التزامات/DTI/الدخل المتاح/شريحة المخاطر)
 * من الإدخال اليدوي وبيانات Open Banking، ويخزّنه في financial_profiles.
 * محرك حتمي بالكامل — لا LLM.
 */
class FinancialAnalysisService
{
    /**
     * يحلّل الملف المالي للمستخدم ويحدّث/ينشئ سجل financial_profiles ويعيده.
     */
    public function analyzeProfile(User $user): FinancialProfile
    {
        // إجمالي الدخل الشهري (تطبيع كل التكرارات إلى شهري)
        // استعلامات صريحة تفادياً لمشاكل preventLazyLoading في بيئة التطوير
        $monthlyIncome = $user->incomes()->get(['amount_halalas', 'frequency'])
            ->sum(fn ($income) => $this->toMonthlyHalalas((int) $income->amount_halalas, $income->frequency));

        // إجمالي المصروفات الشهرية
        $monthlyExpenses = $user->expenses()->get(['amount_halalas', 'frequency'])
            ->sum(fn ($expense) => $this->toMonthlyHalalas((int) $expense->amount_halalas, $expense->frequency));

        // إجمالي الالتزامات الشهرية = مجموع الأقساط الشهرية
        $totalObligations = (int) $user->obligations()->sum('monthly_installment_halalas');

        $monthlyIncome = (int) $monthlyIncome;
        $monthlyExpenses = (int) $monthlyExpenses;

        // الدخل المتاح = الدخل - المصروفات
        $disposable = $monthlyIncome - $monthlyExpenses;

        // نسبة الالتزام للدخل DTI = (الالتزامات الشهرية / الدخل) × 100
        if ($monthlyIncome > 0) {
            $dtiRatio = round($totalObligations / $monthlyIncome * 100, 2);
        } else {
            // لا دخل: إن وُجدت التزامات فالنسبة قصوى، وإلا صفر
            $dtiRatio = $totalObligations > 0 ? 999.99 : 0.0;
        }

        $riskBand = $this->resolveRiskBand($dtiRatio);

        // تخزين مؤقت لتفادي إعادة الحساب الثقيل
        return FinancialProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'monthly_income_halalas' => $monthlyIncome,
                'monthly_expenses_halalas' => $monthlyExpenses,
                'total_obligations_halalas' => $totalObligations,
                'dti_ratio' => $dtiRatio,
                'disposable_income_halalas' => $disposable,
                'risk_band' => $riskBand,
                'computed_at' => Carbon::now(),
            ]
        );
    }

    /**
     * تطبيع مبلغ إلى ما يعادله شهرياً بالهللات حسب التكرار.
     */
    private function toMonthlyHalalas(int $amountHalalas, ?string $frequency): int
    {
        return match ($frequency) {
            'monthly' => $amountHalalas,
            'quarterly' => intdiv($amountHalalas, 3),
            'yearly' => intdiv($amountHalalas, 12),
            'one_time' => 0, // دفعة لمرة واحدة لا تُحتسب دخلاً/مصروفاً شهرياً متكرراً
            default => $amountHalalas,
        };
    }

    /**
     * شريحة المخاطر حسب DTI: low<=33، medium<=45، high>45.
     */
    private function resolveRiskBand(float $dtiRatio): string
    {
        return match (true) {
            $dtiRatio <= 33.0 => 'low',
            $dtiRatio <= 45.0 => 'medium',
            default => 'high',
        };
    }
}
