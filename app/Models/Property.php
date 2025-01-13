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
        'attachment','private_note','name','package','title', 'description', 'type','virtual_tour','status', 'labels','country','county_state','image','price_postfix','size','video_url','city','neighborhood','postal_code','latitude','longitude','map_street_view','price', 'second_price', 'price_label','after_price_label','price_prefix', 
        'custom_fields', 'bedrooms', 'bathrooms', 'garages', 'garages_size', 
        'area_size', 'size_prefix', 'land_area', 'land_area_size_postfix', 
        'user_id', 'year_built', 'additional_details','property_name','address','features','energy_class',
        'global_energy_performance_index',
        'renewable_energy_performance_index',
    ];    
}

