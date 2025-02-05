<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Store a newly created message.
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
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content,
        ]);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => new MessageResource($message)
        ], 201);
    }

    /**
     * Display the specified message.
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        return response()->json(new MessageResource($message));
    }

    /**
     * Get all messages for the authenticated user.
     */
    public function index()
    {
        $messages = Message::where('sender_id', Auth::id())
                            ->orWhere('receiver_id', Auth::id())
                            ->latest()
                            ->get(); // Fetch messages
        
        return MessageResource::collection($messages);
    }
    

    /**
     * Update the specified message.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'message_content' => 'required|string|max:5000',
        ]);

        $message = Message::where('id', $id)
                          ->where('sender_id', Auth::id()) // Only sender can edit
                          ->firstOrFail();

        $message->update([
            'message_content' => $request->message_content,
        ]);

        return response()->json([
            'message' => 'Message updated successfully',
            'data' => new MessageResource($message)
        ]);
    }

    /**
     * Remove the specified message.
     */
    public function destroy($id)
    {
        $message = Message::where('id', $id)
                          ->where('sender_id', Auth::id()) // Only sender can delete
                          ->firstOrFail();

        $message->delete();

        return response()->json([
            'message' => 'Message deleted successfully',
        ]);
    }
}