<?php

namespace App\Http\Resources\Agent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentsResource extends JsonResource
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
            'email' => $this->email ?? null,
            'position' => $this->profile->position ?? null,
            'phone' => $this->profile->phone ?? null,
            'mobile' => $this->profile->mobile ?? null,
            'fax' => $this->profile->fax ?? null,
            'facebook' => $this->profile->facebook ?? null,
            'instagram' => $this->profile->instagram ?? null,
            'twitter' => $this->profile->twitter ?? null,
            'linkedin' => $this->profile->linkedin ?? null,
            'google_plus' => $this->profile->google_plus ?? null,
            'youtube' => $this->profile->youtube ?? null,
            'pinterest' => $this->profile->pinterest ?? null,
            'vimeo' => $this->profile->vimeo ?? null,
            'skype' => $this->profile->skype ?? null,
        ];
    }
}
