<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\RecruiterTeamMember;
use App\Models\Api\Media;
use App\Models\Api\JobOffer;
use App\Models\Api\BaseApiModel;

class Recruiter extends BaseApiModel
{
    protected $fillable = [
        'userId',
        'companyName',
        'siret',
        'companyDescription',
        'location',
        'website',
        'sector',
        'teamSize',
        'contactPhone',
        'contactEmail',
        'teamMembers',
        'medias'
    ];

    public static function fromApiData(array $data): static
    {
        $recruiter = parent::fromApiData($data);

        // Team members → objets RecruiterTeamMember
        $teamMembersData = $data['teamMembers'] ?? [];
        $recruiter->teamMembers = collect($teamMembersData)
            ->map(fn($memberData) => RecruiterTeamMember::fromApiData((array)$memberData))
            ->all();

        // Médias → objets Media
        $mediasData = $data['medias'] ?? [];
        $recruiter->medias = collect($mediasData)
            ->map(fn($mediaData) => Media::fromApiData((array)$mediaData))
            ->all();

        return $recruiter;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function teamMembers()
    {
        return $this->hasMany(RecruiterTeamMember::class, 'recruiterId');
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class, 'recruiterId');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'targetId')
            ->where('targetType', 'recruiter');
    }

    public function getTeamSizeLabel(): string
    {
        return match ($this->teamSize) {
            '1-10' => '1-10 employés',
            '11-50' => '11-50 employés',
            '51-200' => '51-200 employés',
            '201-500' => '201-500 employés',
            '500+' => 'Plus de 500 employés',
            default => $this->teamSize ?? 'Non spécifié'
        };
    }
}
