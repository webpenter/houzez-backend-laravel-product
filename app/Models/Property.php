<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Property extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'package',
        'price',
        'time_period',
        'number_of_listings',
        'featured_listings',
        'number_of_images',
    ];

    /**
     * Create a new property listing for the authenticated user.
     *
     * @param array $data
     * @return Property
     */
    public static function createProperty(array $data)
    {
        return self::create([
            'user_id' => Auth::id(),
            'package' => $data['package'],
            'price' => $data['price'],
            'time_period' => $data['time_period'],
            'number_of_listings' => $data['number_of_listings'],
            'featured_listings' => $data['featured_listings'],
            'number_of_images' => $data['number_of_images'],
        ]);
    }

    /**
     * Relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
