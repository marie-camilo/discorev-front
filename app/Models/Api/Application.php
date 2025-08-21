<?php

namespace App\Models\Api;

use App\Models\Api\Candidate;
use App\Models\Api\JobOffer;
use App\Models\Api\BaseApiModel;

class Application extends BaseApiModel
{
    protected $fillable = [
        'candidateId',
        'jobOfferId',
        'status',
        'dateApplied',
        'notes',
    ];

    protected $casts = [
        'dateApplied' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidateId');
    }

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class, 'jobOfferId');
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    public function isViewed(): bool
    {
        return $this->status === 'viewed';
    }

    public function isInterview(): bool
    {
        return $this->status === 'interview';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            'sent' => 'Envoyée',
            'viewed' => 'Consultée',
            'interview' => 'Entretien',
            'pending' => 'En attente',
            'rejected' => 'Refusée',
            'accepted' => 'Acceptée',
            default => 'Inconnu'
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'sent' => 'blue',
            'viewed' => 'yellow',
            'interview' => 'orange',
            'pending' => 'purple',
            'rejected' => 'red',
            'accepted' => 'green',
            default => 'gray'
        };
    }
}
