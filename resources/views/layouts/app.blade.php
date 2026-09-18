<!doctype html>
<html class="no-js" lang="uz">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', config('app.name', 'Kelajak Startuplari'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        #preloader .preloader-logo {
            max-height: 56px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
    </style>
    @stack('styles')
</head>

<body class="crm-home">
    <a href="#" id="darkModeBtn" class="dark-active">
        <img src="{{ asset('assets/images/icon/moon.png') }}" alt="" class="moon" width="24" height="24">
        <img src="{{ asset('assets/images/icon/sun.png') }}" alt="" class="sun" width="24" height="24">
    </a>

    <div class="video-modal" id="videoModal" style="display:none;">
        <button type="button" class="video-close-btn" aria-label="Yopish">✕</button>
        <div class="video-modal-box">
            <iframe id="videoFrame2" width="560" height="315" allow="autoplay; encrypted-media" allowfullscreen
                style="border:0;"></iframe>
        </div>
    </div>

    <div id="preloader">
        <div class="loader">
            <img src="{{ asset('img/logo.png') }}" alt="" class="light preloader-logo" width="200" height="60">
            <img src="{{ asset('img/logo-dark.png') }}" alt="" class="dark preloader-logo" width="200" height="60">
        </div>
    </div>

    <div class="wrapper">
        <div class="mobile-menu">
            <div class="close-btn">
                <img src="{{ asset('assets/images/icon/xmark2.svg') }}" alt="">
            </div>
            <nav>
                <ul class="main-menu11 menu-style11">
                    <li><a href="{{ url('/') }}">Bosh sahifa</a></li>
                    <li><a href="{{ url('/#yo-nalishlar') }}">Yo‘nalishlar</a></li>
                    <li><a href="{{ url('/#qadamlar') }}">Qadamlar</a></li>
                    <li><a href="{{ url('/#savollar') }}">Savollar</a></li>
                    @auth
                        @if (Route::has('dashboard'))
                            <li><a href="{{ route('dashboard') }}">Kabinet</a></li>
                        @endif
                        <li>
                            <form method="post" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="border-0 bg-transparent p-0 text-start w-100" style="color: inherit; font: inherit;">Chiqish</button>
                            </form>
                        </li>
                    @else
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}">Kirish</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Ro‘yxatdan o‘tish</a></li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </div>
        <div class="menu-overlay"></div>

        <div class="search-popup">
            <form class="search-form" action="#" method="get">
                <input type="text" name="q" placeholder="Kalit so‘zlarni kiriting..." autocomplete="off">
                <button type="submit" class="submit-btn">
                    <img src="{{ asset('assets/images/icon/search.svg') }}" alt="">
                </button>
            </form>
        </div>
        <div class="search-overlay"></div>

        @yield('content')
    </div>

    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/aos.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
