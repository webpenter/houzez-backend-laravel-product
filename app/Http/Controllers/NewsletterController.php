<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Validate email input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please enter a valid email!',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Check if email already exists in the database
        if (Subscriber::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'You are already subscribed!'
            ], 409);
        }
    
        // Store email in the subscribers table
        $subscriber = Subscriber::create([
            'email' => $request->email,
        ]);
    
        return response()->json([
            'message' => 'Successfully subscribed to the newsletter.',
            'data' => $subscriber
        ], 201);
    }
    
}
