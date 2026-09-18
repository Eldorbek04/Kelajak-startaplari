<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CompetitionProjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectSubmission extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'project_title',
        'required_budget',
        'region_id',
        'district_id',
        'document_path',
        'status',
        'rejection_reason',
        'region_date',
        'region_time',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'required_budget' => 'integer',
            'status' => CompetitionProjectStatus::class,
            'region_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
