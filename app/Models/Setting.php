<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    // Accessor: if type is JSON, cast to array
    public function getValueAttribute($value)
    {
        return $this->type === 'json' ? json_decode($value, true) : $value;
    }

    // Mutator: if array is passed for json type
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value)
            ? json_encode($value)
            : $value;
    }
}
