<?php

namespace App\Http\Resources\StripePayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // Subscriptions
            'id' => $this->id,
            'type' => $this->type,
            'stripe_status' => $this->stripe_status,
            'quantity' => $this->quantity,
            'created_at' => formatDate($this->created_at),
            'ends_at' => formatDate($this->ends_at),

            // Subscription Items
            'items' => $this->items->map(function ($item) {
                return [
                    'stripe_product' => $item->stripe_product,
                    'stripe_price' => $item->stripe_price,
                    'quantity' => $item->quantity,
                    'created_at' => formatDate($this->created_at),
                ];
            }),

            // Plan Details
            'plan' => $this->plan ? [
                'name' => strtoupper($this->plan->name ?? null),
                'price' => formatPrice($this->plan->price ?? null),
                'currency_symbol' => currencySymbol($this->plan->currency ?? null),
                'time_period' => formatTextWithNumber($this->plan->interval_count ?? null,$this->plan->billing_method ?? null),
                'properties' => $this->plan->number_of_listings ?? null,
                'images' => $this->plan->number_of_images ?? null,
            ] : null
        ];
    }
}
