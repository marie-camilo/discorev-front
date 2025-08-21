<?php

namespace App\Models\Api;

use App\Models\Api\Recruiter;
use App\Models\Api\Application;
use App\Models\Api\Media;
use App\Models\Api\BaseApiModel;

class JobOffer extends BaseApiModel
{
    protected $fillable = [
        'recruiterId',
        'title',
        'description',
        'requirements',
        'salaryRange',
        'employmentType',
        'location',
        'remote',
        'publicationDate',
        'expirationDate',
        'status',
    ];

    protected $casts = [
        'remote' => 'boolean',
        'publicationDate' => 'datetime',
        'expirationDate' => 'datetime',
    ];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiterId');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'jobOfferId');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'targetId')
            ->where('targetType', 'job_offer');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isExpired(): bool
    {
        if (!$this->expirationDate) {
            return false;
        }

        return $this->expirationDate->isPast();
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function getEmploymentTypeLabel(): string
    {
        return match ($this->employmentType) {
            'cdi' => 'CDI',
            'cdd' => 'CDD',
            'freelance' => 'Freelance',
            'alternance' => 'Alternance',
            'stage' => 'Stage',
            default => 'Non spécifié'
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'draft' => 'Brouillon',
            default => 'Inconnu'
        };
    }

    public function getRemoteLabel(): string
    {
        return $this->remote ? 'Télétravail possible' : 'Présentiel';
    }
}
