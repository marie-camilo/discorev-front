<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Media extends BaseApiModel
{
    protected $fillable = [
        'uploaderId',
        'uploaderType',
        'type',
        'context',
        'targetId',
        'targetType',
        'title',
        'filePath',
        'mimeType',
        'thumbnailPath',
        'visibility',
        'uploadedAt',
    ];

    protected $casts = [
        'uploadedAt' => 'datetime',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaderId');
    }

    public function permissions()
    {
        return $this->hasMany(MediaPermission::class);
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
            'profile_picture' => 'Photo de profil',
            'company_logo' => 'Logo entreprise',
            'company_banner' => 'Bannière entreprise',
            'company_image' => 'Image entreprise',
            'company_video' => 'Vidéo entreprise',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }

    public function getContextLabel(): string
    {
        return match($this->context) {
            'user_profile' => 'Profil utilisateur',
            'company_page' => 'Page entreprise',
            'job_offer' => 'Offre d\'emploi',
            'article' => 'Article',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }
}
