<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{   
    /**
     * Store a newly created message in storage.
     */
    public function send(Request $request)
    {
        // Validate request data
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'receiver_id' => 'required|exists:users,id',
            'message_content' => 'required|string|max:5000',
        ]);

        // Create message
        $message = Message::create([
            'property_id' => $request->property_id,
            'sender_id' => Auth::id(), // Get logged-in user as sender
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ], 201);
    }

     /**
     * Store a newly created reply in storage.
     */
    public function reply(Request $request, $messageId)
    {
        // Validate the request data
        $request->validate([
            'reply_content' => 'required|string|max:5000',
        ]);

        // Find the original message
        $message = Message::findOrFail($messageId);

        // Ensure the authenticated user is the receiver of the original message
        if ($message->receiver_id !== Auth::id()) {
            return response()->json([
                'message' => 'You can only reply to messages sent to you.',
            ], 403);
        }

        // Create the reply using the relationship (no need to manually set sender/receiver IDs)
        $reply = MessageReply::create([
            'message_id' => $message->id,
            'reply_content' => $request->reply_content,
        ]);

        return response()->json([
            'message' => 'Reply sent successfully',
            'data' => $reply,
        ], 201);
    }
}
