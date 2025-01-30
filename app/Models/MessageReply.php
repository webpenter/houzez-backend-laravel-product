<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'reply_content',
    ];

    /**
     * Get the message that the reply is associated with.
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the sender (receiver of the original message) of the reply.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'receiver_id'); // Using message receiver_id
    }

    /**
     * Get the receiver (sender of the original message) of the reply.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'sender_id'); // Using message sender_id
    }
}
