@php
    use App\Enums\CompetitionProjectStatus;
@endphp

{{-- Qabul qilish --}}
@if ($project->status === CompetitionProjectStatus::New)
    <div id="admin-m-accept-{{ $project->id }}"
         class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm transition-opacity dark:bg-slate-950/70"
         data-admin-modal
         role="dialog"
         aria-modal="true"
         aria-labelledby="admin-accept-title-{{ $project->id }}">
        <div class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-900"
             onclick="event.stopPropagation()">
            <button type="button"
                    class="absolute right-4 top-4 rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 dark:hover:text-slate-200"
                    data-admin-modal-close
                    aria-label="Yopish">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="admin-accept-title-{{ $project->id }}" class="pr-10 text-lg font-bold text-slate-900 dark:text-white">Qabul qilish</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Loyiha viloyat bosqichiga o‘tkaziladi. Sanani va vaqtni kiriting.</p>
            <form method="post" action="{{ route('admin.projects.accept', $project) }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="region_date_{{ $project->id }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Viloyat sanasi</label>
                    <input type="date" name="region_date" id="region_date_{{ $project->id }}" required
                           value="{{ old('region_date') }}"
                           class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div>
                    <label for="region_time_{{ $project->id }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Viloyat vaqti</label>
                    <input type="time" name="region_time" id="region_time_{{ $project->id }}" required
                           value="{{ old('region_time') }}"
                           class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div class="flex flex-wrap justify-end gap-2 pt-2">
                    <button type="button" data-admin-modal-close
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        Bekor qilish
                    </button>
                    <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-brand-700 to-brand-500 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:brightness-110">
                        Tasdiqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

{{-- Rad etish --}}
@if (in_array($project->status, [CompetitionProjectStatus::New, CompetitionProjectStatus::RegionStage], true))
    <div id="admin-m-reject-{{ $project->id }}"
         class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm dark:bg-slate-950/70"
         data-admin-modal
         role="dialog"
         aria-modal="true"
         aria-labelledby="admin-reject-title-{{ $project->id }}">
        <div class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-900"
             onclick="event.stopPropagation()">
            <button type="button"
                    class="absolute right-4 top-4 rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 dark:hover:bg-slate-800"
                    data-admin-modal-close
                    aria-label="Yopish">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <h2 id="admin-reject-title-{{ $project->id }}" class="pr-10 text-lg font-bold text-slate-900 dark:text-white">Arizani bekor qilish</h2>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Bekor qilish majburiy — nima uchun bekor qilinayotganini batafsil yozing (kamida 10 belgi).</p>
            <form method="post" action="{{ route('admin.projects.reject', $project) }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="rejection_reason_{{ $project->id }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Izoh — nima uchun bekor qilinmoqda?</label>
                    <textarea name="rejection_reason" id="rejection_reason_{{ $project->id }}" rows="4" required minlength="10" maxlength="2000"
                              class="mt-1.5 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                              placeholder="Masalan: taqdimot talablarga mos kelmaydi...">{{ old('rejection_reason') }}</textarea>
                </div>
                <div class="flex flex-wrap justify-end gap-2 pt-2">
                    <button type="button" data-admin-modal-close
                            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200">
                        Yopish
                    </button>
                    <button type="submit"
                            class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-rose-700">
                        Bekor qilishni tasdiqlash
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
