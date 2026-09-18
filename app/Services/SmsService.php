<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function __construct(
        protected string $baseUrl,
        protected string $apiKey,
        protected string $defaultFrom,
        protected bool $verifySsl,
    ) {
        $this->baseUrl = rtrim($this->baseUrl, '/');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getHeaders(): array
    {
        return [
            'X-API-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function http()
    {
        $pending = Http::withHeaders($this->getHeaders());

        if (! $this->verifySsl) {
            $pending = $pending->withoutVerifying();
        }

        return $pending;
    }

    /**
     * Raqamni API uchun 998XXXXXXXXX ko‘rinishiga keltiradi.
     */
    public function normalizeNumber(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number) ?? '';

        if (str_starts_with($digits, '998')) {
            return $digits;
        }

        if (str_starts_with($digits, '0')) {
            return '998'.ltrim($digits, '0');
        }

        if (strlen($digits) === 9 && str_starts_with($digits, '9')) {
            return '998'.$digits;
        }

        return '998'.ltrim($digits, '0');
    }

    protected function assertConfigured(): bool
    {
        if ($this->apiKey === '') {
            Log::warning('SMS: SMS_API_KEY sozlanmagan — xabar yuborilmadi.');

            return false;
        }

        return true;
    }

    /**
     * Bitta SMS yuborish.
     *
     * @return array<string, mixed>
     */
    public function send(string $number, string $message, ?string $from = null): array
    {
        if (! $this->assertConfigured()) {
            return [
                'success' => false,
                'message' => 'SMS API kaliti sozlanmagan.',
            ];
        }

        $phone = $this->normalizeNumber($number);

        try {
            $response = $this->http()->post($this->baseUrl.'/api/sms/send', [
                'phone' => $phone,
                'message' => $message,
                'from' => $from ?? $this->defaultFrom,
            ]);
        } catch (ConnectionException|RequestException $exception) {
            Log::warning('SMS yuborilmadi', [
                'phone' => $phone,
                'error' => $exception->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'SMS yuborilmadi.',
            ];
        }

        return $this->mapSingleResponse($response);
    }

    /**
     * @deprecated {@see send()} dan foydalaning
     *
     * @return array<string, mixed>
     */
    public function sendStudent(string $number, string $message): array
    {
        return $this->send($number, $message);
    }

    /**
     * To‘lov qabul qilindi haqida SMS.
     *
     * @return array<string, mixed>
     */
    public function sendReceip(string $number, string $name, string $summa, string $date, string $month, string|int $id): array
    {
        $message = "{$name} ga {$month} oyi uchun {$summa} so'm to'lov qabul qilindi. Sana {$date}";

        return $this->send($number, $message);
    }

    /**
     * Bir nechta foydalanuvchiga bir xil matn (batch).
     *
     * @param  iterable<int, object|string>  $users
     * @return array<string, mixed>
     */
    public function sendSMS(iterable $users, string $message): array
    {
        $messages = [];
        $index = 0;

        foreach ($users as $user) {
            $raw = is_object($user) ? ($user->phone ?? null) : $user;
            if ($raw === null || $raw === '') {
                continue;
            }

            $phone = $this->normalizeNumber((string) $raw);
            $messages[] = [
                'user_sms_id' => 'sms'.(++$index),
                'to' => $phone,
                'text' => $message,
            ];
        }

        return $this->postBatch($messages);
    }

    /**
     * @param  iterable<int, object|string>  $users
     * @return array<string, mixed>
     */
    public function sendSMSparents(iterable $users, string $message): array
    {
        return $this->sendSMS($users, $message);
    }

    /**
     * @param  iterable<int, object|string>  $users
     * @return array<string, mixed>
     */
    public function sendSmsSubject(iterable $users, string $message): array
    {
        $messages = [];
        $index = 0;

        foreach ($users as $user) {
            $phone = null;
            if (is_object($user) && isset($user->student)) {
                $phone = $user->student->phone ?? null;
            } elseif (is_object($user) && isset($user->phone)) {
                $phone = $user->phone;
            } elseif (is_string($user)) {
                $phone = $user;
            }

            if ($phone === null || $phone === '') {
                continue;
            }

            $phone = $this->normalizeNumber((string) $phone);
            $messages[] = [
                'user_sms_id' => 'sms'.(++$index),
                'to' => $phone,
                'text' => $message,
            ];
        }

        return $this->postBatch($messages);
    }

    /**
     * @param  iterable<int, object>  $students
     * @return array<string, mixed>
     */
    public function NotifyNotComeStudentParents(iterable $students): array
    {
        $messages = [];
        $date = date('d.m.Y');
        $index = 0;

        foreach ($students as $student) {
            $raw = $student->phone ?? '';
            if ($raw === '') {
                continue;
            }

            $phone = $this->normalizeNumber((string) $raw);
            $name = $student->name ?? '';
            $text = "Farzandingiz {$name} {$date} sanasida maktabga kelmadi. Ideal Study NTM";

            $messages[] = [
                'user_sms_id' => 'sms'.(++$index),
                'to' => $phone,
                'text' => $text,
            ];
        }

        return $this->postBatch($messages);
    }

    /**
     * @return array<string, mixed>
     */
    public function getSmsStatus(string $smsId): array
    {
        if (! $this->assertConfigured()) {
            return [
                'success' => false,
                'message' => 'SMS API kaliti sozlanmagan.',
            ];
        }

        $response = $this->http()->get($this->baseUrl.'/api/sms/status/'.$smsId);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'success' => false,
            'message' => 'Status olishda xatolik',
            'error' => $response->json(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTokenInfo(): array
    {
        if (! $this->assertConfigured()) {
            return [
                'success' => false,
                'message' => 'SMS API kaliti sozlanmagan.',
            ];
        }

        $response = $this->http()->get($this->baseUrl.'/api/sms/token-info');

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'success' => false,
            'message' => 'Token ma\'lumotlarini olishda xatolik',
            'error' => $response->json(),
        ];
    }

    /**
     * @param  list<array{user_sms_id: string, to: string, text: string}>  $messages
     * @return array<string, mixed>
     */
    protected function postBatch(array $messages): array
    {
        if ($messages === []) {
            return [
                'success' => false,
                'message' => 'Yuborish uchun xabar topilmadi',
            ];
        }

        if (! $this->assertConfigured()) {
            return [
                'success' => false,
                'message' => 'SMS API kaliti sozlanmagan.',
            ];
        }

        $data = [
            'messages' => $messages,
            'from' => $this->defaultFrom,
            'dispatch_id' => time(),
        ];

        $response = $this->http()->post($this->baseUrl.'/api/sms/send-batch', $data);

        if ($response->successful()) {
            /** @var array<string, mixed> $result */
            $result = $response->json();

            return [
                'status' => ($result['success'] ?? false) ? 'success' : 'error',
                'message' => (string) ($result['message'] ?? 'SMS yuborildi'),
                'data' => $result['data'] ?? null,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'SMS yuborishda xatolik',
            'error' => $response->json(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function mapSingleResponse(Response $response): array
    {
        if ($response->successful()) {
            /** @var array<string, mixed> $json */
            $json = $response->json();

            return $json;
        }

        return [
            'success' => false,
            'message' => 'SMS yuborishda xatolik',
            'error' => $response->json(),
        ];
    }
}
