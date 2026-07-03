<?php

namespace App\Services;

use App\Models\AprRate;
use App\Services\Dto\OfferComparisonDto;
use App\Services\Support\FinanceMath;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * يقارن التكلفة الإجمالية للتمويل عبر عروض المؤسسات ضمن ضوابط SAMA
 * (سقف 60 شهراً، رسوم إدارية 0.5% أو 2500 ريال أيهما أقل)
 * ويرتّب حسب الأقل كلفةً إجمالية لا حسب الـ APR وحده.
 */
class AprComparisonService
{
    /**
     * يبني عروضاً تمثيلية ويحسب لكل عرض القسط/الرسوم/الكلفة الإجمالية.
     *
     * @return Collection<int, OfferComparisonDto>
     */
    public function compare(int $amountHalalas, int $tenorMonths, string $purpose): Collection
    {
        // ضبط الحدود وفق SAMA
        $tenorMonths = max(1, min($tenorMonths, FinanceMath::MAX_TENOR_MONTHS));
        $amountHalalas = max(0, $amountHalalas);

        $offers = $this->resolveOffers($amountHalalas, $tenorMonths);

        // حساب الكلفة لكل عرض
        $compared = $offers->map(function (array $offer) use ($amountHalalas, $tenorMonths) {
            $apr = (float) $offer['apr'];
            $installment = FinanceMath::monthlyInstallmentHalalas($amountHalalas, $tenorMonths, $apr);
            $adminFee = FinanceMath::adminFeeHalalas($amountHalalas);
            $totalInterest = FinanceMath::totalInterestHalalas($amountHalalas, $tenorMonths, $apr);
            $totalCost = ($installment * $tenorMonths) + $adminFee;

            return new OfferComparisonDto(
                providerName: $offer['provider_name'],
                productName: $offer['product_name'],
                apr: $apr,
                amountHalalas: $amountHalalas,
                tenorMonths: $tenorMonths,
                monthlyInstallmentHalalas: $installment,
                adminFeeHalalas: $adminFee,
                totalInterestHalalas: $totalInterest,
                totalCostHalalas: $totalCost,
            );
        });

        // الترتيب تصاعدياً حسب إجمالي التكلفة (لا حسب APR وحده)
        return $compared
            ->sortBy(fn (OfferComparisonDto $dto) => $dto->totalCostHalalas)
            ->values();
    }

    /**
     * يجلب العروض من apr_rates السارية والمطابقة للمبلغ/المدة،
     * وإلا يبني عروضاً تمثيلية من نطاقات السوق.
     *
     * @return Collection<int, array{provider_name:string,product_name:string,apr:float}>
     */
    private function resolveOffers(int $amountHalalas, int $tenorMonths): Collection
    {
        $today = Carbon::today()->toDateString();

        $rates = AprRate::query()
            ->with('financialProduct')
            ->where('effective_from', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('effective_to')->orWhere('effective_to', '>=', $today);
            })
            ->where(function ($q) use ($amountHalalas) {
                $q->whereNull('min_amount_halalas')->orWhere('min_amount_halalas', '<=', $amountHalalas);
            })
            ->where(function ($q) use ($amountHalalas) {
                $q->whereNull('max_amount_halalas')->orWhere('max_amount_halalas', '>=', $amountHalalas);
            })
            ->where(function ($q) use ($tenorMonths) {
                $q->whereNull('max_tenor_months')->orWhere('max_tenor_months', '>=', $tenorMonths);
            })
            ->get();

        if ($rates->isNotEmpty()) {
            return $rates->map(function (AprRate $rate) {
                $product = $rate->financialProduct;

                return [
                    'provider_name' => $product?->name_ar ?? 'مؤسسة تمويلية',
                    'product_name' => $product?->name_ar ?? 'منتج تمويلي',
                    // نعتمد الحدّ الأعلى للـ APR كتقدير محافظ للكلفة
                    'apr' => (float) ($rate->apr_max ?? $rate->apr_min ?? FinanceMath::MARKET_APR_MAX),
                ];
            })->values();
        }

        // عروض تمثيلية احتياطية (نطاقات السوق السعودي) حين خلوّ قاعدة الأسعار
        return collect($this->representativeOffers());
    }

    /**
     * عروض تمثيلية ثابتة تغطّي مدى السوق من المدعوم حتى المكلف.
     *
     * @return array<int, array{provider_name:string,product_name:string,apr:float}>
     */
    private function representativeOffers(): array
    {
        return [
            ['provider_name' => 'تمويل مدعوم تنافسي', 'product_name' => 'تمويل شخصي منخفض APR', 'apr' => FinanceMath::APR_MIN],
            ['provider_name' => 'بنك تجاري', 'product_name' => 'تمويل شخصي مرابحة', 'apr' => 9.5],
            ['provider_name' => 'شركة تمويل استهلاكي', 'product_name' => 'تمويل نقدي', 'apr' => 18.0],
            ['provider_name' => 'تمويل بطاقة ائتمانية', 'product_name' => 'تقسيط بطاقة', 'apr' => 30.0],
            ['provider_name' => 'تمويل مكلف', 'product_name' => 'تمويل سريع', 'apr' => FinanceMath::MARKET_APR_MAX],
        ];
    }
}
