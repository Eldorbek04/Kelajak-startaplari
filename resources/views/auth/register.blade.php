@extends('layouts.auth', ['hideAuthHeader' => true, 'hideAuthFooter' => true])

@section('title', 'Ro‘yxatdan o‘tish — '.config('app.name'))

@section('auth-card')
    <div class="auth-card" data-aos="fade-up" data-aos-duration="700">
        <div class="auth-card-logo">
            <a href="{{ route('home') }}" title="Bosh sahifa">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="light">
                <img src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" class="dark">
            </a>
        </div>
        <h1 class="auth-card-title text-center">Ro‘yxatdan o‘tish</h1>
        {{-- <p class="auth-card-sub text-center">Startap tanlovida ishtirok etish uchun akkaunt yarating</p> --}}

        @if (session('register_verify_expired'))
            <p class="alert alert-warning py-2 px-3 rounded small mb-3" role="alert">
                Ro‘yxatdan o‘tish vaqti tugadi yoki sessiya yangilandi. Ma’lumotlarni qayta kiriting.
            </p>
        @endif

        <form action="{{ route('register') }}" method="post" novalidate>
            @csrf

            <div class="auth-field">
                <label for="register_full_name">To‘liq ism familiya</label>
                <div class="auth-input-wrap">
                    {{-- <img src="{{ asset('assets/images/icon/user.svg') }}" alt="" class="auth-input-icon" width="20" height="20"> --}}
                    <input
                        type="text"
                        id="register_full_name"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        class="form-control @error('full_name') is-invalid @enderror"
                        autocomplete="name"
                        placeholder="Ism familiyangiz"
                        required
                    >
                </div>
                @error('full_name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field" data-uz-phone>
                <label for="register_phone_display">Telefon raqam</label>
                <div class="auth-input-wrap auth-input-wrap--phone">
                    {{-- <img src="{{ asset('assets/images/icon/contact1-3.svg') }}" alt="" class="auth-input-icon" width="20" height="20"> --}}
                    <div class="auth-phone-combo @error('phone') is-invalid @enderror">
                        <span class="auth-phone-prefix">+998</span>
                        <input
                            type="text"
                            id="register_phone_display"
                            class="auth-phone-national-input"
                            inputmode="numeric"
                            autocomplete="tel"
                            placeholder="XX XXX XX XX"
                            aria-describedby="register_phone_hint"
                        >
                    </div>
                </div>
                <input type="hidden" name="phone" id="register_phone_hidden" value="{{ old('phone') }}">
                {{-- <p class="auth-phone-hint" id="register_phone_hint">9 ta raqam kiriting — format: +998 XX XXX XX XX</p> --}}
                @error('phone')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="register_password">Parol</label>
                <div class="auth-input-wrap">
                    <img src="{{ asset('assets/images/icon/lock.svg') }}" alt="" class="auth-input-icon" width="20" height="20">
                    <input
                        type="password"
                        id="register_password"
                        name="password"
                        class="form-control auth-input-pad @error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        placeholder="Kamida 8 belgi"
                        required
                    >
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="auth-field">
                <label for="register_password_confirmation">Parolni qayta kiriting</label>
                <div class="auth-input-wrap">
                    <img src="{{ asset('assets/images/icon/check1-1.svg') }}" alt="" class="auth-input-icon" width="20" height="20">
                    <input
                        type="password"
                        id="register_password_confirmation"
                        name="password_confirmation"
                        class="form-control auth-input-pad @error('password_confirmation') is-invalid @enderror"
                        autocomplete="new-password"
                        placeholder="Parolni takrorlang"
                        required
                    >
                </div>
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-style1 auth-submit-btn" disabled>
                Ro‘yxatdan o‘tish
                <span><img src="{{ asset('assets/images/icon/arrow.svg') }}" alt=""></span>
            </button>
        </form>

        <div class="auth-links">
            <p class="mb-0">
                Akkauntingiz bormi?
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Kirish</a>
                @endif
            </p>
        </div>
    </div>
@endsection
