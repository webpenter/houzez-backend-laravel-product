<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'user_id' => $this->user_id ?? null,
                'username' => $this->user->username ?? null,
                'email' => $this->user->email ?? null,
                'name' => trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? '')),
                'first_name' => $this->first_name ?? null,
                'last_name' => $this->last_name ?? null,
                'public_name' => $this->public_name ?? null,
            ],
            'avatar' => [
                'profile_picture' => $this->profile_picture ?? null,
            ],
            'user_information' => [
                'title' => $this->title ?? null,
                'position' => $this->position ?? null,
                'license' => $this->license ?? null,
                'mobile' => $this->mobile ?? null,
                'whatsapp' => $this->whatsapp ?? null,
                'phone' => $this->phone ?? null,
                'fax_number' => $this->fax_number ?? null,
                'company_name' => $this->company_name ?? null,
                'address' => $this->address ?? null,
                'tax_number' => $this->tax_number ?? null,
                'service_areas' => $this->service_areas ?? null,
                'specialties' => $this->specialties ?? null,
                'about_me' => $this->about_me ?? null,
            ],
            'social_links' => [
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
            ],
        ];
    }
}
