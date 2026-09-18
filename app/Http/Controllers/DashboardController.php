<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CompetitionProjectStatus;
use App\Models\ProjectSubmission;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        abort_if($user === null, 403);

        $submissions = ProjectSubmission::query()
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $latest = $submissions->first();

        return view('dashboard.index', [
            'stats' => $this->buildStats($submissions),
            'progress' => $this->buildProgress($latest),
            'latestSubmission' => $latest,
            'latestCreatedLabel' => $latest !== null ? $this->formatUzbekDateTime($latest->created_at) : null,
            'notifications' => $this->buildNotifications($submissions),
        ]);
    }

    /**
     * @param  Collection<int, ProjectSubmission>  $submissions
     * @return array{total: int, pending: int, approved: int, rejected: int}
     */
    protected function buildStats(Collection $submissions): array
    {
        return [
            'total' => $submissions->count(),
            'pending' => $submissions->filter(static fn (ProjectSubmission $s): bool => $s->status->countsAsPendingBucket())->count(),
            'approved' => $submissions->filter(static fn (ProjectSubmission $s): bool => $s->status === CompetitionProjectStatus::RegionStage)->count(),
            'rejected' => $submissions->filter(static fn (ProjectSubmission $s): bool => $s->status === CompetitionProjectStatus::Rejected)->count(),
        ];
    }

    /**
     * @return array{
     *     active_step: int,
     *     steps: list<array{key: string, label: string, done: bool, active: bool}>
     * }
     */
    protected function buildProgress(?ProjectSubmission $latest): array
    {
        $steps = [
            ['key' => 'registered', 'label' => 'Ro‘yxatdan o‘tildi'],
            ['key' => 'submitted', 'label' => 'Ariza yuborildi', 'label_next' => 'Ariza topshirish'],
            ['key' => 'region', 'label' => 'Viloyat bosqichi'],
        ];

        $hasSubmission = $latest !== null;
        $st = $latest?->status;

        $regionStepDone = $hasSubmission && $st === CompetitionProjectStatus::RegionStage;

        $done = [
            true,
            $hasSubmission,
            $regionStepDone,
        ];

        $activeStep = match (true) {
            ! $hasSubmission => 2,
            $st === CompetitionProjectStatus::RegionStage => 0,
            default => 3,
        };

        $built = [];
        foreach ($steps as $index => $step) {
            $stepNum = $index + 1;
            $label = $step['label'];
            if ($step['key'] === 'submitted' && ! $hasSubmission) {
                $label = $step['label_next'] ?? 'Ariza topshirish';
            }

            $built[] = [
                'key' => $step['key'],
                'label' => $label,
                'done' => $done[$index],
                'active' => $activeStep > 0 && $stepNum === $activeStep,
            ];
        }

        return [
            'active_step' => $activeStep,
            'steps' => $built,
        ];
    }

    /**
     * @param  Collection<int, ProjectSubmission>  $submissions
     * @return list<array{message: string, date_label: string}>
     */
    protected function buildNotifications(Collection $submissions): array
    {
        return $submissions
            ->sortByDesc(static fn (ProjectSubmission $s): int => $s->updated_at->getTimestamp())
            ->take(4)
            ->map(function (ProjectSubmission $s): array {
                return [
                    'message' => $this->notificationMessage($s),
                    'date_label' => $this->formatUzbekDateTime($s->updated_at),
                ];
            })
            ->values()
            ->all();
    }

    protected function notificationMessage(ProjectSubmission $submission): string
    {
        return match ($submission->status) {
            CompetitionProjectStatus::New => 'Arizangiz qabul qilindi va ko‘rib chiqilmoqda.',
            CompetitionProjectStatus::RegionStage => 'Arizangiz viloyat bosqichiga o‘tkazildi.',
            CompetitionProjectStatus::Rejected => 'Arizangiz rad etildi.',
        };
    }

    protected function formatUzbekDateTime(CarbonInterface $dateTime): string
    {
        $months = [
            1 => 'yanvar', 2 => 'fevral', 3 => 'mart', 4 => 'aprel', 5 => 'may', 6 => 'iyun',
            7 => 'iyul', 8 => 'avgust', 9 => 'sentyabr', 10 => 'oktyabr', 11 => 'noyabr', 12 => 'dekabr',
        ];

        $month = $months[(int) $dateTime->format('n')] ?? $dateTime->format('m');

        return sprintf(
            '%d-%s, %s',
            (int) $dateTime->format('j'),
            $month,
            $dateTime->format('H:i')
        );
    }
}


// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 