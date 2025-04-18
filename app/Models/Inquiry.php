<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'inquiry_type',
        'information_type',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'location',
        'city',
        'area',
        'state',
        'country',
        'zip_code',
        'property_type',
        'max_price',
        'min_size',
        'beds',
        'baths',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
