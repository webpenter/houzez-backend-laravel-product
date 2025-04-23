<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarButton extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'path', 'text_color', 'bg_color', 'hover_color', 'is_visible',
    ];
}
