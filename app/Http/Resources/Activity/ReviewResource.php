<?php

namespace App\Http\Resources\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'property_title' => $this->property->title,
            'property_slug' => $this->property->slug,
            'email' => $this->email,
            'title' => $this->title,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'date' => timeAgoFormat($this->created_at),
        ];
    }
}
