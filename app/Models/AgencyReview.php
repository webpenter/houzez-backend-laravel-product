<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AgencyReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id',
        'user_id',
        'title',
        'rating',
        'comment',
    ];

     /**
     * Get the agency that owns the review.
     */
    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
