<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\User;
use App\Services\Otp\OtpService;
use App\Support\RegisterPending;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+998[0-9]{9}$/'],
            'password' => ['required', 'string'],
        ], [
            'phone.required' => 'Telefon raqamni to‘liq kiriting.',
            'phone.regex' => 'Telefon +998 bilan boshlanib, 9 ta raqamdan iborat bo‘lishi kerak.',
            'password.required' => 'Parolni kiriting.',
        ]);

        if (! Auth::attempt(['phone' => $credentials['phone'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'phone' => 'Telefon yoki parol noto‘g‘ri.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

public function register(RegisterRequest $request): RedirectResponse
{
    $validated = $request->validated();

    if (User::query()->where('phone', $validated['phone'])->exists()) {
        throw ValidationException::withMessages([
            'phone' => 'Bu telefon raqam bilan akkaunt allaqachon mavjud.',
        ]);
    }

    $user = User::query()->create([
        'full_name' => (string) $validated['full_name'],
        'phone' => $validated['phone'],
        'password' => bcrypt($validated['password']),
    ]);

    Auth::login($user);

    $request->session()->regenerate();

    return redirect()->route('dashboard');
}

    public function showRegisterVerifyForm(Request $request, OtpService $otp): View|RedirectResponse
    {
        $pending = Cache::get(RegisterPending::cacheKey($request->session()->getId()));

        if ($pending === null || ! is_array($pending) || empty($pending['phone'])) {
            return redirect()
                ->route('register')
                ->with('register_verify_expired', true);
        }

        $phone = (string) $pending['phone'];
        $resendAt = $otp->resendAvailableAt($phone);

        return view('auth.register-verify', [
            'maskedPhone' => $this->maskPhone($phone),
            'otpResendAvailableAt' => $resendAt,
            'debugOtpCode' => $otp->debugCodeForPhone($phone),
        ]);
    }

    public function registerResendOtp(Request $request, OtpService $otp): RedirectResponse
    {
        $key = RegisterPending::cacheKey($request->session()->getId());
        $pending = Cache::get($key);

        if ($pending === null || ! is_array($pending) || empty($pending['phone'])) {
            return redirect()
                ->route('register')
                ->with('register_verify_expired', true);
        }

        $phone = (string) $pending['phone'];
        $wait = $otp->secondsUntilResendAllowed($phone);

        if ($wait > 0) {
            return redirect()
                ->route('register.verify')
                ->withErrors([
                    'resend' => sprintf(
                        'Kodni qayta yuborish uchun %s kuting.',
                        OtpService::formatCooldownClock($wait)
                    ),
                ]);
        }

        $otp->sendRegistrationOtp($phone);

        return redirect()
            ->route('register.verify')
            ->with('status', 'Yangi tasdiqlash kodi yuborildi.');
    }

    public function registerVerify(VerifyOtpRequest $request, OtpService $otp): RedirectResponse
    {
        $key = RegisterPending::cacheKey($request->session()->getId());
        $pending = Cache::get($key);

        if ($pending === null || ! is_array($pending)) {
            return redirect()
                ->route('register')
                ->with('register_verify_expired', true);
        }

        $phone = (string) $pending['phone'];
        $code = $request->validated('code');

        if (! $otp->verify($phone, $code)) {
            Cache::put($key, $pending, now()->addMinutes(15));

            throw ValidationException::withMessages([
                'code' => 'Kod noto‘g‘ri yoki muddati o‘tgan.',
            ]);
        }

        Cache::forget($key);

        $user = User::query()->create([
            'full_name' => (string) $pending['full_name'],
            'phone' => $phone,
            'password' => (string) $pending['password'],
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    private function maskPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) < 4) {
            return $phone;
        }

        $tail = substr($digits, -4);

        return '+998 ** *** ** '.$tail;
    }
}
