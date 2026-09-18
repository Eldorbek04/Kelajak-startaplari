@extends('layouts.auth', ['hideAuthHeader' => true, 'hideAuthFooter' => true])

@section('title', 'Tasdiqlash — '.config('app.name'))

@push('styles')
    <style>
        .auth-otp-resend-area {
            text-align: center;
            margin-top: 1.1rem;
            font-size: 0.9rem;
        }
        .auth-otp-resend-btn[disabled] {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        .auth-otp-debug-code {
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dc2626;
            background: #fef2f2;
            color: #dc2626;
            font-size: 0.95rem;
            font-weight: 700;
            text-align: center;
            letter-spacing: 0.08em;
        }
        .crm-home.active .auth-otp-debug-code {
            background: rgba(220, 38, 38, 0.12);
            border-color: #f87171;
            color: #fca5a5;
        }
        .crm-home.active .auth-otp-resend-area .text-muted {
            color: rgba(255, 255, 255, 0.62) !important;
        }
    </style>
@endpush

@section('auth-card')
    <div class="auth-card" data-aos="fade-up" data-aos-duration="700">
        <div class="auth-card-logo">
            <a href="{{ route('home') }}" title="Bosh sahifa">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="light">
                <img src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" class="dark">
            </a>
        </div>
        <h1 class="auth-card-title text-center">Telefonni tasdiqlang</h1>
        <p class="auth-card-sub text-center">
            @if (! empty($maskedPhone))
                <span class="d-block">{{ $maskedPhone }}</span>
            @endif
            Raqamingizga yuborilgan 6 raqamli kodni kiriting.
        </p>

        @if (session('status'))
            <p class="alert alert-success py-2 px-3 rounded small mb-3" role="status">{{ session('status') }}</p>
        @endif

        @if (session('otp_throttle'))
            <p class="alert alert-warning py-2 px-3 rounded small mb-3" role="status">{{ session('otp_throttle') }}</p>
        @endif

        @error('resend')
            <p class="alert alert-warning py-2 px-3 rounded small mb-3" role="alert">{{ $message }}</p>
        @enderror

        @if (! empty($debugOtpCode))
            <p class="auth-otp-debug-code" role="status">
                DEBUG — SMS kodi: {{ $debugOtpCode }}
            </p>
        @endif

        <form action="{{ route('register.verify') }}" method="post" novalidate>
            @csrf

            <div class="auth-field">
                <label for="register_otp_code">Tasdiqlash kodi</label>
                <div class="auth-input-wrap">
                    <img src="{{ asset('assets/images/icon/lock.svg') }}" alt="" class="auth-input-icon" width="20" height="20">
                    <input
                        type="text"
                        id="register_otp_code"
                        name="code"
                        value="{{ old('code') }}"
                        class="form-control auth-input-pad @error('code') is-invalid @enderror"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="••••••"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                    >
                </div>
                @error('code')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-style1 auth-submit-btn">
                Tasdiqlash va davom etish
            </button>
        </form>

        <div class="auth-otp-resend-area">
            <span
                id="otp-resend-wait-line"
                class="text-muted small d-block mb-1 @if ($otpResendAvailableAt === null) d-none @endif"
            >
                Qayta yuborish: <strong id="otp-resend-countdown" data-resend-at="{{ $otpResendAvailableAt?->toIso8601String() ?? '' }}">2:00</strong>
            </span>
            <form action="{{ route('register.verify.resend') }}" method="post" class="d-inline">
                @csrf
                <button
                    type="submit"
                    id="otp-resend-btn"
                    class="btn btn-link p-0 small fw-semibold auth-otp-resend-btn"
                    style="vertical-align: baseline;"
                    @if ($otpResendAvailableAt !== null) disabled @endif
                >
                    Kodni qayta yuborish
                </button>
            </form>
        </div>

        <div class="auth-links">
            <p class="mb-0">
                <a href="{{ route('register') }}">Orqaga — ma’lumotlarni o‘zgartirish</a>
            </p>
            <p class="mb-0 mt-2">
                Akkauntingiz bormi?
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Kirish</a>
                @endif
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var btn = document.getElementById('otp-resend-btn');
            var waitLine = document.getElementById('otp-resend-wait-line');
            var countdownEl = document.getElementById('otp-resend-countdown');
            if (! btn || ! countdownEl) {
                return;
            }
            var iso = countdownEl.getAttribute('data-resend-at') || '';
            if (! iso) {
                btn.disabled = false;
                if (waitLine) {
                    waitLine.classList.add('d-none');
                }

                return;
            }
            var targetMs = Date.parse(iso);
            if (Number.isNaN(targetMs)) {
                btn.disabled = false;
                if (waitLine) {
                    waitLine.classList.add('d-none');
                }

                return;
            }

            function tick() {
                var ms = targetMs - Date.now();
                if (ms <= 0) {
                    btn.disabled = false;
                    countdownEl.textContent = '';
                    if (waitLine) {
                        waitLine.classList.add('d-none');
                    }

                    return;
                }
                btn.disabled = true;
                if (waitLine) {
                    waitLine.classList.remove('d-none');
                }
                var sec = Math.ceil(ms / 1000);
                var m = Math.floor(sec / 60);
                var s = sec % 60;
                countdownEl.textContent = m + ':' + String(s).padStart(2, '0');
                window.setTimeout(tick, 250);
            }
            tick();
        })();
    </script>
@endpush
