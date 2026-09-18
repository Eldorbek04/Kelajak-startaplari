<!doctype html>
<html class="h-full scroll-smooth" lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
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
    @vite(['resources/css/admin.css'])
    @stack('styles')
</head>
<body class="min-h-full bg-slate-100 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
    <button type="button"
            id="adminDarkModeBtn"
            class="fixed right-5 top-1/2 z-[90] flex h-[50px] w-[50px] -translate-y-1/2 cursor-pointer items-center justify-center rounded-full border-0 bg-brand-900 p-0 shadow-md transition hover:brightness-110 dark:bg-white dark:shadow-slate-900/40 max-lg:top-[calc(50%-24px)]"
            aria-label="Kun va tun rejimini almashtirish">
        <img src="{{ asset('assets/images/icon/moon.png') }}" alt="" class="h-[30px] w-[30px] dark:hidden" width="24" height="24">
        <img src="{{ asset('assets/images/icon/sun.png') }}" alt="" class="hidden h-[30px] w-[30px] dark:block" width="24" height="24">
    </button>

    <div id="adminOverlay"
         class="fixed inset-0 z-40 hidden bg-slate-900/60 backdrop-blur-[2px] lg:hidden"
         aria-hidden="true"></div>

    <aside id="adminSidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[min(18rem,88vw)] -translate-x-full flex-col border-r border-slate-200 bg-white shadow-xl transition-transform duration-200 ease-out dark:border-slate-800 dark:bg-slate-900 lg:translate-x-0"
           aria-label="Admin menyusi">
        <div class="flex h-16 items-center justify-between border-b border-slate-200 px-4 dark:border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-slate-900 dark:text-white">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-400 text-sm font-bold text-white">A</span>
                <span class="text-sm leading-tight">Admin panel</span>
            </a>
            <button type="button"
                    id="adminSidebarClose"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden"
                    aria-label="Menyuni yopish">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-3">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                </svg>
                Boshqaruv paneli
            </a>
            <a href="{{ route('admin.statistics.index') }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.statistics.*') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Statistika
            </a>
            <a href="{{ route('admin.projects.index') }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.projects.*') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Loyihalar
            </a>
            @if (auth()->user()?->isSuperAdmin())
                <a href="{{ route('admin.region-admins.index') }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs('admin.region-admins.*') ? 'bg-brand-500/15 text-brand-900 dark:bg-brand-500/20 dark:text-white' : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-800' }}">
                    <svg class="h-5 w-5 shrink-0 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Viloyat administratorlari
                </a>
            @endif
        </nav>

        <div class="border-t border-slate-200 p-4 dark:border-slate-800">
            <a href="{{ route('dashboard') }}"
               class="mb-2 flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800">
                ← Foydalanuvchi kabineti
            </a>
            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->full_name }}</p>
            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->phone }}</p>
            <form method="post" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-brand-900 to-brand-500 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-110">
                    Chiqish
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="flex flex-wrap items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <button type="button"
                        id="adminSidebarToggle"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800 lg:hidden"
                        aria-controls="adminSidebar"
                        aria-expanded="false"
                        aria-label="Menyuni ochish">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="min-w-0 flex-1">
                    <h1 class="truncate text-lg font-bold text-slate-900 dark:text-white">@yield('admin_heading', 'Admin')</h1>
                    @hasSection('admin_subheading')
                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">@yield('admin_subheading')</p>
                    @endif
                </div>
                <div class="hidden items-center gap-3 sm:flex">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300">{{ auth()->user()->full_name }}</span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-rose-200 hover:text-rose-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:border-rose-900 dark:hover:text-rose-300">
                            Chiqish
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 dark:border-emerald-900/50 dark:bg-emerald-950/50 dark:text-emerald-200"
                     role="status">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900 dark:border-rose-900/50 dark:bg-rose-950/50 dark:text-rose-100"
                     role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('adminDarkModeBtn');
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

            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminOverlay');
            var toggle = document.getElementById('adminSidebarToggle');
            var closeBtn = document.getElementById('adminSidebarClose');

            function isLarge() {
                return window.matchMedia('(min-width: 1024px)').matches;
            }

            function setSidebarOpen(open) {
                if (!sidebar || !overlay) {
                    return;
                }
                if (isLarge()) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    return;
                }
                if (open) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
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
                if (e.key === 'Escape') {
                    if (!isLarge()) {
                        setSidebarOpen(false);
                    }
                    document.querySelectorAll('[data-admin-modal].flex').forEach(function (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                    document.body.classList.remove('overflow-hidden');
                }
            });

            document.querySelectorAll('[data-admin-open]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-admin-open');
                    var el = id ? document.getElementById(id) : null;
                    if (el) {
                        el.classList.remove('hidden');
                        el.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                    }
                });
            });

            document.querySelectorAll('[data-admin-modal-close]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var modal = btn.closest('[data-admin-modal]');
                    if (modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });

            document.querySelectorAll('[data-admin-modal]').forEach(function (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
