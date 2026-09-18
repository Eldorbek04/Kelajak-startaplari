<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\CompetitionProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAcceptProjectRequest;
use App\Http\Requests\AdminRejectProjectRequest;
use App\Models\ProjectSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class AdminProjectController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', ProjectSubmission::class);

        $user = auth()->user();
        abort_if($user === null, 403);

        $query = ProjectSubmission::query()
            ->with(['user', 'region', 'district'])
            ->orderByDesc('created_at');

        if ($user->isRegionAdmin()) {
            $query->where('region_id', $user->region_id);
        }

        $projects = $query->paginate(20)->withQueryString();

        return view('admin.projects.index', [
            'projects' => $projects,
        ]);
    }

    public function show(ProjectSubmission $projectSubmission): View
    {
        $this->authorize('view', $projectSubmission);

        $projectSubmission->load(['user', 'region', 'district']);

        return view('admin.projects.show', [
            'project' => $projectSubmission,
        ]);
    }

    public function download(ProjectSubmission $projectSubmission): Response
    {
        $this->authorize('view', $projectSubmission);

        abort_unless(Storage::disk('local')->exists($projectSubmission->document_path), 404);

        $extension = pathinfo($projectSubmission->document_path, PATHINFO_EXTENSION) ?: 'pdf';
        $slug = Str::slug($projectSubmission->project_title);
        if ($slug === '') {
            $slug = 'taqdimot';
        }

        $filename = $slug.'.'.$extension;

        return Storage::disk('local')->download($projectSubmission->document_path, $filename);
    }

    public function accept(AdminAcceptProjectRequest $request, ProjectSubmission $projectSubmission): RedirectResponse
    {
        abort_unless($projectSubmission->status === CompetitionProjectStatus::New, 422);

        $data = $request->validated();

        $projectSubmission->update([
            'status' => CompetitionProjectStatus::RegionStage,
            'region_date' => $data['region_date'],
            'region_time' => $data['region_time'],
            'rejection_reason' => null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Loyiha viloyat bosqichiga qabul qilindi.');
    }

    public function reject(AdminRejectProjectRequest $request, ProjectSubmission $projectSubmission): RedirectResponse
    {
        abort_unless(
            in_array($projectSubmission->status, [
                CompetitionProjectStatus::New,
                CompetitionProjectStatus::RegionStage,
            ], true),
            422
        );

        $projectSubmission->update([
            'status' => CompetitionProjectStatus::Rejected,
            'rejection_reason' => $request->validated('rejection_reason'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Ariza bekor qilindi.');
    }
}

// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 