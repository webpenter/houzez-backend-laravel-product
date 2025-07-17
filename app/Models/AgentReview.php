<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'user_id',
        'title',
        'rating',
        'comment',
    ];

    /**
     * Get the agent that owns the review.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
