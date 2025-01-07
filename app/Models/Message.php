<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Message extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'from',
        'property',
        'message',
        'image',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

