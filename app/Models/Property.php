<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'type', 'status', 'label', 'price', 'second_price',
        'after_price', 'price_prefix','user_id',

        'bedrooms', 'bathrooms', 'garages', 'garages_size', 'area_size',
        'size_prefix', 'land_area', 'land_area_size_postfix', 'property_id', 'year_built',

        'property_feature',

        'energy_class', 'global_energy_performance_index', 'renewable_energy_performance_index',
        'energy_performance_of_the_building',

        'address', 'country', 'county_state', 'city', 'neighborhood', 'zip_postal_code',
        'map_street_view', 'latitude', 'longitude',

        'video_url',

        'virtual_tour',

        'contact_information',

        'private_note',

        'property_status', 'is_paid', 'is_featured',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'second_price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'property_feature' => 'array',
        'contact_information' => 'array',
        'is_paid' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Define the relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function subProperties()
    {
        return $this->hasMany(SubProperty::class, 'property_id');
    }

    public function floorPlans()
    {
        return $this->hasMany(FloorPlan::class, 'property_id');
    }
}
