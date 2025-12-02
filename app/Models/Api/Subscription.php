<?php

namespace App\Models\Api;

use App\Models\Api\Recruiter;
use App\Models\Api\BaseApiModel;

class Subscription extends BaseApiModel
{
    protected $fillable = [
        'recruiterId',
        'planId',
        'startDate',
        'endDate',
        'autoRenew',
        'status',
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiterId');
    }

    public function plan()
    {
        return $this->belongsTo(Recruiter::class, 'planId');
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('d/m/Y H:i:s');
    }

    public function getFormattedUpdatedAt(): string
    {
        return $this->updatedAt->format('d/m/Y H:i:s');
    }
}
