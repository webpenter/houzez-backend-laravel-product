<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;

class InvoicesController extends Controller
{
    /**
     * Retrieve the authenticated user's invoices and recent Stripe charges.
     *
     * This function fetches:
     * - Invoices from the application's database and formats them.
     * - Recent charges (last 10) from Stripe if the user has a Stripe customer ID.
     * - Combines and sorts invoices and charges by creation date in descending order.
     * - Returns a JSON response with the formatted data.
     *
     * @return JsonResponse
     */
    public function invoices(): JsonResponse
    {
        $user = auth()->user();

        $invoices = $user->invoices()->map(function ($invoice) {
            return [
                'type' => 'invoice',
                'id' => $invoice->id,
                'amount' => $invoice->total(),
                'status' => $invoice->status,
                'created_at' => formatDate($invoice->date()),
                'url' => $invoice->hosted_invoice_url,
            ];
        });

        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($user && $user->stripe_id) {
            $charges = Charge::all([
                'limit' => 10,
                'customer' => $user->stripe_id,
            ])->data;

            $formattedCharges = collect($charges)->map(function ($charge) {
                return [
                    'type' => 'charge',
                    'id' => $charge->id,
                    'amount' => $charge->amount,
                    'status' => $charge->status,
                    'created_at' => formatDate($charge->created),
                    'receipt_url' => $charge->receipt_url,
                ];
            });
        } else {
            return new JsonResponse([
                'success' => false,
                'message' => 'User does not have a Stripe customer ID',
            ]);
        }

        $data = $invoices->concat($formattedCharges);

        $data = $data->sortByDesc('created_at')->values();

        return new JsonResponse([
            'success' => true,
            'message' => 'Invoices and transactions retrieved',
            'data' => $data,
        ]);
    }
}
