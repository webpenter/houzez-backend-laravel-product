<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyAttachment extends Model
{
    protected $fillable = [
        'property_id',
        'file_title',
        'file_path',
    ];

    public function property(): BelongsTo {
        return $this->belongsTo(Property::class);
    }
}
