<?php

namespace App\Models\Api;

use App\Models\Api\BaseApiModel;
use App\Traits\CamelCaseAttributes;

class User extends BaseApiModel
{
    use CamelCaseAttributes;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'phoneNumber',
        'accountType',
        'createdAt',
        'updatedAt',
        'isActive',
        'lastLogin',
        'newsletter',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
        'isActive' => 'boolean',
        'lastLogin' => 'datetime',
        'newsletter' => 'boolean',
    ];

    public function isCandidate(): bool
    {
        return $this->accountType === 'candidate';
    }

    public function isRecruiter(): bool
    {
        return $this->accountType === 'recruiter';
    }

    public function recruiter()
    {
        return $this->hasOne(Recruiter::class, 'userId');
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'userId');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'senderId');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'uploaderId');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'userId');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'participant1Id')
            ->orWhere('participant2Id', $this->id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'senderId');
    }

    public function histories()
    {
        return $this->hasMany(History::class, 'userId');
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getAccountTypeLabel(): string
    {
        return match($this->accountType) {
            'candidate' => 'Candidat',
            'recruiter' => 'Recruteur',
            default => 'Inconnu'
        };
    }
}
