@extends('layouts.app')

@push('styles')
    <style>
        .auth-page-sec {
            position: relative;
            min-height: 70vh;
            padding-bottom: 3rem;
        }
        .auth-page-sec .auth-page-gradient {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(ellipse 85% 55% at 50% -15%, rgba(245, 48, 3, 0.14), transparent 55%),
                radial-gradient(ellipse 50% 40% at 95% 40%, rgba(245, 48, 3, 0.08), transparent 50%),
                radial-gradient(ellipse 45% 35% at 5% 60%, rgba(99, 102, 241, 0.06), transparent 45%);
        }
        .crm-home.active .auth-page-sec .auth-page-gradient {
            background:
                radial-gradient(ellipse 85% 55% at 50% -15%, rgba(255, 107, 74, 0.18), transparent 55%),
                radial-gradient(ellipse 50% 40% at 95% 40%, rgba(255, 107, 74, 0.1), transparent 50%);
        }
        .auth-page-sec .auth-page-inner {
            position: relative;
            z-index: 1;
            padding-top: 2.5rem;
            padding-bottom: 2rem;
        }
        @media (min-width: 992px) {
            .auth-page-sec .auth-page-inner {
                padding-top: 3.5rem;
            }
        }
        .auth-page-sec--no-header .auth-page-inner {
            padding-top: 4rem;
        }
        @media (min-width: 992px) {
            .auth-page-sec--no-header .auth-page-inner {
                padding-top: 5.5rem;
            }
        }
        .auth-card {
            border-radius: 18px;
            padding: 2rem 1.75rem;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.04);
            background: var(--auth-card-bg, #fff);
            transition: box-shadow 0.28s ease, transform 0.28s ease;
        }
        .crm-home.active .auth-card {
            --auth-card-bg: rgba(22, 22, 21, 0.92);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.92);
        }
        .auth-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(245, 48, 3, 0.12);
        }
        .crm-home.active .auth-card:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 107, 74, 0.15);
        }
        .auth-card-logo {
            text-align: center;
            margin-bottom: 1.35rem;
        }
        .auth-card-logo a {
            display: inline-block;
            line-height: 0;
        }
        .auth-card-logo img {
            height: 52px;
            width: auto;
            max-width: 220px;
            object-fit: contain;
        }
        @media (min-width: 768px) {
            .auth-card-logo img {
                height: 60px;
                max-width: 260px;
            }
        }
        .auth-card .auth-card-title {
            font-size: 1.65rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
            letter-spacing: -0.02em;
        }
        .auth-card .auth-card-sub {
            font-size: 0.95rem;
            opacity: 0.78;
            margin-bottom: 1.75rem;
        }
        .auth-field {
            margin-bottom: 1.25rem;
        }
        .auth-field label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }
        .auth-input-wrap {
            position: relative;
        }
        .auth-input-wrap .auth-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            opacity: 0.55;
            pointer-events: none;
        }
        .auth-input-wrap textarea ~ .auth-input-icon {
            top: 1rem;
            transform: none;
        }
        .auth-input-wrap .form-control.auth-input-pad {
            padding-left: 2.75rem;
        }
        .auth-password-wrap .form-control.auth-input-pad {
            padding-right: 2.75rem;
        }
        .auth-password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            padding: 0.35rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.55;
            line-height: 0;
            border-radius: 6px;
            transition: opacity 0.2s ease, background 0.2s ease;
        }
        .auth-password-toggle:hover {
            opacity: 0.95;
            background: rgba(0, 0, 0, 0.05);
        }
        .crm-home.active .auth-page-sec .auth-card .auth-password-toggle {
            color: rgba(255, 255, 255, 0.82);
            opacity: 1;
        }
        .crm-home.active .auth-password-toggle:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .auth-password-toggle:focus-visible {
            outline: 2px solid rgba(245, 48, 3, 0.5);
            outline-offset: 2px;
        }
        .crm-home.active .auth-password-toggle:focus-visible {
            outline-color: rgba(255, 138, 106, 0.65);
        }
        .auth-password-toggle svg {
            display: block;
        }
        .auth-card .form-control {
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.12);
            padding: 0.7rem 1rem;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .auth-card .form-control:focus {
            border-color: rgba(245, 48, 3, 0.55);
            box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.12);
            outline: none;
        }
        .crm-home.active .auth-card .form-control {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.12);
            color: inherit;
        }
        .crm-home.active .auth-card .form-control:focus {
            border-color: rgba(255, 107, 74, 0.6);
            box-shadow: 0 0 0 3px rgba(255, 107, 74, 0.15);
        }
        .auth-card .invalid-feedback {
            display: block;
            margin-top: 0.35rem;
            font-size: 0.875rem;
            color: #dc2626;
        }
        .auth-card .btn-style1.auth-submit-btn {
            width: 100%;
            justify-content: center;
            margin-top: 0.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .auth-card .btn-style1.auth-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245, 48, 3, 0.25);
        }
        .auth-card .auth-links {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            font-size: 0.95rem;
            text-align: center;
        }
        .crm-home.active .auth-card .auth-links {
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        .auth-card .auth-links a {
            color: #f53003;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .auth-card .auth-links a:hover {
            opacity: 0.85;
            text-decoration: underline;
        }
        .crm-home.active .auth-card .auth-links a {
            color: #ff8a6a;
        }
        .auth-card .auth-links-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.35rem 1rem;
        }
        .auth-login-after-form {
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }
        .crm-home.active .auth-login-after-form {
            border-top-color: rgba(255, 255, 255, 0.08);
        }
        .auth-login-after-form .auth-tiklash-wrap {
            margin-top: 1.15rem;
            text-align: center;
            font-size: 0.95rem;
        }
        .auth-login-after-form .auth-tiklash-wrap a {
            color: #f53003;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .auth-login-after-form .auth-tiklash-wrap a:hover {
            text-decoration: underline;
            opacity: 0.88;
        }
        .crm-home.active .auth-login-after-form .auth-tiklash-wrap a {
            color: #ff8a6a;
        }
        .auth-input-wrap--phone .auth-phone-combo {
            display: flex;
            align-items: center;
            flex: 1;
            width: 100%;
            /* margin-left: 2.75rem; */
            border: 1px solid rgba(0, 0, 0, 0.12);
            border-radius: 10px;
            padding: 0.65rem 1rem;
            background: var(--auth-card-bg, #fff);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .crm-home.active .auth-input-wrap--phone .auth-phone-combo {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.12);
        }
        .auth-input-wrap--phone .auth-phone-combo:focus-within {
            border-color: rgba(245, 48, 3, 0.55);
            box-shadow: 0 0 0 3px rgba(245, 48, 3, 0.12);
        }
        .crm-home.active .auth-input-wrap--phone .auth-phone-combo:focus-within {
            border-color: rgba(255, 107, 74, 0.6);
            box-shadow: 0 0 0 3px rgba(255, 107, 74, 0.15);
        }
        .auth-input-wrap--phone .auth-phone-combo.is-invalid {
            border-color: #dc2626 !important;
        }
        .auth-phone-prefix {
            font-weight: 700;
            font-size: 1rem;
            opacity: 0.88;
            user-select: none;
            white-space: nowrap;
            padding-right: 0.35rem;
            letter-spacing: 0.02em;
        }
        .auth-phone-national-input {
            flex: 1;
            min-width: 0;
            border: none !important;
            background: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
            font-size: 1rem;
        }
        .auth-phone-national-input:focus {
            outline: none;
            box-shadow: none !important;
        }
        .auth-phone-hint {
            font-size: 0.8125rem;
            opacity: 0.72;
            margin-top: 0.4rem;
            margin-bottom: 0;
        }
        .crm-home.active .auth-page-sec .auth-card label {
            color: rgba(255, 255, 255, 0.9);
        }
        .crm-home.active .auth-page-sec .auth-card .auth-input-icon {
            opacity: 0.88;
            filter: brightness(0) invert(1);
        }
        .crm-home.active .auth-page-sec .auth-card .form-control::placeholder,
        .crm-home.active .auth-page-sec .auth-card .auth-phone-national-input::placeholder {
            color: rgba(255, 255, 255, 0.42);
            opacity: 1;
        }
        .crm-home.active .auth-page-sec .auth-card .auth-phone-prefix {
            color: rgba(255, 255, 255, 0.92);
            opacity: 1;
        }
        .crm-home.active .auth-page-sec .auth-card .invalid-feedback {
            color: #fca5a5;
        }
        .auth-card .btn-style1.auth-submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
            pointer-events: none;
        }
    </style>
@endpush

@section('content')
    <section class="main-sec auth-page-sec @if ($hideAuthHeader ?? false) auth-page-sec--no-header @endif">
        <div class="anim-img">
            <img src="{{ asset('assets/images/event/bg1-1.png') }}" alt="" class="layer1 light">
            <img src="{{ asset('assets/images/event/bg1-1-dark.png') }}" alt="" class="layer1 dark">
            <img src="{{ asset('assets/images/event/bg1-2.png') }}" alt="" class="layer2 light">
            <img src="{{ asset('assets/images/event/bg1-2-dark.png') }}" alt="" class="layer2 dark">
        </div>
        <div class="auth-page-gradient" aria-hidden="true"></div>

        @unless ($hideAuthHeader ?? false)
            @include('layouts.partials.site-header')
        @endunless

        <div class="auth-page-inner">
            <div class="carousel-container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7 col-sm-10">
                        @yield('auth-card')
                    </div>
                </div>
            </div>
        </div>
    </section>

    @unless ($hideAuthFooter ?? false)
        <section class="main-sec3">
            @include('layouts.partials.site-footer')
        </section>
    @endunless
@endsection

@push('scripts')
    <script>
        (function () {
            function onlyNine(v) {
                return String(v || '').replace(/\D/g, '').slice(0, 9);
            }

            function formatUZ9(v) {
                const d = onlyNine(v);
                if (d.length === 0) {
                    return '';
                }
                let s = d.slice(0, 2);
                if (d.length > 2) {
                    s += ' ' + d.slice(2, 5);
                }
                if (d.length > 5) {
                    s += ' ' + d.slice(5, 7);
                }
                if (d.length > 7) {
                    s += ' ' + d.slice(7, 9);
                }
                return s;
            }

            function nationalFromHidden(hidden) {
                const hv = String(hidden.value || '').replace(/\D/g, '');
                if (hv.startsWith('998') && hv.length >= 12) {
                    return hv.slice(3, 12);
                }
                if (hv.length === 9 && hv.startsWith('9')) {
                    return hv;
                }

                return '';
            }

            function updateSubmitForForm(form) {
                if (! form) {
                    return;
                }
                const btn = form.querySelector('button[type="submit"]');
                if (! btn) {
                    return;
                }
                const phoneWrap = form.querySelector('[data-uz-phone]');
                let phoneOk = true;
                if (phoneWrap) {
                    const display = phoneWrap.querySelector('.auth-phone-national-input');
                    const raw = onlyNine(display ? display.value : '');
                    phoneOk = raw.length === 9;
                }
                let passwordOk = true;
                if (form.hasAttribute('data-require-password')) {
                    const pw = form.querySelector('input[name="password"]');
                    passwordOk = (pw && pw.value.trim().length > 0);
                }
                btn.disabled = ! (phoneOk && passwordOk);
            }

            function sync(wrap) {
                const display = wrap.querySelector('.auth-phone-national-input');
                const hidden = wrap.querySelector('input[type="hidden"][name="phone"]');
                const form = wrap.closest('form');
                if (! display || ! hidden) {
                    return;
                }
                const raw = onlyNine(display.value);
                display.value = formatUZ9(display.value);
                hidden.value = raw.length === 9 ? ('+998' + raw) : '';
                updateSubmitForForm(form);
            }

            function init(wrap) {
                const display = wrap.querySelector('.auth-phone-national-input');
                const hidden = wrap.querySelector('input[type="hidden"][name="phone"]');
                const form = wrap.closest('form');
                if (! display || ! hidden || ! form) {
                    return;
                }
                let d = nationalFromHidden(hidden);
                display.value = formatUZ9(d);
                sync(wrap);
                display.addEventListener('input', function () {
                    sync(wrap);
                });
                display.addEventListener('blur', function () {
                    sync(wrap);
                });
                if (form.hasAttribute('data-require-password')) {
                    const pw = form.querySelector('input[name="password"]');
                    if (pw) {
                        pw.addEventListener('input', function () {
                            updateSubmitForForm(form);
                        });
                        pw.addEventListener('change', function () {
                            updateSubmitForForm(form);
                        });
                    }
                }
                form.addEventListener('submit', function (e) {
                    const raw = onlyNine(display.value);
                    hidden.value = raw.length === 9 ? ('+998' + raw) : '';
                    if (raw.length !== 9) {
                        e.preventDefault();

                        return;
                    }
                    if (form.hasAttribute('data-require-password')) {
                        const pwField = form.querySelector('input[name="password"]');
                        if (! pwField || pwField.value.trim().length === 0) {
                            e.preventDefault();
                        }
                    }
                });
            }

            function initPasswordToggles() {
                document.querySelectorAll('.auth-password-wrap').forEach(function (wrap) {
                    const input = wrap.querySelector('.auth-password-field');
                    const btn = wrap.querySelector('.auth-password-toggle');
                    if (! input || ! btn) {
                        return;
                    }
                    const labelShow = btn.getAttribute('data-label-show') || 'Parolni ko‘rsatish';
                    const labelHide = btn.getAttribute('data-label-hide') || 'Parolni yashirish';
                    const iconShow = btn.querySelector('.auth-password-icon-show');
                    const iconHide = btn.querySelector('.auth-password-icon-hide');
                    btn.addEventListener('click', function () {
                        const showPlain = input.type === 'password';
                        input.type = showPlain ? 'text' : 'password';
                        btn.setAttribute('aria-pressed', showPlain ? 'true' : 'false');
                        btn.setAttribute('aria-label', showPlain ? labelHide : labelShow);
                        if (iconShow && iconHide) {
                            iconShow.hidden = showPlain;
                            iconHide.hidden = ! showPlain;
                        }
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-uz-phone]').forEach(init);
                initPasswordToggles();
            });
        })();
    </script>
@endpush
