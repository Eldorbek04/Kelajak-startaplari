<?php

declare(strict_types=1);

namespace App\Enums;

enum CompetitionProjectStatus: string
{
    case New = 'new';
    case Rejected = 'rejected';
    case RegionStage = 'region_stage';

    public function labelUz(): string
    {
        return match ($this) {
            self::New => 'Yangi',
            self::Rejected => 'Rad etilgan',
            self::RegionStage => 'Viloyat bosqichi',
        };
    }

    /**
     * Foydalanuvchi kabinetidagi qisqa yorliq.
     */
    public function participantLabelUz(): string
    {
        return match ($this) {
            self::New => 'Ko‘rib chiqilmoqda',
            self::Rejected => 'Rad etildi',
            self::RegionStage => 'Viloyat bosqichida',
        };
    }

    public function badgeAdminClasses(): string
    {
        return match ($this) {
            self::New => 'bg-blue-100 text-blue-900 ring-blue-600/15 dark:bg-blue-950/60 dark:text-blue-100 dark:ring-blue-500/25',
            self::Rejected => 'bg-red-100 text-red-900 ring-red-600/15 dark:bg-red-950/60 dark:text-red-100 dark:ring-red-500/25',
            self::RegionStage => 'bg-emerald-100 text-emerald-900 ring-emerald-600/15 dark:bg-emerald-950/60 dark:text-emerald-100 dark:ring-emerald-500/25',
        };
    }

    public function participantBadgeClasses(): string
    {
        return match ($this) {
            self::New => 'bg-amber-100 text-amber-900 ring-amber-500/20 dark:bg-amber-950/50 dark:text-amber-200',
            self::Rejected => 'bg-rose-100 text-rose-900 ring-rose-500/20 dark:bg-rose-950/50 dark:text-rose-200',
            self::RegionStage => 'bg-emerald-100 text-emerald-900 ring-emerald-500/20 dark:bg-emerald-950/50 dark:text-emerald-200',
        };
    }

    public function countsAsPendingForParticipantStats(): bool
    {
        return $this === self::New;
    }

    /**
     * Kabinet statistikasi: ko‘rib chiqilmoqda.
     */
    public function countsAsPendingBucket(): bool
    {
        return $this->countsAsPendingForParticipantStats();
    }

    /**
     * Tanlov jarayoni yakunlangan (muvaffaqiyatli yoki rad).
     */
    public function isTerminal(): bool
    {
        return $this === self::RegionStage || $this === self::Rejected;
    }

    public function badgeClasses(): string
    {
        return $this->participantBadgeClasses();
    }
}
