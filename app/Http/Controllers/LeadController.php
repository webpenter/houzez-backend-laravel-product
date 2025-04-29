<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = Lead::all();

        return response()->json($leads, 200);  // Return leads with a 200 OK status
    }

    /**
     * Store a newly created lead in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'message' => 'nullable|string',
//            'property_id' => 'required|exists:properties,id',  // assuming properties table exists
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);  // Unprocessable Entity (validation errors)
        }

        $lead = Lead::create($request->all());

        return response()->json([
            'message' => 'Lead created successfully',
            'data' => $lead,
        ], 201);  // 201 Created status
    }

    /**
     * Display the specified lead.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Lead $lead)
    {
        return response()->json($lead, 200);
    }

    /**
     * Update the specified lead in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lead $lead)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,contacted,closed',  // Example validation for status field
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lead->update($request->only(['status']));  // Update only the fields that are passed

        return response()->json([
            'message' => 'Lead updated successfully',
            'data' => $lead,
        ], 200);  // Return updated lead data with a 200 OK status
    }

    /**
     * Remove the specified lead from storage.
     *
     * @param  \App\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return response()->json([
            'message' => 'Lead deleted successfully',
        ], 200);  // Return a success message with 200 OK status
    }
}
