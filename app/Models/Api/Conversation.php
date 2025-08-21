<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Conversation extends BaseApiModel
{
    protected $fillable = [
        'participant1Id',
        'participant2Id',
        'createdAt',
        'lastMessageAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'lastMessageAt' => 'datetime',
    ];

    public function participant1()
    {
        return $this->belongsTo(User::class, 'participant1Id');
    }

    public function participant2()
    {
        return $this->belongsTo(User::class, 'participant2Id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getOtherParticipant(int $currentUserId): ?User
    {
        if ($this->participant1Id === $currentUserId) {
            return $this->participant2;
        }
        
        if ($this->participant2Id === $currentUserId) {
            return $this->participant1;
        }
        
        return null;
    }

    public function hasParticipant(int $userId): bool
    {
        return $this->participant1Id === $userId || $this->participant2Id === $userId;
    }

    public function getLastMessage(): ?Message
    {
        return $this->messages()->latest('sentAt')->first();
    }

    public function getUnreadCount(int $userId): int
    {
        return $this->messages()
            ->where('senderId', '!=', $userId)
            ->where('isRead', false)
            ->count();
    }
}
