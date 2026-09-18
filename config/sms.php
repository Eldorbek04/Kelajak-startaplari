<?php

declare(strict_types=1);

return [

    'api_base_url' => rtrim((string) env('SMS_API_BASE_URL', 'https://api.ideal-study.uz'), '/'),

    'api_key' => env('SMS_API_KEY', ''),

    'default_from' => env('SMS_DEFAULT_FROM', '4546'),

    /*
    |--------------------------------------------------------------------------
    | Verify SSL
    |--------------------------------------------------------------------------
    |
    | Baʼzi provayderlar uchun false qilish kerak bo‘lishi mumkin. Productionda
    | imkon qadar true qoling.
    |
    */

    'verify_ssl' => filter_var(env('SMS_VERIFY_SSL', false), FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Debug: OTP kodini ekranda ko‘rsatish
    |--------------------------------------------------------------------------
    |
    | SMS balansi tugagan yoki lokal rivojlantirishda kodni ekranda ko‘rsatish.
    | Productionda false qiling.
    |
    */

    'debug_show_otp' => filter_var(env('SMS_DEBUG_SHOW_OTP', env('APP_DEBUG', false)), FILTER_VALIDATE_BOOLEAN),

    /*
    |--------------------------------------------------------------------------
    | Matn shablonlari (:code — faqat OTP xabarlari uchun)
    |--------------------------------------------------------------------------
    */

    'templates' => [
        'application_received' => 'Kelajak startuplari dasturida arizangiz qabul qilindi! Ariza holatini saytda kuzatib borishingiz mumkin.',
        'password_reset_code' => '"Kelajak Startuplari" dasturida parolni tiklash uchun kod: :code',
        'registration_verification_code' => '"Kelajak Startuplari" dasturida ro\'yxatdan o\'tishni tasdiqlash uchun kod: :code',
    ],

];
