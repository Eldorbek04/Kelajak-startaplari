@php
    use App\Enums\CompetitionProjectStatus;
@endphp

@extends('layouts.admin')

@section('title', 'Loyihalar')
@section('admin_heading', 'Loyihalar')
@section('admin_subheading', 'Tanlov loyihalari ro‘yxati')

@section('content')
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-md dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm dark:divide-slate-800">
                <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wide text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3 sm:px-6">Loyiha nomi</th>
                        <th class="hidden px-4 py-3 md:table-cell sm:px-6">Ishtirokchi</th>
                        <th class="hidden px-4 py-3 lg:table-cell sm:px-6">Viloyat</th>
                        <th class="px-4 py-3 sm:px-6">Holat</th>
                        <th class="px-4 py-3 text-end sm:px-6">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($projects as $project)
                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                            <td class="px-4 py-4 sm:px-6">
                                <a href="{{ route('admin.projects.show', $project) }}" class="font-semibold text-slate-900 transition hover:text-brand-600 dark:text-white dark:hover:text-brand-400">
                                    {{ $project->project_title }}
                                </a>
                            </td>
                            <td class="hidden px-4 py-4 text-slate-600 dark:text-slate-300 md:table-cell sm:px-6">
                                {{ $project->user?->full_name ?? '—' }}
                            </td>
                            <td class="hidden px-4 py-4 text-slate-600 dark:text-slate-300 lg:table-cell sm:px-6">
                                {{ $project->region?->name_uz ?? '—' }}
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $project->status->badgeAdminClasses() }}">
                                    {{ $project->status->labelUz() }}
                                </span>
                            </td>
                            <td class="px-4 py-4 sm:px-6">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    @if ($project->status === CompetitionProjectStatus::New)
                                        <button type="button" data-admin-open="admin-m-accept-{{ $project->id }}"
                                                class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-700">
                                            Qabul qilish
                                        </button>
                                    @endif
                                    @if (in_array($project->status, [CompetitionProjectStatus::New, CompetitionProjectStatus::RegionStage], true))
                                        <button type="button" data-admin-open="admin-m-reject-{{ $project->id }}"
                                                class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-800 transition hover:bg-rose-100 dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-200 dark:hover:bg-rose-950/60">
                                            Bekor qilish
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.projects.show', $project) }}"
                                       class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                                        Batafsil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                                Hozircha loyihalar yo‘q.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($projects->hasPages())
            <div class="border-t border-slate-200 px-4 py-4 dark:border-slate-800">
                {{ $projects->links() }}
            </div>
        @endif
    </div>

    @foreach ($projects as $project)
        @include('admin.projects.partials.action-modals', ['project' => $project])
    @endforeach
@endsection
