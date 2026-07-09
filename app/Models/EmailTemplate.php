<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'signature',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
