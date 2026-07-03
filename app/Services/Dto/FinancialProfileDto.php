<?php

namespace App\Services\Dto;

/**
 * حامل بيانات ملخّص الوضع المالي (كل المبالغ بالهللات كأعداد صحيحة).
 */
readonly class FinancialProfileDto
{
    public function __construct(
        public int $monthlyIncomeHalalas,
        public int $monthlyExpensesHalalas,
        public int $totalObligationsHalalas,
        public int $disposableIncomeHalalas,
        public float $dtiRatio,
        public string $riskBand,
    ) {}

    /** تمثيل مصفوفي للتخزين/العرض. */
    public function toArray(): array
    {
        return [
            'monthly_income_halalas' => $this->monthlyIncomeHalalas,
            'monthly_expenses_halalas' => $this->monthlyExpensesHalalas,
            'total_obligations_halalas' => $this->totalObligationsHalalas,
            'disposable_income_halalas' => $this->disposableIncomeHalalas,
            'dti_ratio' => $this->dtiRatio,
            'risk_band' => $this->riskBand,
        ];
    }
}
