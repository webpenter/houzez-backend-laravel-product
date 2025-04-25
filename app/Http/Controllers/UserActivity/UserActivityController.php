<?php

namespace App\Http\Controllers\UserActivity;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    // Store user activity (e.g., page visit, click, etc.)
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'activity_type' => 'required|string',  // 'visit', 'click', etc.
            'page_url' => 'required|string',  // URL or property page identifier
            'time_spent' => 'nullable|integer', // Time in seconds (optional for page visits)
        ]);

        // Store the activity
        $activity = UserActivity::create([
            'user_id' => auth()->check() ? auth()->id() : null,  // Store user ID if authenticated
            'activity_type' => $request->activity_type,
            'page_url' => $request->page_url,
            'time_spent' => $request->time_spent,  // Time spent on page, if applicable
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return response()->json([
            'success' => true,
            'activity' => $activity
        ], 201);
    }

    // Fetch activities for a specific user
    public function getUserActivities($userId)
    {
        $activities = UserActivity::where('user_id', $userId)->get();

        return response()->json([
            'activities' => $activities
        ]);
    }

    // Fetch all activities (for admins)
    public function getAllActivities()
    {
        $activities = UserActivity::all();

        return response()->json([
            'activities' => $activities
        ]);
    }
}
