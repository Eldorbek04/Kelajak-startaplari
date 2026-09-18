@extends('layouts.admin')

@section('title', 'Viloyat administratorlari')
@section('admin_heading', 'Viloyat administratorlari')
@section('admin_subheading', 'Har bir viloyat uchun alohida admin')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <p class="text-sm text-slate-600 dark:text-slate-400">
            Viloyat adminlari faqat o‘z viloyatidagi loyihalarni ko‘radi va boshqaradi.
        </p>
        <a href="{{ route('admin.region-admins.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-brand-700 to-brand-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-110">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Yangi administrator
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wide text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3 sm:px-6">Ism</th>
                        <th class="px-4 py-3 sm:px-6">Telefon</th>
                        <th class="px-4 py-3 sm:px-6">Viloyat</th>
                        <th class="px-4 py-3 text-end sm:px-6">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($admins as $admin)
                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                            <td class="px-4 py-4 font-medium text-slate-900 dark:text-white sm:px-6">{{ $admin->full_name }}</td>
                            <td class="px-4 py-4 text-slate-600 dark:text-slate-300 sm:px-6">{{ $admin->phone }}</td>
                            <td class="px-4 py-4 text-slate-600 dark:text-slate-300 sm:px-6">{{ $admin->region?->name_uz ?? '—' }}</td>
                            <td class="px-4 py-4 sm:px-6">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <a href="{{ route('admin.region-admins.edit', $admin) }}"
                                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                                        Tahrirlash
                                    </a>
                                    <form method="post"
                                          action="{{ route('admin.region-admins.destroy', $admin) }}"
                                          class="inline"
                                          onsubmit="return confirm('Administratorni oddiy foydalanuvchiga aylantirasizmi? Admin paneliga kira olmaydi.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-800 transition hover:bg-rose-100 dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-200 dark:hover:bg-rose-950/60">
                                            Huquqni olib tashlash
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                                Hozircha viloyat administratorlari yo‘q. «Yangi administrator» orqali qo‘shing.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($admins->hasPages())
            <div class="border-t border-slate-200 px-4 py-4 dark:border-slate-800">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
@endsection
