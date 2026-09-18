<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\CompetitionProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\ProjectSubmission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $this->authorize('viewAny', ProjectSubmission::class);

        $user = $request->user();
        abort_if($user === null, 403);

        $base = ProjectSubmission::query();
        if ($user->isRegionAdmin()) {
            $base->where('region_id', $user->region_id);
        }

        $stats = [
            'total' => (clone $base)->count(),
            'new' => (clone $base)->where('status', CompetitionProjectStatus::New)->count(),
            'region_stage' => (clone $base)->where('status', CompetitionProjectStatus::RegionStage)->count(),
            'rejected' => (clone $base)->where('status', CompetitionProjectStatus::Rejected)->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }
}

// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 
