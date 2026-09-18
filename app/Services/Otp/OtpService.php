<?php

declare(strict_types=1);

namespace App\Services\Otp;

use App\Models\OtpCode;
use App\Services\Sms\SmsSender;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class OtpService
{
    public const OTP_TTL_MINUTES = 2;

    public function __construct(
        private readonly SmsSender $smsSender,
    ) {}

    /**
     * Ro‘yxatdan o‘tish SMS-kodi.
     */
    public function sendRegistrationOtp(string $phone): void
    {
        $plainCode = $this->issueOtp($phone);
        $this->rememberDebugOtp($phone, $plainCode);
        $template = (string) config('sms.templates.registration_verification_code');
        $message = str_replace(':code', $plainCode, $template);
        $this->smsSender->send($phone, $message);
    }

    /**
     * Parolni tiklash SMS-kodi (keyingi bosqichda ishlatish uchun).
     */
    public function sendPasswordResetOtp(string $phone): void
    {
        $plainCode = $this->issueOtp($phone);
        $template = (string) config('sms.templates.password_reset_code');
        $message = str_replace(':code', $plainCode, $template);
        $this->smsSender->send($phone, $message);
    }

    /**
     * @deprecated {@see sendRegistrationOtp()}
     */
    public function sendOtp(string $phone): void
    {
        $this->sendRegistrationOtp($phone);
    }

    /**
     * Yangi 6 raqamli OTP yaratadi (shu telefon uchun eskisini o‘chiradi).
     */
    protected function issueOtp(string $phone): string
    {
        OtpCode::query()->where('phone', $phone)->delete();

        $plainCode = $this->generateSixDigitCode();

        OtpCode::query()->create([
            'phone' => $phone,
            'code' => Hash::make($plainCode),
            'expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
        ]);

        return $plainCode;
    }

    /**
     * mm:ss ko‘rinishida qolgan kutish vaqti (UI va xabarlar uchun).
     */
    public static function formatCooldownClock(int $seconds): string
    {
        $seconds = max(0, $seconds);
        $m = intdiv($seconds, 60);
        $s = $seconds % 60;

        return sprintf('%d:%02d', $m, $s);
    }

    /**
     * Seconds until a new OTP may be sent (same window as {@see self::OTP_TTL_MINUTES}).
     */
    public function secondsUntilResendAllowed(string $phone): int
    {
        $otp = OtpCode::query()
            ->where('phone', $phone)
            ->latest('id')
            ->first();

        if ($otp === null) {
            return 0;
        }

        $availableAt = $otp->created_at->copy()->addMinutes(self::OTP_TTL_MINUTES);

        if ($availableAt->lessThanOrEqualTo(now())) {
            return 0;
        }

        return (int) now()->diffInSeconds($availableAt);
    }

    /**
     * When the current OTP cooldown ends (for UI countdown). Null if resend is already allowed.
     */
    public function resendAvailableAt(string $phone): ?CarbonInterface
    {
        $otp = OtpCode::query()
            ->where('phone', $phone)
            ->latest('id')
            ->first();

        if ($otp === null) {
            return null;
        }

        $availableAt = $otp->created_at->copy()->addMinutes(self::OTP_TTL_MINUTES);

        if ($availableAt->lessThanOrEqualTo(now())) {
            return null;
        }

        return $availableAt;
    }

    /**
     * Ro‘yxatdan o‘tish formasi qayta yuborilganda: shu raqam uchun OTP allaqachon yuborilgan
     * va qayta yuborish muddati tugamagan bo‘lsa, yangi SMS yubormaslik kerak.
     */
    public function mustThrottleNewRegistrationSms(string $phone): bool
    {
        return $this->secondsUntilResendAllowed($phone) > 0;
    }

    /**
     * Debug rejimida ekranda ko‘rsatish uchun oxirgi yuborilgan OTP (plain).
     */
    public function debugCodeForPhone(string $phone): ?string
    {
        if (! config('sms.debug_show_otp')) {
            return null;
        }

        $code = Cache::get($this->debugCacheKey($phone));

        return is_string($code) && $code !== '' ? $code : null;
    }

    /**
     * Check the code for the given phone. On success, the OTP row is deleted (one-time use).
     */
    public function verify(string $phone, string $plainCode): bool
    {
        $otp = OtpCode::query()
            ->where('phone', $phone)
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();

        if ($otp === null) {
            return false;
        }

        if (! Hash::check($plainCode, $otp->code)) {
            return false;
        }

        $otp->delete();
        $this->forgetDebugOtp($phone);

        return true;
    }

    protected function rememberDebugOtp(string $phone, string $plainCode): void
    {
        if (! config('sms.debug_show_otp')) {
            return;
        }

        Cache::put(
            $this->debugCacheKey($phone),
            $plainCode,
            now()->addMinutes(self::OTP_TTL_MINUTES),
        );
    }

    protected function forgetDebugOtp(string $phone): void
    {
        Cache::forget($this->debugCacheKey($phone));
    }

    protected function debugCacheKey(string $phone): string
    {
        return 'otp_debug:'.$phone;
    }

    protected function generateSixDigitCode(): string
    {
        return str_pad((string) random_int(0, 999_999), 6, '0', STR_PAD_LEFT);
    }
}
