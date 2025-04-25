<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Http\Requests\StoreInquiryRequest;
use Illuminate\Http\Request;
use League\Csv\Reader;
use League\Csv\Statement;

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

    public function uploadCsv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        // Get the uploaded file
        $file = $request->file('csv_file');

        // Open the CSV file
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Set the header offset

        // Fetch all records from the CSV
        $records = (new Statement())->process($csv);

        // Prepare data for insertion
        $inquiries = [];
        foreach ($records as $record) {
            $inquiries[] = [
                'user_id' => $record['user_id'],
                'inquiry_type' => $record['inquiry_type'],
                'information_type' => $record['information_type'],
                'first_name' => $record['first_name'],
                'last_name' => $record['last_name'],
                'email' => $record['email'],
                'mobile' => $record['mobile'],
                'location' => $record['location'],
                'city' => $record['city'],
                'area' => $record['area'],
                'state' => $record['state'],
                'country' => $record['country'],
                'zip_code' => $record['zip_code'],
                'property_type' => $record['property_type'],
                'max_price' => $record['max_price'],
                'min_size' => $record['min_size'],
                'beds' => $record['beds'],
                'baths' => $record['baths'],
                'message' => $record['message'],
            ];
        }

        // Insert data into the database
        Inquiry::insert($inquiries);

        return response()->json(['message' => 'Inquiries uploaded successfully.']);
    }
}
