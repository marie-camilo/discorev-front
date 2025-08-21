<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class Admin extends BaseApiModel
{
    protected $fillable = [
        'userId',
        'role',
        'permissions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
