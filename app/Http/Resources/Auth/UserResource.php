<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'name' => trim(($this->profile->first_name ?? '') . ' ' . ($this->profile->last_name ?? '')),
            'email' => $this->email,
            'is_admin' => $this->is_admin
        ];
    }
}
