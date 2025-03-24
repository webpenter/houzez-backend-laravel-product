<?php

namespace App\Http\Resources\Others;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'property' => [
                'id' => $this->property->id,
                'title' => $this->property->title,
                'owner_id' => $this->property->user->id,
                'owner_name' => $this->property->user->name,
            ],
            'tour_type' => $this->tour_type,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'tour_date_time' => $this->tour_date_time,
            'message' => $this->message,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
