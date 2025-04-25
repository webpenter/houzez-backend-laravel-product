<?php

namespace App\Http\Controllers\Insight;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class InsightController extends Controller
{
    // Fetch all insights for all properties
    public function getAllInsights()
    {
        $insights = Insight::with('property')->get()->map(function ($insight) {
            return [
                'property_id' => $insight->property_id,
                'views' => $insight->views,
                'unique_views' => $insight->unique_views,
                'visits' => $insight->visits,
                'devices' => json_decode($insight->devices),
                'countries' => json_decode($insight->countries),
                'platforms' => json_decode($insight->platforms),
                'browsers' => json_decode($insight->browsers),
                'referrals' => json_decode($insight->referrals),
            ];
        });

        return response()->json($insights);
    }

    // Fetch insights for a specific property by its ID
    public function getPropertyInsights($propertyId)
    {
        $insight = Insight::where('property_id', $propertyId)->first();

        if (!$insight) {
            return response()->json(['message' => 'No insights found for this property'], 404);
        }

        return response()->json([
            'property_id' => $insight->property_id,
            'views' => $insight->views,
            'unique_views' => $insight->unique_views,
            'visits' => $insight->visits,
            'devices' => json_decode($insight->devices),
            'countries' => json_decode($insight->countries),
            'platforms' => json_decode($insight->platforms),
            'browsers' => json_decode($insight->browsers),
            'referrals' => json_decode($insight->referrals),
            'updated_at' => $this->formatTimeAgo($insight->updated_at), // Custom time format
        ]);
    }

    // Update insights data when a user interacts with the site
    public function trackUserInteraction(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'device' => 'required|string',
            'country' => 'required|string',
            'platform' => 'required|string',
            'browser' => 'required|string',
            'referral' => 'nullable|string',
        ]);

        $propertyId = $validated['property_id'];

        // Get or create the insight for the property
        $insight = Insight::firstOrCreate(
            ['property_id' => $propertyId],
            [
                'views' => 0,
                'unique_views' => 0,
                'visits' => 0,
                'devices' => json_encode([]),
                'countries' => json_encode([]),
                'platforms' => json_encode([]),
                'browsers' => json_encode([]),
                'referrals' => json_encode([]),
            ]
        );

        // Track the visit (increment views and visits)
        $insight->increment('views');
        $insight->increment('visits');

        // Track unique views (only increment if the user has not already viewed this property)
        if (!Session::has("property_{$propertyId}_viewed")) {
            $insight->increment('unique_views');
            Session::put("property_{$propertyId}_viewed", true);
        }

        // Track device information (update devices data)
        $devices = json_decode($insight->devices, true);
        $devices[$validated['device']] = isset($devices[$validated['device']]) ? $devices[$validated['device']] + 1 : 1;
        $insight->devices = json_encode($devices);

        // Track country information (update countries data)
        $countries = json_decode($insight->countries, true);
        $countries[$validated['country']] = isset($countries[$validated['country']]) ? $countries[$validated['country']] + 1 : 1;
        $insight->countries = json_encode($countries);

        // Track platform information (update platforms data)
        $platforms = json_decode($insight->platforms, true);
        $platforms[$validated['platform']] = isset($platforms[$validated['platform']]) ? $platforms[$validated['platform']] + 1 : 1;
        $insight->platforms = json_encode($platforms);

        // Track browser information (update browsers data)
        $browsers = json_decode($insight->browsers, true);
        $browsers[$validated['browser']] = isset($browsers[$validated['browser']]) ? $browsers[$validated['browser']] + 1 : 1;
        $insight->browsers = json_encode($browsers);

        // Track referral information (update referrals data)
        if ($validated['referral']) {
            $referrals = json_decode($insight->referrals, true);
            $referrals[$validated['referral']] = isset($referrals[$validated['referral']]) ? $referrals[$validated['referral']] + 1 : 1;
            $insight->referrals = json_encode($referrals);
        }

        // Save the updated insights
        $insight->save();

        return response()->json([
            'message' => 'Interaction tracked successfully',
            'insight' => $insight
        ]);
    }

    // Format time difference for "X time ago"
    private function formatTimeAgo($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }
}
