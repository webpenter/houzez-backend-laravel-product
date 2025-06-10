<?php

namespace App\Models;

use App\Enums\DealGroup;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'user_id',
        'group',
        'title',
        'contact_name',
        'agent',
        'deal_value',
        'status',
    ];

    protected $casts = [
        'group' => DealGroup::class,
    ];
}
