<?php

namespace App\Services\Dto;

/**
 * حامل بيانات عرض تمويلي واحد ضمن المقارنة (المبالغ بالهللات).
 */
readonly class OfferComparisonDto
{
    public function __construct(
        public string $providerName,
        public string $productName,
        public float $apr,
        public int $amountHalalas,
        public int $tenorMonths,
        public int $monthlyInstallmentHalalas,
        public int $adminFeeHalalas,
        public int $totalInterestHalalas,
        public int $totalCostHalalas,
    ) {}

    public function toArray(): array
    {
        return [
            'provider_name' => $this->providerName,
            'product_name' => $this->productName,
            'apr' => $this->apr,
            'amount_halalas' => $this->amountHalalas,
            'tenor_months' => $this->tenorMonths,
            'monthly_installment_halalas' => $this->monthlyInstallmentHalalas,
            'admin_fee_halalas' => $this->adminFeeHalalas,
            'total_interest_halalas' => $this->totalInterestHalalas,
            'total_cost_halalas' => $this->totalCostHalalas,
        ];
    }
}
