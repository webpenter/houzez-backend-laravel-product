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
     * Display a listing of all templates.
     */
    public function index(): JsonResponse
    {
        $templates = EmailTemplate::with('createdBy')->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Email templates fetched successfully!',
            'total' => $templates->count(),
            'data' => $templates,
        ], 200);
    }

    /**
     * Store a newly created email template in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();

        $template = EmailTemplate::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Email template created successfully!',
            'data' => $template,
        ], 201);
    }

    /**
     * Display the specified template.
     */
    public function show($id): JsonResponse
    {
        $template = EmailTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $template,
        ], 200);
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $template = EmailTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:email_templates,slug,' . $id,
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $template->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Email template updated successfully!',
            'data' => $template,
        ], 200);
    }

    /**
     * Remove the specified template.
     */
    public function destroy($id): JsonResponse
    {
        $template = EmailTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Email template deleted successfully!',
        ], 200);
    }

    /**
     * Toggle active status of a template.
     */
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $template = EmailTemplate::find($id);

        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found.',
            ], 404);
        }

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $template->update(['is_active' => $validated['is_active']]);

        return response()->json([
            'success' => true,
            'message' => 'Template status updated successfully!',
            'data' => $template,
        ], 200);
    }
}
