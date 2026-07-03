<?php

namespace App\Services;

use App\Models\FinancialGoal;
use App\Models\SavingsContribution;
use App\Models\SavingsPlan;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * يُنشئ ويتتبّع خطط الادخار المرتبطة بالأهداف والبدائل الاستثمارية/الجمعيات،
 * ويحسب الجدول الزمني والمساهمات (يدوي الآن، PIS آلي مستقبلاً). لا LLM.
 * كل المبالغ بالهللات كأعداد صحيحة.
 */
class SavingsPlanService
{
    /**
     * ينشئ خطة ادخار مرتبطة بهدف مالي ويعيدها.
     *
     * @param  array<string,mixed>  $params
     */
    public function createPlan(User $user, FinancialGoal $goal, array $params): SavingsPlan
    {
        $monthly = max(1, (int) ($params['monthly_amount_halalas'] ?? 0));
        $target = (int) ($params['target_amount_halalas'] ?? $goal->target_amount_halalas);
        $target = max(0, $target);

        $startDate = isset($params['start_date'])
            ? Carbon::parse($params['start_date'])
            : Carbon::today();

        // نهاية الخطة: عدد الأشهر اللازمة لبلوغ الهدف بالمساهمة الشهرية
        $endDate = isset($params['end_date'])
            ? Carbon::parse($params['end_date'])
            : (clone $startDate)->addMonths(max(1, (int) ceil($target / $monthly)));

        return SavingsPlan::create([
            'user_id' => $user->id,
            'financial_goal_id' => $goal->id,
            'alternative_slug' => $params['alternative_slug'] ?? 'digital_savings_circles',
            'provider_type' => $params['provider_type'] ?? null,
            'provider_id' => $params['provider_id'] ?? null,
            'target_amount_halalas' => $target,
            'monthly_amount_halalas' => $monthly,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'status' => 'active',
        ]);
    }

    /**
     * يسجّل مساهمة في الخطة، ويحدّث تقدّم الهدف، ويكمل الخطة عند بلوغ الهدف.
     */
    public function recordContribution(SavingsPlan $plan, int $amountHalalas): SavingsContribution
    {
        $amountHalalas = max(0, $amountHalalas);

        $contribution = $plan->contributions()->create([
            'amount_halalas' => $amountHalalas,
            'source' => 'manual',
            'contributed_at' => Carbon::now(),
            'status' => 'completed',
        ]);

        // تحديث تقدّم الهدف المرتبط
        if ($plan->financial_goal_id) {
            $goal = $plan->financialGoal;
            if ($goal) {
                $goal->saved_amount_halalas = (int) $goal->saved_amount_halalas + $amountHalalas;
                if ($goal->saved_amount_halalas >= (int) $goal->target_amount_halalas && (int) $goal->target_amount_halalas > 0) {
                    $goal->status = 'achieved';
                }
                $goal->save();
            }
        }

        // إكمال الخطة عند بلوغ إجمالي المساهمات الهدف
        $totalContributed = (int) $plan->contributions()->where('status', 'completed')->sum('amount_halalas');
        if ((int) $plan->target_amount_halalas > 0 && $totalContributed >= (int) $plan->target_amount_halalas) {
            $plan->status = 'completed';
            $plan->save();
        }

        return $contribution;
    }

    /**
     * محاكاة نمو الادخار: مصفوفة نقاط تراكمية شهرية.
     * كل المبالغ بالهللات. العائد السنوي بالنسبة المئوية (0 = بدون عائد).
     *
     * @return array<int, array{month:int, contributed_total_halalas:int, returns_earned_halalas:int, balance_halalas:int}>
     */
    public function simulate(int $monthly, int $months, float $annualReturn = 0.0): array
    {
        $monthly = max(0, $monthly);
        $months = max(0, $months);
        $monthlyRate = $annualReturn > 0.0 ? ($annualReturn / 100.0 / 12.0) : 0.0;

        $points = [];
        $balance = 0.0;          // الرصيد مع العوائد (تقدير عشري داخلي)
        $contributedTotal = 0;   // إجمالي المساهمات (هللة)

        for ($m = 1; $m <= $months; $m++) {
            // عائد الشهر يُحتسب على الرصيد القائم قبل مساهمة الشهر
            $balance += $balance * $monthlyRate;
            // مساهمة الشهر
            $balance += $monthly;
            $contributedTotal += $monthly;

            $balanceInt = (int) round($balance);
            $points[] = [
                'month' => $m,
                'contributed_total_halalas' => $contributedTotal,
                'returns_earned_halalas' => max(0, $balanceInt - $contributedTotal),
                'balance_halalas' => $balanceInt,
            ];
        }

        return $points;
    }
}
