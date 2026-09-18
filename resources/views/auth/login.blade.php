@extends('layouts.auth', ['hideAuthHeader' => true, 'hideAuthFooter' => true])

@section('title', 'Kirish — '.config('app.name'))

@section('auth-card')
    <div class="auth-card" data-aos="fade-up" data-aos-duration="700">
        <div class="auth-card-logo">
            <a href="{{ route('home') }}" title="Bosh sahifa">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="light">
                <img src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" class="dark">
            </a>
        </div>
        <h1 class="auth-card-title text-center">Kirish</h1>
        <p class="auth-card-sub text-center">Tanlov platformasiga telefon raqamingiz bilan kiring</p>

        <form action="{{ route('login') }}" method="post" novalidate data-require-password>
            @csrf

            <div class="auth-field" data-uz-phone>
                <label for="login_phone_display">Telefon raqam</label>
                <div class="auth-input-wrap auth-input-wrap--phone">
                    {{-- <img src="{{ asset('assets/images/icon/contact1-3.svg') }}" alt="" class="auth-input-icon" width="20" height="20"> --}}
                    <div class="auth-phone-combo @error('phone') is-invalid @enderror">
                        <span class="auth-phone-prefix">+998</span>
                        <input
                            type="text"
                            id="login_phone_display"
                            class="auth-phone-national-input"
                            inputmode="numeric"
                            autocomplete="tel"
                            placeholder="XX XXX XX XX"
                            aria-describedby="login_phone_hint"
                        >
                    </div>
                </div>
                <input type="hidden" name="phone" id="login_phone_hidden" value="{{ old('phone') }}">
                {{-- <p class="auth-phone-hint" id="login_phone_hint">9 ta raqam kiriting — format: +998 XX XXX XX XX</p> --}}
                @error('phone')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="login_password">Parol</label>
                <div class="auth-input-wrap auth-password-wrap">
                    <img src="{{ asset('assets/images/icon/lock.svg') }}" alt="" class="auth-input-icon" width="20" height="20">
                    <input
                        type="password"
                        id="login_password"
                        name="password"
                        class="form-control auth-input-pad auth-password-field @error('password') is-invalid @enderror"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        required
                    >
                    <button
                        type="button"
                        class="auth-password-toggle"
                        aria-label="Parolni ko‘rsatish"
                        aria-pressed="false"
                        data-label-show="Parolni ko‘rsatish"
                        data-label-hide="Parolni yashirish"
                    >
                        <svg class="auth-password-icon-show" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <svg class="auth-password-icon-hide" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" hidden>
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-style1 auth-submit-btn" disabled>
                Kirish
            </button>
        </form>

        <div class="auth-login-after-form">
            @if (Route::has('register'))
                <div class="d-flex justify-content-center">
                    <a href="{{ route('register') }}" class="btn-style1 v2">
                        Ro‘yxatdan o‘tish
                        <span>
                            <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                        </span>
                    </a>
                </div>
            @endif
            @if (Route::has('password.request'))
                <p class="mb-0 auth-tiklash-wrap">
                    <a href="{{ route('password.request') }}">Parolni tiklash</a>
                </p>
            @endif
        </div>
    </div>
@endsection
