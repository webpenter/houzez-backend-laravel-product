<?php

namespace App\Http\Resources\Agent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Demos\Demo01\Property\AppPropertyCardDemo01Resource;

class AgentWithPropertiesResource extends JsonResource
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
            'is_verified' => $this->is_verified, // Include is_verified status
            'name' => trim(($this->profile->first_name ?? '') . ' ' . ($this->profile->last_name ?? '')),
            'email' => $this->email ?? null,
            'about_me' => $this->profile->about_me ?? null,
            'address' => $this->profile->address ?? null,
            'license' => $this->profile->license ?? null,
            'position' => $this->profile->position ?? null,
            'phone' => $this->profile->phone ?? null,
            'mobile' => $this->profile->mobile ?? null,
            'fax_number' => $this->profile->fax_number ?? null,
            'tax_number' => $this->profile->tax_number ?? null,
            'service_areas' => $this->profile->service_areas ?? null,
            'specialties' => $this->profile->specialties ?? null,
            'facebook' => $this->profile->facebook ?? null,
            'instagram' => $this->profile->instagram ?? null,
            'twitter' => $this->profile->twitter ?? null,
            'linkedin' => $this->profile->linkedin ?? null,
            'google_plus' => $this->profile->google_plus ?? null,
            'youtube' => $this->profile->youtube ?? null,
            'pinterest' => $this->profile->pinterest ?? null,
            'vimeo' => $this->profile->vimeo ?? null,
            'skype' => $this->profile->skype ?? null,
            'website' => $this->profile->website ?? null,
            'languages' => $this->profile->languages ?? null,
            'properties' => AppPropertyCardDemo01Resource::collection($this->properties),
            'agencies' => $this->agencies->map(function ($agency) {
                return [
                    'id' => $agency->id,
                    'agency_name' => trim(($agency->profile->first_name ?? '') . ' ' . ($agency->profile->last_name ?? '')),
                ];
            }),
        ];
    }
}
