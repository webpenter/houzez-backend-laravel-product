<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'user_id', 'email', 'title', 'rating', 'comment'];

    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property associated with the review.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
