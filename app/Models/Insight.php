<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'views',
        'unique_views',
        'visits',
        'devices',
        'countries',
        'platforms',
        'browsers',
        'referrals',
    ];

    protected $casts = [
        'devices' => 'array',
        'countries' => 'array',
        'platforms' => 'array',
        'browsers' => 'array',
        'referrals' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
