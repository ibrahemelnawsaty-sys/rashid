<?php

return [
    // عرض رمز OTP على الشاشة (وضع تجريبي حتى ربط بوابة SMS). اجعلها false بعد ربط SMS.
    'otp_dev_show' => env('OTP_DEV_SHOW', true),

    // النموذج الافتراضي لطبقة المستشار الذكي (اختياري).
    'ai_model' => env('AI_ADVISOR_MODEL', 'claude-haiku-4-5-20251001'),
];
