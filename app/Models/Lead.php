<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Corrected import
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
    ];
}
