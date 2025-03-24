<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'property_id', 'tour_type', 'name', 'phone', 'email', 'tour_date_time', 'message'
    ];

    /**
     * Get the user associated with the tour request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property associated with the tour request.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function setTourDateTimeAttribute($value)
    {
        $this->attributes['tour_date_time'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
