<?php

namespace App\Services\Support;

/**
 * مساعد حسابي مالي حتمي — كل القيم بالهللات كأعداد صحيحة.
 * لا استخدام لأي منطق توليدي؛ صيغ رياضية صريحة قابلة للتدقيق.
 */
class FinanceMath
{
    /** حدّ السوق الأعلى الافتراضي للـ APR (تمويل استهلاكي مكلف). */
    public const MARKET_APR_MAX = 48.0;

    /** أدنى APR تمثيلي في السوق (تمويل مدعوم/تنافسي). */
    public const APR_MIN = 3.92;

    /** نسبة الرسوم الإدارية وفق ضوابط SAMA (0.5%). */
    public const ADMIN_FEE_RATE = 0.005;

    /** سقف الرسوم الإدارية (2500 ريال = 250000 هللة). */
    public const ADMIN_FEE_CAP_HALALAS = 250000;

    /** سقف مدة التمويل بالأشهر وفق SAMA. */
    public const MAX_TENOR_MONTHS = 60;

    /**
     * القسط الشهري (هللة) لمبلغ بالهللات على مدى أشهر بنسبة APR سنوية.
     * صيغة الأقساط الثابتة (annuity)؛ عند صفر فائدة = المبلغ / المدة.
     */
    public static function monthlyInstallmentHalalas(int $amountHalalas, int $tenorMonths, float $apr): int
    {
        $tenorMonths = max(1, $tenorMonths);

        if ($apr <= 0.0) {
            return (int) ceil($amountHalalas / $tenorMonths);
        }

        $r = $apr / 100.0 / 12.0; // معدّل شهري
        $factor = pow(1.0 + $r, -$tenorMonths);
        $installment = ($amountHalalas * $r) / (1.0 - $factor);

        return (int) round($installment);
    }

    /**
     * إجمالي الفائدة/الكلفة الربحية (هللة) = مجموع الأقساط - أصل المبلغ.
     */
    public static function totalInterestHalalas(int $amountHalalas, int $tenorMonths, float $apr): int
    {
        $tenorMonths = max(1, $tenorMonths);
        $installment = self::monthlyInstallmentHalalas($amountHalalas, $tenorMonths, $apr);
        $interest = ($installment * $tenorMonths) - $amountHalalas;

        return max(0, (int) $interest);
    }

    /**
     * الرسوم الإدارية (هللة) = min(المبلغ × 0.5% ، السقف 2500 ريال).
     */
    public static function adminFeeHalalas(int $amountHalalas): int
    {
        $fee = (int) round($amountHalalas * self::ADMIN_FEE_RATE);

        return min($fee, self::ADMIN_FEE_CAP_HALALAS);
    }

    /** حصر قيمة ضمن [min, max]. */
    public static function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }
}
