<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * --------------------------------------------------------------------------
     * Mass Assignment Protection
     * --------------------------------------------------------------------------
     * The fields listed in the $fillable array are the only attributes that can
     * be mass-assigned. Sensitive fields such as `user_id` are intentionally
     * excluded to prevent unauthorized ownership changes.
     */
    protected $fillable = [
        'user_id',
        'public_name',       // Display name shown publicly
        'first_name',
        'last_name',
        'title',             // Position title (e.g., Realtor, Broker)
        'position',          // Corporate or job title
        'license',           // License or registration number
        'mobile',
        'whatsapp',
        'phone',
        'fax_number',
        'company_name',
        'address',
        'tax_number',        // Tax/registration number
        'service_areas',     // Comma-separated values or JSON
        'specialties',       // Special skills or industry specialties
        'about_me',          // Bio or profile description
        'profile_picture',   // Path or URL to profile picture
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
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     * Every profile belongs to a specific user. The `user_id` foreign key is
     * automatically handled by Eloquent and should be assigned manually in
     * controllers, never mass-assigned for security reasons.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
