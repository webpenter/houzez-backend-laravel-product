<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_name',
        'first_name',
        'last_name',
        'title',
        'position',
        'license',
        'mobile',
        'whatsapp',
        'phone',
        'fax_number',
        'company_name',
        'address',
        'tax_number',
        'service_areas',
        'specialties',
        'about_me',
        'profile_picture',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'google_plus',
        'youtube',
        'pinterest',
        'vimeo',
        'skype',
        'website',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
