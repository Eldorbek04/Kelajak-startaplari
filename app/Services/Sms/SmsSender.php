<?php

declare(strict_types=1);

namespace App\Services\Sms;

use App\Services\SmsService;
use Illuminate\Support\Facades\Log;

/**
 * Tanlov ilovasidan SMS yuborish — {@see SmsService} orqali.
 */
class SmsSender
{
    public function __construct(
        private readonly SmsService $smsService,
    ) {}

    public function send(string $phone, string $message): void
    {
        $result = $this->smsService->send($phone, $message);

        $failed = isset($result['success']) && $result['success'] === false;

        if ($failed) {
            Log::warning('SMS yuborilmadi', [
                'phone' => $phone,
                'result' => $result,
            ]);
        }
    }
}
