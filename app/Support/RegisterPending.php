<?php

declare(strict_types=1);

namespace App\Support;

/**
 * Cache key for registration data between OTP send and verify steps.
 */
final class RegisterPending
{
    public static function cacheKey(string $sessionId): string
    {
        return 'register_pending:'.$sessionId;
    }
}
