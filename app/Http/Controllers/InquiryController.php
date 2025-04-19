<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Http\Requests\StoreInquiryRequest;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        return response()->json(Inquiry::with('user')->latest()->get());
    }

    public function store(StoreInquiryRequest $request)
    {
        $inquiry = Inquiry::create($request->validated());
        return response()->json(['message' => 'Inquiry created', 'data' => $inquiry], 201);
    }

    public function show($id)
    {
        $inquiry = Inquiry::with('user')->findOrFail($id);
        return response()->json($inquiry);
    }

    public function update(Request $request, $id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update($request->all());
        return response()->json(['message' => 'Inquiry updated', 'data' => $inquiry]);
    }

    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();
        return response()->json(['message' => 'Inquiry deleted']);
    }
}
