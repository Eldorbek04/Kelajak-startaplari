<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_USER = 'user';

    public const ROLE_REGION_ADMIN = 'region_admin';

    public const ROLE_SUPER_ADMIN = 'super_admin';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'full_name',
        'phone',
        'password',
        'role',
        'region_id',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return HasMany<ProjectSubmission, $this>
     */
    public function projectSubmissions(): HasMany
    {
        return $this->hasMany(ProjectSubmission::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isRegionAdmin(): bool
    {
        return $this->role === self::ROLE_REGION_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->isSuperAdmin() || $this->isRegionAdmin() || $this->role === 'admin';
    }

    public function canAccessProjectSubmission(ProjectSubmission $submission): bool
    {
        // Agar foydalanuvchi super_admin yoki shunchaki 'admin' bo'lsa, barcha loyihalarni ko'ra oladi
        if ($this->isSuperAdmin() || $this->role === 'admin') {
            return true;
        }

        // Agar region_admin bo'lsa, faqat o'zining viloyatiga tegishli loyihalarni ko'radi
        if ($this->isRegionAdmin()) {
            return $this->region_id !== null && (int) $this->region_id === (int) $submission->region_id;
        }

        return false;
    }
}

// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 