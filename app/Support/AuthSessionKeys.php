<?php

namespace App\Support;

/**
 * Session keys for multi-step phone authentication flows.
 */
final class AuthSessionKeys
{
    public const PENDING_REGISTRATION = 'auth.pending_registration';

    public const PASSWORD_RESET_PHONE = 'auth.password_reset_phone';

    public const PASSWORD_RESET_VERIFIED = 'auth.password_reset_verified';

    public static function otpAttemptsKey(string $flow): string
    {
        return 'auth.otp_attempts.'.$flow;
    }
}
