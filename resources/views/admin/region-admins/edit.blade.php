@extends('layouts.admin')

@section('title', 'Administratorni tahrirlash')
@section('admin_heading', 'Administratorni tahrirlash')
@section('admin_subheading', $regionAdmin->full_name)

@section('content')
    <div class="mx-auto max-w-xl">
        <form method="post"
              action="{{ route('admin.region-admins.update', $regionAdmin) }}"
              class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-md dark:border-slate-800 dark:bg-slate-900 sm:p-8">
            @csrf
            @method('PUT')
            @include('admin.region-admins._form', ['regionAdmin' => $regionAdmin, 'regions' => $regions, 'isEdit' => true])

            <div class="mt-8 flex flex-wrap gap-3">
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-brand-700 to-brand-500 px-5 py-3 text-sm font-bold text-white shadow-md transition hover:brightness-110">
                    Saqlash
                </button>
                <a href="{{ route('admin.region-admins.index') }}"
                   class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    Ro‘yxatga qaytish
                </a>
            </div>
        </form>
    </div>
@endsection
