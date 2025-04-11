<?php

namespace App\Http\Resources\Others;

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
            'property_id' => $this->property_id,
            'user' => [
                'name' => trim(($this->user->profile->first_name ?? '') . ' ' . ($this->user->profile->last_name ?? ''))
            ],
            'email' => $this->email,
            'title' => $this->title,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => formatDate($this->created_at),
        ];
    }
}
