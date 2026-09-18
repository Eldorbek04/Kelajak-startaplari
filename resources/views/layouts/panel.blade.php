<!doctype html>
<html class="h-full scroll-smooth" lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kabinet')</title>
    <script>
        (function () {
            try {
                if (localStorage.getItem('darkMode') === 'on') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/dashboard.css'])
    @stack('styles')
</head>
<body class="min-h-full bg-slate-50 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
    <button type="button"
            id="dashboardDarkModeBtn"
            class="fixed right-5 top-1/2 z-[70] flex h-[50px] w-[50px] -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border-0 bg-brand-900 p-0 shadow-md transition hover:brightness-110 dark:bg-white dark:shadow-slate-900/40 max-lg:top-[calc(50%-24px)]"
            aria-label="Kun va tun rejimini almashtirish">
        <img src="{{ asset('assets/images/icon/moon.png') }}" alt="" class="h-[30px] w-[30px] dark:hidden" width="24" height="24">
        <img src="{{ asset('assets/images/icon/sun.png') }}" alt="" class="hidden h-[30px] w-[30px] dark:block" width="24" height="24">
    </button>

    <div id="panelOverlay"
         class="fixed inset-0 z-40 hidden bg-slate-900/60 backdrop-blur-[2px] lg:hidden"
         aria-hidden="true"></div>

    <aside id="panelSidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[min(18rem,88vw)] -translate-x-full flex-col border-r border-slate-200 bg-white shadow-2xl transition-transform duration-200 ease-out dark:border-slate-800 dark:bg-slate-900 lg:hidden"
           aria-hidden="true">
        <div class="flex h-14 items-center justify-between border-b border-slate-200 px-4 dark:border-slate-800">
            <span class="text-sm font-bold text-slate-900 dark:text-white">Menyu</span>
            <button type="button"
                    id="panelSidebarClose"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                    aria-label="Menyuni yopish">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="border-b border-slate-200 p-4 dark:border-slate-800">
            <a href="{{ route('home') }}" class="inline-block" title="Bosh sahifa">
                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto dark:hidden">
                <img src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" class="hidden h-9 w-auto dark:block">
            </a>
        </div>

        <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-3" aria-label="Asosiy navigatsiya">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('dashboard') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    Profil
                </a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Admin panel
                    </a>
                    <a href="{{ route('admin.statistics.index') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.statistics.*') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                        Statistika
                    </a>
                    @if (auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.region-admins.index') }}"
                           class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.region-admins.*') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                            <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            Viloyat administratorlari
                        </a>
                    @endif
                @endif
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                        Kirish
                    </a>
                @endif
            @endauth

            @auth
                @if ($userHasApplicationSubmission ?? false)
                    <span class="flex cursor-default items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-400 dark:text-slate-500">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        Ariza topshirildi
                    </span>
                @else
                    <a href="{{ route('project.submit.form') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('project.submit.form') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Ariza topshirish
                    </a>
                @endif
            @else
                <a href="{{ route('project.submit.form') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    Ariza topshirish
                </a>
            @endauth

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Bosh sahifa
            </a>

            @guest
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800">
                        <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        Ro‘yxatdan o‘tish
                    </a>
                @endif
            @endguest
        </nav>

        @auth
            <div class="border-t border-slate-200 p-4 dark:border-slate-800">
                <p class="truncate text-sm font-semibold text-brand-900 dark:text-white">{{ auth()->user()->full_name }}</p>
                <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->phone }}</p>
                <form method="post" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-brand-900 to-brand-500 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-110">
                        Chiqish
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-3 gap-y-2 px-4 py-3 sm:px-6 lg:flex-nowrap lg:px-8">
                <button type="button"
                        id="panelSidebarToggle"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800 lg:hidden"
                        aria-controls="panelSidebar"
                        aria-expanded="false"
                        aria-label="Menyuni ochish">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <a href="{{ route('home') }}" class="hidden shrink-0 lg:block" title="Bosh sahifa">
                    <img src="{{ asset('img/logo.png') }}" alt="" class="h-8 w-auto dark:hidden">
                    <img src="{{ asset('img/logo-dark.png') }}" alt="" class="hidden h-8 w-auto dark:block">
                </a>

                {{-- <div class="min-w-0 flex-1 basis-[min(100%,12rem)] lg:basis-auto lg:max-w-md">
                    @unless (request()->routeIs('project.submit.form'))
                        <h1 class="truncate text-base font-bold text-slate-900 dark:text-white sm:text-lg">
                            @yield('panel_heading', 'Kabinet')
                        </h1>
                        @hasSection('panel_subheading')
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">@yield('panel_subheading')</p>
                        @endif
                    @endunless
                </div> --}}

                <div class="ml-auto flex shrink-0 items-center gap-2">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-brand-400 hover:text-brand-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-brand-500 dark:hover:text-white">
                        Bosh sahifa
                    </a>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="hidden rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-brand-400 hover:text-brand-800 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-brand-500 sm:inline-flex {{ request()->routeIs('admin.*') ? 'border-brand-400 text-brand-900 dark:border-brand-500 dark:text-white' : '' }}"
                               title="Admin panel">
                                Admin
                            </a>
                        @endif
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-brand-400 hover:bg-brand-500/10 hover:text-brand-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-brand-500 dark:hover:bg-brand-500/15 dark:hover:text-white {{ request()->routeIs('dashboard') ? 'border-brand-400 bg-brand-500/10 text-brand-900 dark:border-brand-500 dark:bg-brand-500/20 dark:text-white' : '' }}"
                           title="Kabinet"
                           aria-label="Kabinet">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>
                        <form method="post" action="{{ route('logout') }}" class="m-0 inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-rose-200 hover:text-rose-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-rose-900 dark:hover:text-rose-300">
                                Chiqish
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                               class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-brand-400 hover:bg-brand-500/10 hover:text-brand-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-brand-500 dark:hover:bg-brand-500/15 dark:hover:text-white"
                               title="Kirish"
                               aria-label="Kirish">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('dashboardDarkModeBtn');
            if (btn) {
                btn.addEventListener('click', function () {
                    var html = document.documentElement;
                    if (html.classList.contains('dark')) {
                        html.classList.remove('dark');
                        localStorage.setItem('darkMode', 'off');
                    } else {
                        html.classList.add('dark');
                        localStorage.setItem('darkMode', 'on');
                    }
                });
            }

            var sidebar = document.getElementById('panelSidebar');
            var overlay = document.getElementById('panelOverlay');
            var toggle = document.getElementById('panelSidebarToggle');
            var closeBtn = document.getElementById('panelSidebarClose');

            function isLarge() {
                return window.matchMedia('(min-width: 1024px)').matches;
            }

            function setSidebarOpen(open) {
                if (!sidebar || !overlay) {
                    return;
                }
                if (isLarge()) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    sidebar.setAttribute('aria-hidden', 'true');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                    return;
                }
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    sidebar.setAttribute('aria-hidden', 'false');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    sidebar.setAttribute('aria-hidden', 'true');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                }
            }

            if (toggle) {
                toggle.addEventListener('click', function () {
                    if (isLarge()) {
                        return;
                    }
                    var open = sidebar.classList.contains('-translate-x-full');
                    setSidebarOpen(open);
                });
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    setSidebarOpen(false);
                });
            }
            if (overlay) {
                overlay.addEventListener('click', function () {
                    setSidebarOpen(false);
                });
            }

            window.addEventListener('resize', function () {
                if (isLarge()) {
                    setSidebarOpen(false);
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !isLarge()) {
                    setSidebarOpen(false);
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
