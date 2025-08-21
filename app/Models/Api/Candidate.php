<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Candidate extends BaseApiModel
{
    protected $fillable = [
        'userId',
        'dateOfBirth',
        'location',
        'education',
        'experience',
        'skills',
        'languages',
        'resume',
        'jobPreferences',
        'applications',
        'likes',
        'portfolio',
    ];

    protected $casts = [
        'dateOfBirth' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'candidateId');
    }

    public function getAge(): ?int
    {
        if (!$this->dateOfBirth) {
            return null;
        }
        
        return $this->dateOfBirth->age;
    }

    public function getSkillsArray(): array
    {
        if (empty($this->skills)) {
            return [];
        }
        
        return json_decode($this->skills, true) ?? [];
    }

    public function getLanguagesArray(): array
    {
        if (empty($this->languages)) {
            return [];
        }
        
        return json_decode($this->languages, true) ?? [];
    }

    public function getJobPreferencesArray(): array
    {
        if (empty($this->jobPreferences)) {
            return [];
        }
        
        return json_decode($this->jobPreferences, true) ?? [];
    }

    public function getApplicationsArray(): array
    {
        if (empty($this->applications)) {
            return [];
        }
        
        return json_decode($this->applications, true) ?? [];
    }

    public function getLikesArray(): array
    {
        if (empty($this->likes)) {
            return [];
        }
        
        return json_decode($this->likes, true) ?? [];
    }
}
