<?php

namespace App\Http\Controllers\EmailManagement;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailTemplateController extends Controller
{
    /**
     * Store a newly created email template in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // ✅ Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // ✅ Attach created_by field (optional if user logged in)
        $validated['created_by'] = Auth::id();

        // ✅ Create template
        $template = EmailTemplate::create($validated);

        // ✅ Return response
        return response()->json([
            'success' => true,
            'message' => 'Email template created successfully!',
            'data' => $template,
        ], 201);
    }
}
