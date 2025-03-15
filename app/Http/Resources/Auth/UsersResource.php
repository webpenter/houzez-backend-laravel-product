<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
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
            'profile' => $this->profile->profile_picture ?? null,
            'username' => $this->username,
            'name' => trim(($this->profile->first_name ?? '') . ' ' . ($this->profile->last_name ?? '')),
            'email' => $this->email,
            'role' => $this->role,
            'properties' => $this->properties->count(),
        ];
    }
}
