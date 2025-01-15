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
                'username' => $this->user->username ?? null,
                'email' => $this->user->email ?? null,
                'first_name' => $this->first_name ?? null,
                'last_name' => $this->last_name ?? null,
                'public_name' => $this->public_name ?? null,
                'title' => $this->title ?? null,
                'position' => $this->position ?? null,
                'license' => $this->license ?? null,
                'mobile' => $this->mobile ?? null,
                'whatsapp' => $this->whatsapp ?? null,
                'phone' => $this->phone ?? null,
                'tax_number' => $this->fax_number ?? null,
                'company_name' => $this->company_name ?? null,
                'address' => $this->address ?? null,
                'tax_number' => $this->tax_number ?? null,
                'service_areas' => $this->service_areas ?? null,
                'specialties' => $this->specialties ?? null,
                'about_me' => $this->about_me ?? null,
        ];
    }
}
