<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Message extends BaseApiModel
{
    protected $fillable = [
        'conversationId',
        'senderId',
        'content',
        'sentAt',
        'isRead',
    ];

    protected $casts = [
        'sentAt' => 'datetime',
        'isRead' => 'boolean',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversationId');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId');
    }

    public function isUnread(): bool
    {
        return !$this->isRead;
    }

    public function markAsRead(): void
    {
        $this->update(['isRead' => true]);
    }

    public function isFromUser(int $userId): bool
    {
        return $this->senderId === $userId;
    }

    public function getFormattedSentAt(): string
    {
        return $this->sentAt->format('d/m/Y H:i');
    }

    public function getShortContent(int $maxLength = 100): string
    {
        if (strlen($this->content) <= $maxLength) {
            return $this->content;
        }
        
        return substr($this->content, 0, $maxLength) . '...';
    }
}
