<?php

namespace App\Models\Api;

use App\Models\Api\Recruiter;
use App\Models\Api\BaseApiModel;

class Payment extends BaseApiModel
{
    protected $fillable = [
        'subscriptionId',
        'amount',
        'currency',
        'paymentMethod',
        'paymentStatus',
        'transactionId',
        'paidAt',
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'paidAt' => 'datetime',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscriptionId');
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

    public function getFormattedPaidAt(): string
    {
        return $this->updatedAt->format('d/m/Y H:i:s');
    }
}
