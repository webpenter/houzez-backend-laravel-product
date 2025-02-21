<?php

namespace App\Http\Resources\StripePayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SelectPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'plan_id' => $this->plan_id ?? null,
            'name' => strtoupper($this->name ?? null),
            'price' => formatPrice($this->price ?? null),
            'currency_symbol' => currencySymbol($this->currency ?? null),
            'time_period' => formatTextWithNumber($this->interval_count ?? null,$this->billing_method ?? null),
            'properties' => $this->number_of_listings ?? null,
            'images' => $this->number_of_images ?? null,
        ];
    }
}
