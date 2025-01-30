<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    protected $fillable = [
        'plan_title',
        'plan_bedroom',
        'plan_bathroom',
        'plan_price',
        'price_postfix',
        'plan_image',
        'plan_description',

    ];

    protected function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
