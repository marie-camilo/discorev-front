<?php

namespace App\Models\Api;

use App\Models\Api\BaseApiModel;

class Tag extends BaseApiModel
{
    protected $fillable = [
        'categoryId',
        'name',
        'slug',
        'createdAt',
        'updatedAt',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    public function getFormattedCreatedAt(): string
    {
        return $this->createdAt->format('d/m/Y H:i:s');
    }

    public function getFormattedUpdatedAt(): string
    {
        return $this->updatedAt->format('d/m/Y H:i:s');
    }
}
