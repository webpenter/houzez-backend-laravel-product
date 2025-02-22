<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'site_logo', 'site_name', 'site_title', 'site_description',
        'site_address', 'contact_number', 'email_address',
        'facebook_link', 'instagram_link', 'twitter_link', 'linkedin_link',
        'hero_title', 'hero_description', 'hero_section_image',
        'new_user_default_role', 'site_language', 'footer_description',
    ];
}
