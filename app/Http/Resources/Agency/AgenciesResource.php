<?php

namespace App\Http\Resources\Agency;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgenciesResource extends JsonResource
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
            'is_verified' => $this->is_verified ?? null,
            'position' => $this->profile->position ?? null,
            'phone' => $this->profile->phone ?? null,
            'address' => $this->profile->address ?? null,
            'mobile' => $this->profile->mobile ?? null,
            'fax_number' => $this->profile->fax_number ?? null,
            'facebook' => $this->profile->facebook ?? null,
            'instagram' => $this->profile->instagram ?? null,
            'twitter' => $this->profile->twitter ?? null,
            'linkedin' => $this->profile->linkedin ?? null,
            'google_plus' => $this->profile->google_plus ?? null,
            'youtube' => $this->profile->youtube ?? null,
            'pinterest' => $this->profile->pinterest ?? null,
            'vimeo' => $this->profile->vimeo ?? null,
            'skype' => $this->profile->skype ?? null,
            'average_rating' => round($this->agent_reviews_avg_rating, 1), // default to 0 if needed
        ];
    }
}
