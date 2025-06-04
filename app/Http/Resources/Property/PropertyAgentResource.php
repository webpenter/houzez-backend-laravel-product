<?php

namespace App\Http\Resources\Property;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyAgentResource extends JsonResource
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
            'facebook' => $this->facebook ?? null,
            'twitter' => $this->twitter ?? null,
            'linkedin' => $this->linkedin ?? null,
            'instagram' => $this->instagram ?? null,
            'google_plus' => $this->google_plus ?? null,
            'youtube' => $this->youtube ?? null,
            'pinterest' => $this->pinterest ?? null,
            'vimeo' => $this->vimeo ?? null,
            'skype' => $this->skype ?? null,
            'website' => $this->website ?? null,
        ];
    }
}
