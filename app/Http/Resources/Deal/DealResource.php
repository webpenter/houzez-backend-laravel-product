<?php

namespace App\Http\Resources\Deal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'user_id' => $this->user_id,
            'group' => $this->group,
            'title' => $this->title,
            'contact_name' => $this->contact_name,
            'agent' => $this->agent,
            'deal_value' => $this->deal_value,
            'status' => $this->status,
            'date' => formatDate($this->created_at),
        ];
    }
}
