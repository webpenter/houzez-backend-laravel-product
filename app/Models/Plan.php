<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'stripe_price', 'plan_id');
    }
}
