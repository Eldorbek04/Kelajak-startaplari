{{-- Kabinet: qisqa header — logo, foydalanuvchi, bosh sahifa, chiqish --}}
<header class="header-main">
    <div class="carousel-container">
        <div class="header-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1" style="min-width: 0;">
                    <div class="header-logo flex-shrink-0">
                        <a href="{{ route('home') }}" class="logo light" title="Bosh sahifa">
                            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}">
                        </a>
                        <a href="{{ route('home') }}" title="Bosh sahifa" class="dark">
                            <img src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}">
                        </a>
                    </div>
                    <div class="dashboard-header-user" style="min-width: 0;">
                        <strong class="d-block text-truncate" style="font-size: 1rem; line-height: 1.3;">{{ auth()->user()->full_name }}</strong>
                        <span class="d-block small" style="opacity: 0.75; font-size: 0.875rem;">{{ auth()->user()->phone }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="{{ route('home') }}" class="btn-style1 v2">
                        Bosh sahifa
                    </a>
                    <form method="post" action="{{ route('logout') }}" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="btn-style1 border-0" style="cursor: pointer;">
                            Chiqish
                        </button>
                    </form>
                    <button type="button" class="hamburger-btn d-lg-none" aria-label="Menyu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
