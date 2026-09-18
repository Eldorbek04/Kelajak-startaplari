<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\CompetitionProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminUserPasswordRequest;
use App\Models\District;
use App\Models\ProjectSubmission;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminStatisticsController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', ProjectSubmission::class);

        $auth = $request->user();
        abort_if($auth === null || ! $auth->isAdmin(), 403);
        $auth->loadMissing('region');

        [$regionId, $districtId] = $this->parseFilters($request, $auth);
        $statusEnum = CompetitionProjectStatus::tryFrom($request->string('status')->toString());

        $regions = Region::query()
            ->with(['districts' => static function ($query): void {
                $query->orderBy('name_uz');
            }])
            ->orderBy('name_uz')
            ->get();
        $districts = collect();
        if ($regionId !== null) {
            $districts = District::query()->where('region_id', $regionId)->orderBy('name_uz')->get();
        }

        $subScope = $this->submissionScope($auth, $regionId, $districtId);
        $totalSubmissions = (clone $subScope)->count();

        $statusStats = [];
        foreach (CompetitionProjectStatus::cases() as $case) {
            $statusStats[$case->value] = [
                'label' => $case->labelUz(),
                'count' => (clone $subScope)->where('status', $case)->count(),
            ];
        }

        $subForList = clone $subScope;
        if ($statusEnum !== null) {
            $subForList->where('status', $statusEnum);
        }
        $submissions = $subForList
            ->with(['user', 'region', 'district'])
            ->orderByDesc('created_at')
            ->paginate(15, ['*'], 'submissions_page')
            ->withQueryString();

        $userScope = $this->userScope($auth, $regionId, $districtId);
        $totalUsers = (clone $userScope)->count();
        $users = (clone $userScope)
            ->with('region')
            ->orderBy('full_name')
            ->paginate(15, ['*'], 'users_page')
            ->withQueryString();

        $districtsByRegion = $regions->mapWithKeys(function (Region $region) {
            return [
                $region->id => $region->districts->map(fn (District $d) => [
                    'id' => $d->id,
                    'name' => $d->name_uz,
                ])->values(),
            ];
        });

        return view('admin.statistics.index', [
            'authUser' => $auth,
            'regions' => $regions,
            'districts' => $districts,
            'districtsByRegion' => $districtsByRegion,
            'regionId' => $regionId,
            'districtId' => $districtId,
            'statusEnum' => $statusEnum,
            'totalSubmissions' => $totalSubmissions,
            'totalUsers' => $totalUsers,
            'statusStats' => $statusStats,
            'submissions' => $submissions,
            'users' => $users,
            'statusCases' => CompetitionProjectStatus::cases(),
        ]);
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        $this->authorize('viewAny', ProjectSubmission::class);

        $auth = $request->user();
        abort_if($auth === null || ! $auth->isAdmin(), 403);
        abort_unless(in_array($type, ['users', 'submissions'], true), 404);

        [$regionId, $districtId] = $this->parseFilters($request, $auth);
        $statusEnum = CompetitionProjectStatus::tryFrom($request->string('status')->toString());

        $stamp = Carbon::now()->format('Y-m-d_His');
        if ($type === 'users') {
            $filename = 'foydalanuvchilar_'.$stamp.'.csv';

            return $this->streamCsv($filename, function ($handle) use ($auth, $regionId, $districtId): void {
                $this->writeCsvBom($handle);
                fputcsv($handle, [
                    'ID',
                    'To‘liq ism',
                    'Telefon',
                    'Rol',
                    'Viloyat',
                    'Ro‘yxatdan o‘tgan',
                ], ';');

                $this->userScope($auth, $regionId, $districtId)
                    ->with('region')
                    ->orderBy('full_name')
                    ->chunk(500, function ($chunk) use ($handle): void {
                        foreach ($chunk as $u) {
                            fputcsv($handle, [
                                $u->id,
                                $u->full_name,
                                $u->phone,
                                $this->roleLabelUz($u->role),
                                $u->region?->name_uz ?? '',
                                $u->created_at?->format('Y-m-d H:i') ?? '',
                            ], ';');
                        }
                    });
            });
        }

        $filename = 'arizalar_'.$stamp.'.csv';

        return $this->streamCsv($filename, function ($handle) use ($auth, $regionId, $districtId, $statusEnum): void {
            $this->writeCsvBom($handle);
            fputcsv($handle, [
                'ID',
                'Loyiha nomi',
                'Ishtirokchi',
                'Telefon',
                'Viloyat',
                'Tuman',
                'Holat',
                'Byudjet (so‘m)',
                'Viloyat sanasi',
                'Viloyat vaqti',
                'Yuborilgan',
            ], ';');

            $q = $this->submissionScope($auth, $regionId, $districtId);
            if ($statusEnum !== null) {
                $q->where('status', $statusEnum);
            }
            $q->with(['user', 'region', 'district'])
                ->orderByDesc('created_at')
                ->chunk(500, function ($chunk) use ($handle): void {
                    foreach ($chunk as $s) {
                        $st = $s->status instanceof CompetitionProjectStatus ? $s->status : CompetitionProjectStatus::tryFrom((string) $s->status);
                        fputcsv($handle, [
                            $s->id,
                            $s->project_title,
                            $s->user?->full_name ?? '',
                            $s->user?->phone ?? '',
                            $s->region?->name_uz ?? '',
                            $s->district?->name_uz ?? '',
                            $st?->labelUz() ?? (string) $s->status,
                            $s->required_budget,
                            $s->region_date?->format('Y-m-d') ?? '',
                            $s->region_time ?? '',
                            $s->created_at?->format('Y-m-d H:i') ?? '',
                        ], ';');
                    }
                });
        });
    }

    public function updateUserPassword(UpdateAdminUserPasswordRequest $request): RedirectResponse
    {
        $auth = $request->user();
        abort_if($auth === null, 403);

        $user = User::query()->findOrFail($request->integer('user_id'));
        $this->assertCanChangeUserPassword($auth, $user);

        $user->password = $request->validated('password');
        $user->save();

        return back()->with('success', 'Foydalanuvchi paroli yangilandi.');
    }

    /**
     * @return array{0: ?int, 1: ?int}
     */
    protected function parseFilters(Request $request, User $auth): array
    {
        $regionId = null;
        $districtId = null;

        if ($auth->isRegionAdmin()) {
            $regionId = $auth->region_id !== null ? (int) $auth->region_id : null;
        } elseif ($request->filled('region_id')) {
            $regionId = $request->integer('region_id');
        }

        if ($request->filled('district_id')) {
            $districtId = $request->integer('district_id');
        }

        if ($regionId !== null && $districtId !== null) {
            $valid = District::query()
                ->whereKey($districtId)
                ->where('region_id', $regionId)
                ->exists();
            if (! $valid) {
                $districtId = null;
            }
        }

        return [$regionId, $districtId];
    }

    protected function submissionScope(User $auth, ?int $regionId, ?int $districtId): Builder
    {
        $q = ProjectSubmission::query();

        if ($auth->isRegionAdmin()) {
            $q->where('region_id', $auth->region_id);
        } elseif ($regionId !== null) {
            $q->where('region_id', $regionId);
        }

        if ($districtId !== null) {
            $q->where('district_id', $districtId);
        }

        return $q;
    }

    protected function userScope(User $auth, ?int $regionId, ?int $districtId): Builder
    {
        $q = User::query();

        if ($auth->isRegionAdmin()) {
            $q->where('region_id', $auth->region_id);
        } elseif ($regionId !== null) {
            $q->where('region_id', $regionId);
        }

        if ($districtId !== null) {
            $q->whereHas('projectSubmissions', function (Builder $sq) use ($districtId): void {
                $sq->where('district_id', $districtId);
            });
        }

        return $q;
    }

    protected function assertCanChangeUserPassword(User $auth, User $target): void
    {
        if ($auth->isSuperAdmin()) {
            return;
        }

        if ($auth->isRegionAdmin()) {
            abort_unless($target->role === User::ROLE_USER, 403);
            abort_unless(
                $target->region_id !== null && $auth->region_id !== null
                    && (int) $target->region_id === (int) $auth->region_id,
                403
            );

            return;
        }

        abort(403);
    }

    protected function roleLabelUz(string $role): string
    {
        return match ($role) {
            User::ROLE_SUPER_ADMIN => 'Super administrator',
            User::ROLE_REGION_ADMIN => 'Viloyat administratori',
            default => 'Foydalanuvchi',
        };
    }

    /**
     * @param  callable(resource): void  $writer
     */
    protected function streamCsv(string $filename, callable $writer): StreamedResponse
    {
        return response()->streamDownload(function () use ($writer): void {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }
            try {
                $writer($handle);
            } finally {
                fclose($handle);
            }
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * @param  resource  $handle
     */
    protected function writeCsvBom($handle): void
    {
        fwrite($handle, "\xEF\xBB\xBF");
    }
}


// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 