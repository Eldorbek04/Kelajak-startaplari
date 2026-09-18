@extends('layouts.panel')

@section('title', 'Kabinet — '.config('app.name'))

@section('panel_heading', 'Kabinet')
@section('panel_subheading', 'Tanlov va arizalar')

@section('content')
    @if (session('project_submitted'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 dark:border-emerald-900/50 dark:bg-emerald-950/50 dark:text-emerald-200"
             role="status">
            {{ session('project_submitted') }}
        </div>
    @endif
    @if (session('already_submitted'))
        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-900 dark:border-amber-900/50 dark:bg-amber-950/50 dark:text-amber-200"
             role="status">
            {{ session('already_submitted') }}
        </div>
    @endif

    {{-- 1. Welcome + CTA --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500 p-8 text-white shadow-xl shadow-brand-900/20 sm:p-10">
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-16 -left-16 h-48 w-48 rounded-full bg-brand-400/30 blur-2xl"></div>
        <div class="relative z-10 max-w-2xl">
            <p class="text-sm font-medium uppercase tracking-wider text-white/70">Shaxsiy kabinet</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Salom, {{ auth()->user()->full_name }}
            </h1>
            @if ($latestSubmission)
                <p class="mt-4 text-base leading-relaxed text-white/90">
                    Arizangiz qabul qilindi. Tanlov bo‘yicha yangiliklar va bosqichlar pastda — <strong class="font-semibold text-white">{{ $latestSubmission->project_title }}</strong>.
                </p>
                @if ($latestSubmission->status->countsAsPendingBucket())
                    <p class="mt-3 text-base font-medium text-white/95">
                        Hozircha arizangiz <span class="underline decoration-white/40 underline-offset-2">ko‘rib chiqilmoqda</span>.
                    </p>
                @endif
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#tanlov-progress"
                       class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-brand-900 shadow-lg transition hover:bg-slate-100 active:scale-[0.98]">
                        Bosqichlarni ko‘rish
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>
            @else
                <p class="mt-4 text-base leading-relaxed text-white/90">
                    “Kelajak startuplari” tanlovida ishtirok etish uchun bitta ariza topshiring. Ariza holatini shu yerda kuzatib boring.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('project.submit.form') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-brand-900 shadow-lg transition hover:bg-slate-100 active:scale-[0.98]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Ariza topshirish
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- 2. Statistics --}}
    <section class="mt-10">
        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Umumiy statistika</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Barcha yuborilgan arizalaringiz bo‘yicha</p>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Jami arizalar</span>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500/10 text-brand-700 dark:text-brand-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Ko‘rib chiqilmoqda</span>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-700 dark:text-amber-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $stats['pending'] }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Viloyat bosqichida</span>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-700 dark:text-emerald-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $stats['approved'] }}</p>
            </article>
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/50 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                <div class="flex items-center justify-between gap-3">
                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Rad etilgan</span>
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-500/15 text-rose-700 dark:text-rose-300">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $stats['rejected'] }}</p>
            </article>
        </div>
    </section>

    <div class="mt-10 grid gap-8 lg:grid-cols-5 lg:gap-10">
        {{-- 3. Progress --}}
        <section id="tanlov-progress" class="scroll-mt-24 lg:col-span-3">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tanlov bosqichlari</h2>
            @if ($latestSubmission && $latestSubmission->status->countsAsPendingBucket())
                <p class="mt-1 text-sm font-medium text-amber-700 dark:text-amber-300">
                    Arizangiz qabul qilindi va hozircha <span class="font-semibold">ko‘rib chiqilmoqda</span>. Bosqichlar bo‘yicha holat quyida.
                </p>
            @else
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Qayerdaligingizni shu diagrammada ko‘ring</p>
            @endif
            <div class="mt-6 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8">
                @php
                    $steps = $progress['steps'];
                    $doneCount = collect($steps)->where('done', true)->count();
                    $pct = count($steps) > 1 ? (($doneCount - 1) / (count($steps) - 1)) * 100 : 0;
                    $pct = max(0, min(100, $pct));
                @endphp
                <div class="relative mb-10 hidden pt-2 sm:block">
                    <div class="absolute left-0 right-0 top-1/2 h-1 -translate-y-1/2 rounded-full bg-slate-100 dark:bg-slate-800"></div>
                    <div class="absolute left-0 top-1/2 h-1 -translate-y-1/2 rounded-full bg-gradient-to-r from-brand-500 to-brand-400 transition-all duration-500"
                         style="width: {{ $pct }}%"></div>
                </div>
                <ol class="grid gap-6 sm:grid-cols-4 sm:gap-2">
                    @foreach ($steps as $index => $step)
                        @php
                            $num = $index + 1;
                        @endphp
                        <li class="relative flex flex-col items-center text-center sm:block sm:text-center">
                            <div class="relative z-10 mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl text-sm font-bold shadow-md transition
                                @if ($step['active'])
                                    bg-gradient-to-br from-brand-500 to-brand-400 text-white ring-4 ring-brand-500/30
                                @elseif ($step['done'])
                                    bg-emerald-500 text-white shadow-emerald-500/25
                                @else
                                    border-2 border-slate-200 bg-white text-slate-400 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-500
                                @endif">
                                @if ($step['done'] && ! $step['active'])
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    {{ $num }}
                                @endif
                            </div>
                            <p class="mt-3 text-xs font-semibold leading-snug text-slate-800 dark:text-slate-100 sm:px-1">
                                {{ $step['label'] }}
                            </p>
                            @if ($step['active'])
                                <span class="mt-1 inline-flex rounded-full bg-brand-500/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-brand-700 dark:text-brand-300">
                                    @if ($step['key'] === 'submitted' && ! $step['done'])
                                        Keyingi qadam
                                    @else
                                        Joriy bosqich
                                    @endif
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ol>
                @if ($progress['active_step'] === 0 && $latestSubmission)
                    <p class="mt-8 rounded-2xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-center text-sm font-medium text-emerald-900 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-200">
                        Barcha bosqichlar yakunlandi. Natija bo‘yicha xabarlar pastda.
                    </p>
                @endif
            </div>
        </section>

        {{-- 4 + 5. Recent + Notifications --}}
        <div class="flex flex-col gap-8 lg:col-span-2">
            <section>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">So‘nggi ariza</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Oxirgi yuborilgan ariza</p>
                <div class="mt-6 rounded-3xl border border-slate-200/80 bg-white p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
                    @if ($latestSubmission)
                        <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                            <h3 class="text-base font-bold leading-snug text-slate-900 dark:text-white">{{ $latestSubmission->project_title }}</h3>
                            <span class="inline-flex shrink-0 items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $latestSubmission->status->badgeClasses() }}">
                                {{ $latestSubmission->status->participantLabelUz() }}
                            </span>
                        </div>
                        <dl class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-500 dark:text-slate-400">Yuborilgan sana</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ $latestCreatedLabel }}</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-500 dark:text-slate-400">Byudjet</dt>
                                <dd class="font-medium text-slate-900 dark:text-white">{{ number_format($latestSubmission->required_budget, 0, '.', ' ') }} so‘m</dd>
                            </div>
                            <div class="flex items-center justify-between gap-4 border-t border-slate-100 pt-4 dark:border-slate-800">
                                <dt class="shrink-0 text-slate-500 dark:text-slate-400">Taqdimot fayli</dt>
                                <dd class="m-0 min-w-0 text-end">
                                    <a href="{{ route('project.submission.download', $latestSubmission) }}"
                                       class="inline-flex max-w-full flex-nowrap items-center justify-center gap-2 whitespace-nowrap rounded-lg bg-brand-600 px-3 py-2 text-sm font-semibold shadow-sm transition hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 dark:bg-brand-500 dark:hover:bg-brand-600 dark:hover:text-white">
                                        <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        <span style="hover:color:white">Yuklab olish</span>
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    @else
                        <div class="py-4 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800">
                                <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <p class="mt-4 text-sm text-slate-600 dark:text-slate-300">Hali ariza topshirmagansiz.</p>
                            <a href="{{ route('project.submit.form') }}" class="mt-4 inline-flex text-sm font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                                Birinchi arizani topshirish →
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            <section>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Bildirishnomalar</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">So‘nggi yangiliklar</p>
                <div class="mt-6 space-y-4">
                    @forelse ($notifications as $note)
                        <article class="rounded-2xl border border-slate-200/80 bg-gradient-to-br from-white to-slate-50/80 p-5 shadow-md shadow-slate-200/30 dark:border-slate-800 dark:from-slate-900 dark:to-slate-900/80 dark:shadow-none">
                            <p class="text-sm font-medium leading-relaxed text-slate-800 dark:text-slate-100">{{ $note['message'] }}</p>
                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                                Sana: <time datetime="">{{ $note['date_label'] }}</time>
                            </p>
                        </article>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50/50 p-8 text-center dark:border-slate-800 dark:bg-slate-900/50">
                            <p class="text-sm text-slate-600 dark:text-slate-400">Hozircha bildirishnomalar yo‘q. Ariza topshirganingizdan keyin bu yerda holat yangilanishlari ko‘rinadi.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
