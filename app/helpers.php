<?php

/*
| مساعدات عرض عامة لمنصة رشيد.
| القاعدة الذهبية: المبالغ تُخزَّن بالهللات كأعداد صحيحة (bigInteger)،
| ولا تُحوَّل إلى ريالات إلا عند العرض فقط عبر هذه الدالة.
*/

if (! function_exists('halalas_to_sar')) {
    /**
     * يحوّل مبلغاً بالهللات إلى نص ريال منسّق للعرض (للإخراج فقط، لا للحساب).
     * يعرض بلا كسور حين يكون المبلغ ريالات صحيحة، ومنزلتين عند وجود هللات.
     *
     * @param  int|float|null  $halalas  المبلغ بالهللات
     * @return string  مثال: 3,450 أو 3,450.75
     */
    function halalas_to_sar($halalas): string
    {
        $halalas = (int) ($halalas ?? 0);
        $sar = $halalas / 100;

        $decimals = ($halalas % 100 === 0) ? 0 : 2;

        return number_format($sar, $decimals);
    }
}
