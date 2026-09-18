<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ProjectSubmission;
use App\Models\User;

class ProjectSubmissionPolicy
{
public function viewAny(User $user): bool
{
    return in_array($user->role, ['admin', 'super_admin', 'region_admin']);
}

    public function view(User $user, ProjectSubmission $projectSubmission): bool
    {
        return $user->canAccessProjectSubmission($projectSubmission);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ProjectSubmission $projectSubmission): bool
    {
        return $user->canAccessProjectSubmission($projectSubmission);
    }

    public function delete(User $user, ProjectSubmission $projectSubmission): bool
    {
        return false;
    }

    public function restore(User $user, ProjectSubmission $projectSubmission): bool
    {
        return false;
    }

    public function forceDelete(User $user, ProjectSubmission $projectSubmission): bool
    {
        return false;
    }
}


// <!-- 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// -->