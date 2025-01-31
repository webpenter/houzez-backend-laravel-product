<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageReplyResource;
use App\Models\Message;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageReplyController extends Controller
{
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

    /**
     * Show a single reply.
     */
    public function show($id)
    {
        $reply = MessageReply::findOrFail($id);
        return new MessageReplyResource($reply);
    }

    /**
     * Fetch all replies for a specific message.
     */
    public function index($messageId)
    {
        $replies = MessageReply::where('message_id', $messageId)->latest()->get();
        return MessageReplyResource::collection($replies);
    }

    /**
     * Update a reply.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'reply_content' => 'required|string|max:5000',
        ]);

        $reply = MessageReply::findOrFail($id);
        $reply->update([
            'reply_content' => $request->reply_content,
        ]);

        return new MessageReplyResource($reply);
    }

    /**
     * Delete a reply.
     */
    public function destroy($id)
    {
        $reply = MessageReply::findOrFail($id);
        $reply->delete();

        return response()->json(['message' => 'Reply deleted']);
    }
}   
