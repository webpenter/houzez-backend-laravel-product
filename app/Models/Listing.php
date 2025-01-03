<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Listing extends Model
{
    use HasFactory, HasApiTokens;

    // Columns that can be mass-assigned
    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'labels',
        'price',
        'second_price',
        'after_price_label',
        'price_prefix',
        'custom_fields',
        'bedrooms',
        'bathrooms',
        'garages',
        'garages_size',
        'area_size',
        'size_prefix',
        'land_area',
        'land_area_size_postfix',
        'user_id',
        'year_built',
        'additional_details',
    ];

    // Cast 'additional_details' to an array
    protected $casts = [
        'additional_details' => 'array',
    ];

    // Relationships (Remove this if not required)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
