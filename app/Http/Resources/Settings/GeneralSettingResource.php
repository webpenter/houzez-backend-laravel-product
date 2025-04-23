<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralSettingResource extends JsonResource
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
            'logo' => $this->logo,
            'bg_image' => $this->bg_image,
            'hero_image' => $this->hero_image,
            'hero_title' => $this->hero_title,
            'hero_caption' => $this->hero_caption,
            'address' => $this->address,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'email_1' => $this->email_1,
            'email_2' => $this->email_2,
            'footer_caption' => $this->footer_caption,
            'facebook_link' => $this->facebook_link,
            'twitter_link' => $this->twitter_link,
            'instagram_link' => $this->instagram_link,
        ];
    }
}
