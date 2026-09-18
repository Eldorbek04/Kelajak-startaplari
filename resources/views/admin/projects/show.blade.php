@php
    use App\Enums\CompetitionProjectStatus;
@endphp

@extends('layouts.admin')

@section('title', $project->project_title)
@section('admin_heading', $project->project_title)
@section('admin_subheading', 'Loyiha tafsilotlari')

@section('content')
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.projects.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Ro‘yxatga qaytish
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900">
                <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-100 pb-4 dark:border-slate-800">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Asosiy ma’lumotlar</h2>
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $project->status->badgeAdminClasses() }}">
                        {{ $project->status->labelUz() }}
                    </span>
                </div>
                <dl class="mt-6 space-y-4 text-sm">
                    <div class="flex flex-wrap justify-between gap-2">
                        <dt class="text-slate-500 dark:text-slate-400">Ishtirokchi</dt>
                        <dd class="font-medium text-slate-900 dark:text-white">{{ $project->user?->full_name ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-wrap justify-between gap-2">
                        <dt class="text-slate-500 dark:text-slate-400">Byudjet</dt>
                        <dd class="font-medium text-slate-900 dark:text-white">{{ number_format($project->required_budget, 0, '.', ' ') }} so‘m</dd>
                    </div>
                    <div class="flex flex-wrap justify-between gap-2">
                        <dt class="text-slate-500 dark:text-slate-400">Viloyat</dt>
                        <dd class="font-medium text-slate-900 dark:text-white">{{ $project->region?->name_uz ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-wrap justify-between gap-2">
                        <dt class="text-slate-500 dark:text-slate-400">Tuman</dt>
                        <dd class="font-medium text-slate-900 dark:text-white">{{ $project->district?->name_uz ?? '—' }}</dd>
                    </div>
                    <div class="flex flex-wrap items-start justify-between gap-2 border-t border-slate-100 pt-4 dark:border-slate-800">
                        <dt class="text-slate-500 dark:text-slate-400">Taqdimot fayli</dt>
                        <dd>
                            <a href="{{ route('admin.projects.download', $project) }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-700">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                Yuklab olish
                            </a>
                        </dd>
                    </div>
                    @if ($project->status === CompetitionProjectStatus::Rejected && $project->rejection_reason)
                        <div class="rounded-xl border border-rose-200 bg-rose-50/80 p-4 dark:border-rose-900/40 dark:bg-rose-950/30">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-rose-800 dark:text-rose-200">Bekor qilish sababi</dt>
                            <dd class="mt-2 text-slate-800 dark:text-slate-200">{{ $project->rejection_reason }}</dd>
                        </div>
                    @endif
                </dl>
            </article>

            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Bosqich vaqti</h2>
                <dl class="mt-4 grid gap-4 text-sm sm:grid-cols-2">
                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/50">
                        <dt class="text-xs font-semibold uppercase text-emerald-800 dark:text-emerald-200">Viloyat bosqichi</dt>
                        <dd class="mt-1 font-medium text-slate-900 dark:text-white">
                            @if ($project->region_date)
                                {{ $project->region_date->format('d.m.Y') }}
                                @if ($project->region_time)
                                    , {{ $project->region_time }}
                                @endif
                            @else
                                —
                            @endif
                        </dd>
                    </div>
                </dl>
            </article>
        </div>

        <div class="space-y-6">
            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Amallar</h2>
                <div class="mt-4 flex flex-col gap-2">
                    @if ($project->status === CompetitionProjectStatus::New)
                        <button type="button" data-admin-open="admin-m-accept-{{ $project->id }}"
                                class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            Qabul qilish
                        </button>
                    @endif
                    @if (in_array($project->status, [CompetitionProjectStatus::New, CompetitionProjectStatus::RegionStage], true))
                        <button type="button" data-admin-open="admin-m-reject-{{ $project->id }}"
                                class="w-full rounded-xl border-2 border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-900 transition hover:bg-rose-100 dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-100 dark:hover:bg-rose-950/60">
                            Bekor qilish
                        </button>
                    @endif
                </div>
            </article>

            <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Holat yo‘li</h2>
                @php
                    $s = $project->status;
                    $regionReached = $s === CompetitionProjectStatus::RegionStage;
                @endphp
                <ol class="relative mt-6 space-y-0 border-s border-slate-200 ps-6 dark:border-slate-700">
                    <li class="relative pb-8">
                        <span class="absolute -start-[25px] flex h-3 w-3 -translate-y-0.5 rounded-full bg-emerald-500 ring-4 ring-white dark:ring-slate-900"></span>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Ariza yuborildi</p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $project->created_at?->format('d.m.Y H:i') }}</p>
                    </li>
                    <li class="relative pb-8">
                        <span class="absolute -start-[25px] flex h-3 w-3 -translate-y-0.5 rounded-full ring-4 ring-white dark:ring-slate-900
                            @if ($regionReached) bg-emerald-500 @elseif ($s === CompetitionProjectStatus::New) bg-brand-500 animate-pulse @else bg-slate-300 dark:bg-slate-600 @endif"></span>
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">Viloyat bosqichi</p>
                        @if ($project->region_date)
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $project->region_date->format('d.m.Y') }} @if ($project->region_time){{ $project->region_time }}@endif</p>
                        @endif
                    </li>
                    @if ($s === CompetitionProjectStatus::Rejected)
                        <li class="relative">
                            <span class="absolute -start-[25px] flex h-3 w-3 -translate-y-0.5 rounded-full bg-rose-500 ring-4 ring-white dark:ring-slate-900"></span>
                            <p class="text-sm font-semibold text-rose-800 dark:text-rose-200">Rad etilgan</p>
                        </li>
                    @endif
                </ol>
            </article>
        </div>
    </div>

    @include('admin.projects.partials.action-modals', ['project' => $project])
@endsection
