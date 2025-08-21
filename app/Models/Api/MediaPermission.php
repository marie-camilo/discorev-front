<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class MediaPermission extends BaseApiModel
{
    protected $fillable = [
        'mediaId',
        'userId',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'mediaId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
