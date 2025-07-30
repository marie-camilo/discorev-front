<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Recruiter extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    protected $fillable = [
        'userId',
        'companyName',
        'siret',
        'companyLogo',
        'companyDescription',
        'location',
        'website',
        'sector',
        'teamSize',
        'contactPerson',
    ];
}
