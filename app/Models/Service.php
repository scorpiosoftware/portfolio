<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['icon', 'title', 'subtitle', 'popular', 'features', 'note', 'price', 'sort_order'];

    protected $casts = [
        'features' => 'array',
        'popular'  => 'boolean',
    ];
}
