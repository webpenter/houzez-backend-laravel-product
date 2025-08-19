<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface
{
    public function all(): Collection
    {
        return Setting::all();
    }

    public function get(string $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }

    public function getVisibleSocialLinks(): array
    {
        $socialKeys = [
            'facebook_url'   => 'icon-social-media-facebook',
            'instagram_url'  => 'icon-social-instagram',
            'twitter_url'    => 'icon-x-logo-twitter-logo-2',
            'linkedin_url'   => 'icon-professional-network-linkedin',
            'googleplus_url' => 'icon-social-media-google-plus-1',
            'youtube_url'    => 'icon-social-video-youtube-clip',
            'pinterest_url'  => 'icon-social-pinterest',
            'vimeo_url'      => 'icon-social-video-vimeo',
            'skype_url'      => 'icon-social-skype',
            'website_url'      => 'icon-website',
        ];

        return Setting::whereIn('key', array_keys($socialKeys))
            ->where('is_visible', true)
            ->get()
            ->map(function ($setting) use ($socialKeys) {
                return [
                    'platform' => str_replace('_url', '', $setting->key),
                    'url'      => $setting->value,
                    'icon'     => $socialKeys[$setting->key] ?? 'icon-default',
                ];
            })
            ->toArray();
    }


    public function updateOrCreate(array $data): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $data['key']],
            [
                'value' => $data['value'],
                'type' => $data['type'] ?? 'string',
                'is_visible' => $data['is_visible'] ?? true,
            ]
        );
    }
}
