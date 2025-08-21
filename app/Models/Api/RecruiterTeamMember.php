<?php

namespace App\Models\Api;

use App\Models\Api\Recruiter;
use App\Models\Api\BaseApiModel;

class RecruiterTeamMember extends BaseApiModel
{
    protected $fillable = [
        'recruiterId',
        'name',
        'email',
        'role',
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiterId');
    }
}
