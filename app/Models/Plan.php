<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'plan_id',
        'name',
        'billing_method',
        'interval_count',
        'price',
        'currency',
        'number_of_listings',
        'number_of_images',
        'taxes',
        'total_price',
        'active',
    ];
}
