<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class PropertyLocation extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'address',
        'country',
        'county_state',
        'city',
        'neighborhood',
        'postal_code',
        'latitude',
        'longitude',
        'map_street_view',
    ];
}

