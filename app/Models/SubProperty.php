<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProperty extends Model
{
    protected $fillable = [
        'title',
        'bedrooms',
        'bathrooms',
        'garages',
        'garage_size',
        'area_size',
        'size_prefix',
        'price',
        'price_label',
        'property_id', // Ensure this is fillable
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
