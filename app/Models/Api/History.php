<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class History extends BaseApiModel
{
    protected $fillable = [
        'userId',
        'relatedId',
        'relatedType',
        'actionType',
        'details',
        'createdAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function getActionTypeLabel(): string
    {
        return match($this->actionType) {
            'create' => 'Création',
            'update' => 'Modification',
            'delete' => 'Suppression',
            'view' => 'Consultation',
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }

    public function getRelatedTypeLabel(): string
    {
        return match($this->relatedType) {
            'document' => 'Document',
            'message' => 'Message',
            'auth' => 'Authentification',
            'profile' => 'Profil',
            'job_offer' => 'Offre d\'emploi',
            'other' => 'Autre',
            default => 'Inconnu'
        };
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('d/m/Y H:i:s');
    }

    public function getDetailsArray(): array
    {
        if (empty($this->details)) {
            return [];
        }
        
        return json_decode($this->details, true) ?? [];
    }
}
