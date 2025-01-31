<?php

namespace App\Http\Resources\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message_content' => $this->message_content,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
