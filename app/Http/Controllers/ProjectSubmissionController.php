<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CompetitionProjectStatus;
use App\Http\Requests\ProjectSubmitRequest;
use App\Models\ProjectSubmission;
use App\Models\Region;
use App\Services\Sms\SmsSender;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProjectSubmissionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();
        abort_if($user === null, 403);

        if ($this->userAlreadySubmitted($user->id)) {
            return redirect()
                ->route('dashboard')
                ->with('already_submitted', 'Siz tanlovda allaqachon ariza topshirgansiz. Bitta foydalanuvchi uchun faqat bitta ariza qabul qilinadi.');
        }

        $regions = Region::query()
            ->orderBy('name_uz')
            ->with(['districts' => static function ($query): void {
                $query->orderBy('name_uz');
            }])
            ->get();

        return view('project.submit', [
            'regions' => $regions,
        ]);
    }

    public function store(ProjectSubmitRequest $request, SmsSender $sms): RedirectResponse
    {
        $user = Auth::user();
        abort_if($user === null, 403);

        if ($this->userAlreadySubmitted($user->id)) {
            return redirect()
                ->route('dashboard')
                ->with('already_submitted', 'Siz allaqachon ariza topshirgansiz.');
        }

        $validated = $request->validated();

        $path = $request->file('document')->store('project-submissions', 'local');

        ProjectSubmission::query()->create([
            'user_id' => $user->id,
            'project_title' => $validated['project_title'],
            'required_budget' => (int) $validated['required_budget'],
            'region_id' => (int) $validated['region_id'],
            'district_id' => (int) $validated['district_id'],
            'document_path' => $path,
            'status' => CompetitionProjectStatus::New,
        ]);

        $phone = $user->phone ?? '';
        if ($phone !== '') {
            $text = (string) config('sms.templates.application_received');
            $sms->send($phone, $text);
        }

        return redirect()
            ->route('dashboard')
            ->with('project_submitted', 'Arizangiz muvaffaqiyatli qabul qilindi. Tez orada siz bilan bog‘lanamiz.');
    }

    public function download(ProjectSubmission $projectSubmission): Response
    {
        $user = Auth::user();
        abort_if($user === null, 403);
        abort_unless($projectSubmission->user_id === $user->id, 403);

        abort_unless(Storage::disk('local')->exists($projectSubmission->document_path), 404);

        $extension = pathinfo($projectSubmission->document_path, PATHINFO_EXTENSION) ?: 'pdf';
        $slug = Str::slug($projectSubmission->project_title);
        if ($slug === '') {
            $slug = 'taqdimot';
        }

        $filename = $slug.'.'.$extension;

        return Storage::disk('local')->download($projectSubmission->document_path, $filename);
    }

    protected function userAlreadySubmitted(int $userId): bool
    {
        return ProjectSubmission::query()->where('user_id', $userId)->exists();
    }
}


// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 