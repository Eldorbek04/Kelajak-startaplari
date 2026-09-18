<header class="header-main">
    <div class="carousel-container">
        <div class="header-bottom">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="header-logo">
                        <a href="{{ url('/') }}" class="logo light" title="Bosh sahifa">
                            <img src="{{ asset('img/logo.png') }}" alt="Kelajak Startuplari">
                        </a>
                        <a href="{{ url('/') }}" title="Bosh sahifa" class="dark">
                            <img src="{{ asset('img/logo-dark.png') }}" alt="Kelajak Startuplari">
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <nav class="main-menu11 menu-style11" aria-label="Asosiy menyu">
                        <ul>
                            <li><a href="{{ url('/') }}">Bosh sahifa</a></li>
                            <li><a href="{{ url('/#yo-nalishlar') }}">Yo‘nalishlar</a></li>
                            <li><a href="{{ url('/#qadamlar') }}">Qadamlar</a></li>
                            <li><a href="{{ url('/#savollar') }}">Savollar</a></li>
                            {{-- <li><a href="{{ url('#ariza-topshirish') }}">Ariza topshirish</a></li> --}}
                        </ul>
                    </nav>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="header-btn d-flex flex-wrap align-items-center justify-content-end gap-2">
                        <a href="#" class="search-btn" aria-label="Qidiruv">
                            <img src="{{ asset('assets/images/icon/search.svg') }}" alt="">
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-style1">
                                P r o f i l  
                                <span>
                                    <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                                </span>
                            </a>
                            <form method="post" action="{{ route('logout') }}" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="btn-style1 v2 border-0" style="cursor: pointer;">
                                    Chiqish
                                </button>
                            </form>
                        @else
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn-style1 v2" style="padding: 0 10px 0 10px;">
                                    Kirish
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-style1">
                                    Ro‘yxatdan o‘tish
                                    <span>
                                        <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                                    </span>
                                </a>
                            @endif
                        @endauth
                        <button type="button" class="hamburger-btn" aria-label="Menyu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
