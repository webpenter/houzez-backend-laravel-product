<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'is_visible',
    ];

    // Casts for boolean and json types
    protected $casts = [
        'is_visible' => 'boolean',
        'value' => 'array', // if you store JSON values sometimes
    ];
}
