<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Notification extends BaseApiModel
{
    protected $fillable = [
        'userId',
        'relatedId',
        'relatedType',
        'type',
        'message',
        'isRead',
        'createdAt',
    ];

    protected $casts = [
        'isRead' => 'boolean',
        'createdAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function isUnread(): bool
    {
        return !$this->isRead;
    }

    public function markAsRead(): void
    {
        $this->update(['isRead' => true]);
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'new_document' => 'Nouveau document',
            'new_message' => 'Nouveau message',
            'general' => 'Général',
            default => 'Inconnu'
        };
    }

    public function getRelatedTypeLabel(): string
    {
        return match($this->relatedType) {
            'document' => 'Document',
            'message' => 'Message',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }
}
