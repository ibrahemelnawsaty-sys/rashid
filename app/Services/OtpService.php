<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * رموز التحقق لمرة واحدة (OTP) للدخول/التسجيل بالجوال.
 * ملاحظة: لا توجد بوابة SMS بعد؛ يُعاد الرمز لعرضه للمستخدم في الوضع التجريبي
 * (config rashid.otp_dev_show). عند ربط SMS: أرسله هنا واجعل otp_dev_show=false.
 */
class OtpService
{
    public const EXPIRY_MINUTES = 10;
    public const MAX_ATTEMPTS = 5;

    /** يُنشئ رمزاً جديداً ويخزّنه مجزّأً، ويعيد الرمز الخام. */
    public function send(string $phone, string $purpose, ?int $userId = null): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'user_id' => $userId,
            'phone' => $phone,
            'code_hash' => Hash::make($code),
            'purpose' => $purpose,
            'expires_at' => Carbon::now()->addMinutes(self::EXPIRY_MINUTES),
            'attempts' => 0,
        ]);

        // TODO(SMS): أرسل $code عبر بوابة الرسائل عند توفّرها.
        return $code;
    }

    /** يتحقّق من الرمز لأحدث طلب فعّال؛ يستهلكه عند النجاح. */
    public function verify(string $phone, string $purpose, string $code): bool
    {
        $otp = OtpVerification::where('phone', $phone)
            ->where('purpose', $purpose)
            ->whereNull('consumed_at')
            ->where('expires_at', '>', Carbon::now())
            ->latest('id')
            ->first();

        if (! $otp || $otp->attempts >= self::MAX_ATTEMPTS) {
            return false;
        }

        $otp->increment('attempts');

        if (! Hash::check($code, $otp->code_hash)) {
            return false;
        }

        $otp->forceFill(['consumed_at' => Carbon::now()])->save();

        return true;
    }

    /** توحيد صيغة الجوال السعودي إلى 9665XXXXXXXX، أو null إن كان غير صالح. */
    public static function normalizePhone(string $raw): ?string
    {
        $d = preg_replace('/\D/', '', $raw);

        if (str_starts_with($d, '966')) {
            $d = substr($d, 3);
        }
        if (str_starts_with($d, '0')) {
            $d = substr($d, 1);
        }

        // بعد التطبيع يجب أن يكون 9 خانات تبدأ بـ 5
        if (! preg_match('/^5\d{8}$/', $d)) {
            return null;
        }

        return '966'.$d;
    }
}
