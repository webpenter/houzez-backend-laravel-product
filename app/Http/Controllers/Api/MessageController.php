<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('user_id', Auth::id())->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'from' => 'required|string',
            'property' => 'required|string',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $message = Message::create([
            'user_id' => Auth::id(),
            'from' => $request->from,
            'property' => $request->property,
            'message' => $request->message,
            'image' => $imagePath,
            'date' => $request->date,
        ]);

        return response()->json($message, 201);
    }

    public function show($id)
    {
        $message = Message::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($message);
    }

    public function update(Request $request, $id)
    {
        $message = Message::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'from' => 'sometimes|string',
            'property' => 'sometimes|string',
            'message' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'date' => 'sometimes|date',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $message->image = $imagePath;
        }

        $message->update($request->only(['from', 'property', 'message', 'date']));

        return response()->json($message);
    }

    public function destroy($id)
    {
        $message = Message::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
}
