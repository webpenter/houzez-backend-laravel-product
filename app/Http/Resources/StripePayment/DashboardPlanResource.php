<?php

namespace App\Http\Resources\StripePayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ?? null,
            'plan_id' => $this->plan_id ?? null,
            'name' => $this->name ?? null,
            'price' => formatPrice($this->price ?? null),
            'currency' => $this->currency ?? null,
            'time_period' => formatTextWithNumber($this->interval_count ?? null,$this->billing_method ?? null),
            'active' => $this->active ? 'Yes' : 'No',
            'number_of_listings' => $this->number_of_listings ?? null,
            'number_of_images' => $this->number_of_images ?? null,
        ];
    }
}
