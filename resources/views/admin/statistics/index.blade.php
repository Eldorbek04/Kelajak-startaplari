@php
    use App\Enums\CompetitionProjectStatus;
    use App\Models\User;

    $exportQuery = collect([
        'region_id' => $regionId,
        'district_id' => $districtId,
        'status' => $statusEnum?->value,
    ])->filter(fn ($v) => $v !== null && $v !== '')->all();
@endphp

@extends('layouts.admin')

@section('title', 'Statistika')
@section('admin_heading', 'Statistika')
@section('admin_subheading', 'Foydalanuvchilar va arizalar')

@section('content')
    <div class="mb-6 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">
        <form method="get" action="{{ route('admin.statistics.index') }}" class="space-y-4" id="admin-stats-filter-form">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @if ($authUser->isSuperAdmin())
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400" for="filter_region">Viloyat</label>
                        <select name="region_id" id="filter_region" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                            <option value="">Barcha viloyatlar</option>
                            @foreach ($regions as $r)
                                <option value="{{ $r->id }}" @selected((string) $regionId === (string) $r->id)>{{ $r->name_uz }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="sm:col-span-2">
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Viloyat</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $authUser->region?->name_uz ?? '—' }} <span class="text-xs">(faqat o‘z viloyatingiz)</span></p>
                    </div>
                @endif

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400" for="filter_district">Tuman</label>
                    <select name="district_id" id="filter_district" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white" data-placeholder="Avval viloyatni tanlang">
                        <option value="">{{ $regionId ? 'Barcha tumanlar' : ($authUser->isSuperAdmin() ? 'Avval viloyatni tanlang' : 'Tumanni tanlang') }}</option>
                        @foreach ($districts as $d)
                            <option value="{{ $d->id }}" @selected((string) $districtId === (string) $d->id)>{{ $d->name_uz }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400" for="filter_status">Ariza holati</label>
                    <select name="status" id="filter_status" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                        <option value="">Barcha holatlar (jadval)</option>
                        @foreach ($statusCases as $st)
                            <option value="{{ $st->value }}" @selected($statusEnum === $st)>{{ $st->labelUz() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <button type="submit" class="rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">Qo‘llash</button>
                <a href="{{ route('admin.statistics.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Tozalash</a>
            </div>
        </form>
    </div>

    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.statistics.export', array_merge($exportQuery, ['type' => 'submissions'])) }}"
           class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-900 transition hover:bg-emerald-100 dark:border-emerald-900/40 dark:bg-emerald-950/40 dark:text-emerald-100 dark:hover:bg-emerald-950/60">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Arizalarni eksport (Excel / CSV)
        </a>
        <a href="{{ route('admin.statistics.export', array_merge($exportQuery, ['type' => 'users'])) }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:hover:bg-slate-700">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Foydalanuvchilarni eksport (Excel / CSV)
        </a>
        <p class="w-full text-xs text-slate-500 dark:text-slate-400">Fayl UTF-8 CSV — Excelda «Ma’lumotlarni import qilish» orqali oching yoki .csv ni ikki marta bosing.</p>
    </div>

    <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-md dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Foydalanuvchilar</p>
            <p class="mt-1 text-2xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $totalUsers }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-md dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Arizalar (filtr bo‘yicha)</p>
            <p class="mt-1 text-2xl font-bold tabular-nums text-slate-900 dark:text-white">{{ $totalSubmissions }}</p>
        </article>
        @foreach ($statusStats as $key => $row)
            <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-md dark:border-slate-800 dark:bg-slate-900">
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $row['label'] }}</p>
                <p class="mt-1 text-2xl font-bold tabular-nums text-brand-700 dark:text-brand-300">{{ $row['count'] }}</p>
            </article>
        @endforeach
    </div>

    <section class="mb-10">
        <h2 class="mb-3 text-lg font-bold text-slate-900 dark:text-white">Arizalar</h2>
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                        <tr>
                            <th class="px-4 py-3 sm:px-6">Loyiha</th>
                            <th class="hidden px-4 py-3 lg:table-cell sm:px-6">Ishtirokchi</th>
                            <th class="hidden px-4 py-3 md:table-cell sm:px-6">Viloyat / tuman</th>
                            <th class="px-4 py-3 sm:px-6">Holat</th>
                            <th class="hidden px-4 py-3 sm:table-cell sm:px-6">Byudjet</th>
                            <th class="px-4 py-3 text-end sm:px-6">Fayl</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($submissions as $sub)
                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td class="px-4 py-3 sm:px-6">
                                    <a href="{{ route('admin.projects.show', $sub) }}" class="font-semibold text-brand-700 hover:underline dark:text-brand-400">{{ $sub->project_title }}</a>
                                </td>
                                <td class="hidden px-4 py-3 text-slate-600 dark:text-slate-300 lg:table-cell sm:px-6">
                                    <div>{{ $sub->user?->full_name }}</div>
                                    <div class="text-xs text-slate-500">{{ $sub->user?->phone }}</div>
                                </td>
                                <td class="hidden px-4 py-3 text-slate-600 dark:text-slate-300 md:table-cell sm:px-6">
                                    {{ $sub->region?->name_uz }} / {{ $sub->district?->name_uz }}
                                </td>
                                <td class="px-4 py-3 sm:px-6">
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $sub->status->badgeAdminClasses() }}">{{ $sub->status->labelUz() }}</span>
                                </td>
                                <td class="hidden px-4 py-3 tabular-nums sm:table-cell sm:px-6">{{ number_format($sub->required_budget, 0, '.', ' ') }}</td>
                                <td class="px-4 py-3 text-end sm:px-6">
                                    <a href="{{ route('admin.projects.download', $sub) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-800 dark:text-brand-400">Yuklab olish</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">Arizalar yo‘q.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($submissions->hasPages())
                <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">{{ $submissions->links() }}</div>
            @endif
        </div>
    </section>

    <section class="mb-8">
        <h2 class="mb-3 text-lg font-bold text-slate-900 dark:text-white">Foydalanuvchilar</h2>
        <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                    <thead class="bg-slate-50/80 text-xs font-semibold uppercase text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                        <tr>
                            <th class="px-4 py-3 sm:px-6">Ism</th>
                            <th class="px-4 py-3 sm:px-6">Telefon</th>
                            <th class="hidden px-4 py-3 md:table-cell sm:px-6">Rol</th>
                            <th class="hidden px-4 py-3 lg:table-cell sm:px-6">Viloyat</th>
                            <th class="px-4 py-3 text-end sm:px-6">Parol</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($users as $u)
                            <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td class="px-4 py-3 font-medium text-slate-900 dark:text-white sm:px-6">{{ $u->full_name }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300 sm:px-6">{{ $u->phone }}</td>
                                <td class="hidden px-4 py-3 md:table-cell sm:px-6">
                                    @if ($u->role === User::ROLE_SUPER_ADMIN)
                                        <span class="text-xs font-semibold text-violet-700 dark:text-violet-300">Super admin</span>
                                    @elseif ($u->role === User::ROLE_REGION_ADMIN)
                                        <span class="text-xs font-semibold text-amber-700 dark:text-amber-300">Viloyat admin</span>
                                    @else
                                        <span class="text-xs text-slate-600 dark:text-slate-400">Foydalanuvchi</span>
                                    @endif
                                </td>
                                <td class="hidden px-4 py-3 lg:table-cell sm:px-6">{{ $u->region?->name_uz ?? '—' }}</td>
                                <td class="px-4 py-3 text-end sm:px-6">
                                    @if ($authUser->isSuperAdmin() || ($authUser->isRegionAdmin() && $u->role === User::ROLE_USER && $u->region_id !== null && $authUser->region_id !== null && (int) $u->region_id === (int) $authUser->region_id))
                                        <button type="button"
                                                class="stats-password-open rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-800 transition hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700"
                                                data-user-id="{{ $u->id }}"
                                                data-user-name="{{ $u->full_name }}">
                                            Parolni yangilash
                                        </button>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">Foydalanuvchilar yo‘q.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="border-t border-slate-200 px-4 py-3 dark:border-slate-800">{{ $users->links() }}</div>
            @endif
        </div>
    </section>

    <div id="stats-password-modal"
         class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm dark:bg-slate-950/70"
         data-admin-modal
         role="dialog"
         aria-modal="true"
         aria-labelledby="stats-password-title">
        <div class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-900" onclick="event.stopPropagation()">
            <button type="button" class="absolute right-4 top-4 rounded-lg p-1 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800" data-admin-modal-close aria-label="Yopish">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="stats-password-title" class="pr-10 text-lg font-bold text-slate-900 dark:text-white">Parolni yangilash</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400"><span id="stats-password-user-label"></span></p>
            <form method="post" action="{{ route('admin.statistics.users.password') }}" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="user_id" id="stats-password-user-id" value="">
                @error('user_id')
                    <p class="text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                @enderror
                <div>
                    <label for="stats_new_password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Yangi parol</label>
                    <input type="password" name="password" id="stats_new_password" required autocomplete="new-password" class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @error('password')
                        <p class="mt-1 text-sm text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="stats_new_password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Parolni tasdiqlash</label>
                    <input type="password" name="password_confirmation" id="stats_new_password_confirmation" required autocomplete="new-password" class="mt-1.5 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-admin-modal-close class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold dark:border-slate-600">Bekor</button>
                    <button type="submit" class="rounded-xl bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">Saqlash</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var byRegion = @json($districtsByRegion);
            var regionEl = document.getElementById('filter_region');
            var districtEl = document.getElementById('filter_district');
            var oldDistrict = @json($districtId);
            var isSuper = @json($authUser->isSuperAdmin());
            var fixedRegionId = @json($authUser->isRegionAdmin() ? $authUser->region_id : null);

            function fillDistricts(regionId, selectedId) {
                if (!districtEl) return;
                var placeholder = regionId ? 'Barcha tumanlar' : (isSuper ? 'Avval viloyatni tanlang' : 'Tumanni tanlang');
                districtEl.innerHTML = '';
                var opt0 = document.createElement('option');
                opt0.value = '';
                opt0.textContent = placeholder;
                districtEl.appendChild(opt0);
                if (!regionId || !byRegion[regionId]) return;
                var list = byRegion[regionId];
                for (var i = 0; i < list.length; i++) {
                    var d = list[i];
                    var opt = document.createElement('option');
                    opt.value = String(d.id);
                    opt.textContent = d.name;
                    if (selectedId && String(selectedId) === String(d.id)) opt.selected = true;
                    districtEl.appendChild(opt);
                }
            }

            if (isSuper && regionEl && districtEl) {
                regionEl.addEventListener('change', function () {
                    fillDistricts(this.value, null);
                });
                if (regionEl.value) {
                    fillDistricts(regionEl.value, oldDistrict);
                }
            } else if (!isSuper && fixedRegionId && districtEl) {
                fillDistricts(String(fixedRegionId), oldDistrict);
            }

            document.querySelectorAll('.stats-password-open').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var id = btn.getAttribute('data-user-id');
                    var name = btn.getAttribute('data-user-name') || '';
                    var input = document.getElementById('stats-password-user-id');
                    var label = document.getElementById('stats-password-user-label');
                    if (input) input.value = id;
                    if (label) label.textContent = name ? 'Foydalanuvchi: ' + name : '';
                    var modal = document.getElementById('stats-password-modal');
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.classList.add('overflow-hidden');
                    }
                });
            });
        })();
    </script>
@endpush
