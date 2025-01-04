<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable; // Add this line

class Property extends Model
{
    use HasFactory, HasApiTokens, Notifiable; // Now it will work

    protected $fillable = [
        'title', 'description', 'type', 'status', 'labels', 
        'price', 'second_price', 'after_price_label', 'price_prefix', 
        'custom_fields', 'bedrooms', 'bathrooms', 'garages', 'garages_size', 
        'area_size', 'size_prefix', 'land_area', 'land_area_size_postfix', 
        'user_id', 'year_built', 'additional_details','property_name','address','features','energy_class',
        'global_energy_performance_index',
        'renewable_energy_performance_index',
    ];    
}

