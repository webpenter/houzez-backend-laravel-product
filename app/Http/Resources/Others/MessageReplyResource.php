<?php

namespace App\Http\Resources\Others;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageReplyResource extends JsonResource
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
            'tour_request_id' => $this->tour_request_id,
            'user' => [
                'image' => $this->user->profile->profile_picture ?? null,
                'name' => trim(($this->user->profile->first_name ?? '') . ' ' . ($this->user->profile->last_name ?? '')),
            ],
            'message' => $this->message ?? null,
            'date' => formatDate($this->created_at) ?? null,
            'time' => formatTime($this->created_at) ?? null,
        ];
    }
}
