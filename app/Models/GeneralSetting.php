<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * GeneralSetting Model
 *
 * This model represents the general settings of the site,
 * such as logos, hero section content, contact information, and social media links.
 * Typically only one record is stored and used site-wide.
 */
class GeneralSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * These fields can be filled using mass-assignment (e.g., $model->fill([...])->save()).
     * Make sure that all fields listed here are safe to be filled from user input.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // Image Paths
        'logo',
        'bg_image',
        'hero_image',

        // Hero Section Content
        'hero_title',
        'hero_caption',

        // Contact Information
        'address',
        'phone1',
        'phone2',
        'email1',
        'email2',

        // Footer
        'footer_caption',

        // Social Media Links
        'facebook_link',
        'twitter_link',
        'instagram_link',
    ];
}
