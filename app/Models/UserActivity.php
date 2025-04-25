<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_type',
        'page_url',
        'time_spent',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'time_spent' => 'integer',
    ];


    // Defining the relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
