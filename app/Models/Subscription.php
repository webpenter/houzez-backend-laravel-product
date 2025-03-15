<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    protected $fillable = [
        'user_id',
        'type',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at'
    ];

    /**
     * Get the user that owns this model.
     *
     * This function defines a one-to-one inverse relationship
     * between the current model and the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan associated with this model.
     *
     * This function defines a one-to-one inverse relationship
     * between the current model and the Plan model.
     *
     * The relationship is based on the 'stripe_price' column
     * in the current model, which corresponds to 'plan_id' in the Plan model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'stripe_price', 'plan_id');
    }
}
