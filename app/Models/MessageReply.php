<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = ['tour_request_id', 'user_id', 'message'];

    /**
     * Relationship: Reply belongs to a Tour Request
     */
    public function tourRequest(): BelongsTo
    {
        return $this->belongsTo(TourRequest::class);
    }

    /**
     * Relationship: Reply belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
