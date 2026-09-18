@extends('layouts.panel')

@section('title', 'Ariza topshirish')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-lg shadow-slate-200/40 dark:border-slate-800 dark:bg-slate-900 dark:shadow-none sm:p-8">
            <form action="{{ route('project.submit') }}"
                  method="post"
                  enctype="multipart/form-data"
                  class="space-y-6"
                  novalidate>
                @csrf

                @if (session('project_submitted'))
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 dark:border-emerald-900/50 dark:bg-emerald-950/50 dark:text-emerald-200"
                         role="alert">
                        {{ session('project_submitted') }}
                    </div>
                @endif

                <h1 class="mb-6 text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                    Ariza topshirish
                </h1>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="project_title">Loyiha nomi</label>
                    <input type="text"
                           id="project_title"
                           name="project_title"
                           value="{{ old('project_title') }}"
                           class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('project_title') border-rose-500 focus:border-rose-500 focus:ring-rose-500/25 @enderror"
                           required
                           maxlength="255"
                           autocomplete="off"
                           placeholder="Masalan: AgroTech monitoring tizimi">
                    @error('project_title')
                        <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="document">Taqdimot fayli (PDF yoki PPT)</label>
                    <input type="file"
                           id="document"
                           name="document"
                           class="w-full cursor-pointer rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-500/15 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-900 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:file:bg-brand-500/25 dark:file:text-white @error('document') border-rose-500 @enderror"
                           accept=".pdf,.ppt,.pptx,application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation"
                           required>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Faqat PDF yoki PowerPoint. Maksimal hajm: 20 MB.</p>
                    @error('document')
                        <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $oldBudgetRaw = old('required_budget');
                    $oldBudgetDisplay = '';
                    if ($oldBudgetRaw !== null && $oldBudgetRaw !== '') {
                        $digitsOnly = preg_replace('/\D+/', '', (string) $oldBudgetRaw);
                        $oldBudgetDisplay = $digitsOnly !== '' ? number_format((int) $digitsOnly, 0, '.', ' ') : '';
                    }
                @endphp
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="required_budget">Talab qilinadigan byudjet (so‘m)</label>
                    <input type="text"
                           id="required_budget"
                           name="required_budget"
                           value="{{ $oldBudgetDisplay }}"
                           class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('required_budget') border-rose-500 focus:border-rose-500 focus:ring-rose-500/25 @enderror"
                           required
                           inputmode="numeric"
                           autocomplete="off"
                           maxlength="19"
                           placeholder="Masalan: 1 000 000"
                           data-budget-input>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Faqat raqam kiriting; har 3 ta raqamdan keyin bo‘sh joy qo‘yiladi.</p>
                    @error('required_budget')
                        <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="region_id">Viloyat</label>
                    <select id="region_id"
                            name="region_id"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('region_id') border-rose-500 @enderror"
                            required>
                        <option value="" disabled @selected(old('region_id') === null || old('region_id') === '')>Viloyatni tanlang</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" @selected((string) old('region_id') === (string) $region->id)>
                                {{ $region->name_uz }}
                            </option>
                        @endforeach
                    </select>
                    @error('region_id')
                        <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="district_id">Tuman / shahar</label>
                    <select id="district_id"
                            name="district_id"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('district_id') border-rose-500 @enderror"
                            required
                            data-placeholder="Avval viloyatni tanlang">
                        <option value="">{{ old('region_id') ? 'Tumanni tanlang' : 'Avval viloyatni tanlang' }}</option>
                    </select>
                    @error('district_id')
                        <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-brand-900 to-brand-500 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-500/30 transition hover:brightness-110 active:scale-[0.99]">
                    Arizani topshirish
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
@endsection

@php
    $districtsByRegion = $regions->mapWithKeys(function ($region) {
        return [
            $region->id => $region->districts->map(fn ($d) => [
                'id' => $d->id,
                'name' => $d->name_uz,
            ])->values(),
        ];
    });
@endphp

@push('scripts')
    <script>
        (function () {
            var budgetEl = document.querySelector('[data-budget-input]');
            var maxDigits = 12;

            function formatBudgetGroups(digits) {
                if (!digits) {
                    return '';
                }
                var parts = [];
                for (var i = digits.length; i > 0; i -= 3) {
                    parts.unshift(digits.slice(Math.max(0, i - 3), i));
                }
                return parts.join(' ');
            }

            function applyBudgetFormat(input) {
                var start = input.selectionStart;
                var end = input.selectionEnd;
                if (start === null || end === null) {
                    start = input.value.length;
                    end = start;
                }
                var digitsBefore = input.value.slice(0, start).replace(/\D/g, '').length;
                var all = input.value.replace(/\D/g, '').slice(0, maxDigits);
                var formatted = formatBudgetGroups(all);
                input.value = formatted;
                var newPos = 0;
                var seen = 0;
                for (var i = 0; i < formatted.length; i++) {
                    if (/\d/.test(formatted.charAt(i))) {
                        seen++;
                        if (seen === digitsBefore) {
                            newPos = i + 1;
                            break;
                        }
                    }
                }
                if (digitsBefore === 0) {
                    newPos = 0;
                } else if (seen < digitsBefore) {
                    newPos = formatted.length;
                }
                input.setSelectionRange(newPos, newPos);
            }

            if (budgetEl) {
                budgetEl.addEventListener('input', function () {
                    applyBudgetFormat(budgetEl);
                });
                budgetEl.addEventListener('blur', function () {
                    applyBudgetFormat(budgetEl);
                });
            }

            var regionEl = document.getElementById('region_id');
            var districtEl = document.getElementById('district_id');
            if (!regionEl || !districtEl) {
                return;
            }

            var byRegion = @json($districtsByRegion);
            var oldRegion = @json(old('region_id'));
            var oldDistrict = @json(old('district_id'));

            function fillDistricts(regionId, preserveSelectedId) {
                var placeholder = regionId ? 'Tumanni tanlang' : districtEl.getAttribute('data-placeholder');
                districtEl.innerHTML = '';
                var opt0 = document.createElement('option');
                opt0.value = '';
                opt0.textContent = placeholder;
                districtEl.appendChild(opt0);

                if (!regionId || !byRegion[regionId]) {
                    return;
                }

                var list = byRegion[regionId];
                for (var i = 0; i < list.length; i++) {
                    var d = list[i];
                    var opt = document.createElement('option');
                    opt.value = String(d.id);
                    opt.textContent = d.name;
                    if (preserveSelectedId && String(preserveSelectedId) === String(d.id)) {
                        opt.selected = true;
                    }
                    districtEl.appendChild(opt);
                }
            }

            regionEl.addEventListener('change', function () {
                fillDistricts(this.value, null);
            });

            if (oldRegion) {
                fillDistricts(String(oldRegion), oldDistrict);
            }
        })();
    </script>
@endpush
