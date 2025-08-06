<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruiterTeamMember extends Model
{
    protected $fillable = ['recruiter_id', 'name', 'email', 'role'];

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }
}
