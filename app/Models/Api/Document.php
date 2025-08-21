<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Document extends BaseApiModel
{
    protected $fillable = [
        'senderId',
        'senderType',
        'title',
        'type',
        'visibility',
        'filePath',
        'uploadedAt',
    ];

    protected $casts = [
        'uploadedAt' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'senderId');
    }

    public function permissions()
    {
        return $this->hasMany(DocumentPermission::class);
    }

    public function isPublic(): bool
    {
        return $this->visibility === 'public';
    }

    public function isPrivate(): bool
    {
        return $this->visibility === 'private';
    }

    public function isShared(): bool
    {
        return $this->visibility === 'shared';
    }

    public function getTypeLabel(): string
    {
        return match($this->type) {
            'cv' => 'CV',
            'contract' => 'Contrat',
            'offer_letter' => 'Lettre d\'offre',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }

    public function getSenderTypeLabel(): string
    {
        return match($this->senderType) {
            'candidate' => 'Candidat',
            'recruiter' => 'Recruteur',
            default => 'Inconnu'
        };
    }
}
