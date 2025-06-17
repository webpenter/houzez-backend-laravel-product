<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyVisit extends Model
{
    protected $fillable = [
        'property_id', 'ip_address', 'device', 'platform', 'browser', 'country'
    ];

    /**
     * Define a belongsTo relationship with the Property model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
