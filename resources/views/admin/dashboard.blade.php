@extends('layouts.admin')

@section('title', 'Boshqaruv paneli')
@section('admin_heading', 'Boshqaruv paneli')
@section('admin_subheading', 'Loyihalar bo‘yicha qisqa statistika')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/40 transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Jami loyihalar</p>
            <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/40 transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Yangi</p>
            <p class="mt-2 text-3xl font-bold tabular-nums text-blue-700 dark:text-blue-300">{{ $stats['new'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/40 transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Viloyat bosqichi</p>
            <p class="mt-2 text-3xl font-bold tabular-nums text-emerald-700 dark:text-emerald-300">{{ $stats['region_stage'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md shadow-slate-200/40 transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900 dark:shadow-none">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Rad etilgan</p>
            <p class="mt-2 text-3xl font-bold tabular-nums text-rose-700 dark:text-rose-300">{{ $stats['rejected'] }}</p>
        </article>
    </div>

    <div class="mt-10 rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900">
        <h2 class="text-base font-bold text-slate-900 dark:text-white">Keyingi qadamlar</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            Barcha loyihalar ro‘yxatini ko‘rish va holatini boshqarish uchun <a href="{{ route('admin.projects.index') }}" class="font-semibold text-brand-600 underline decoration-brand-500/30 underline-offset-2 hover:text-brand-700 dark:text-brand-400">Loyihalar</a> bo‘limiga o‘ting.
        </p>
    </div>
@endsection
