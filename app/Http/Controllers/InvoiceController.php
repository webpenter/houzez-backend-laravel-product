<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query();

        // Apply filters
        if ($request->filled('name')) {
            $invoices->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $invoices->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('address')) {
            $invoices->where('address', 'like', '%' . $request->address . '%');
        }
        if ($request->filled('phone')) {
            $invoices->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('status')) {
            $invoices->where('status', $request->status);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $invoices->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        return response()->json($invoices->get(), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|string',
            'billing_for' => 'required|string',
            'billing_type' => 'required|string',
            'status' => 'required|string',
            'payment_method' => 'required|string',
            'total' => 'required|numeric',
            'user_id' => 'sometimes|string|max:50',
        ]);

        $invoice = Invoice::create($data);

        return response()->json($invoice, 201);
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json($invoice, 200);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return response()->json($invoice, 200);
    }

    public function destroy($id)
    {
        Invoice::destroy($id);
        return response()->json(['message' => 'Invoice deleted'], 200);
    }
}