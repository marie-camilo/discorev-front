<?php

namespace App\Models\Api;

use App\Models\User;
use App\Models\Api\BaseApiModel;

class DocumentPermission extends BaseApiModel
{
    protected $fillable = [
        'documentId',
        'receiverId',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'documentId');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiverId');
    }
}
