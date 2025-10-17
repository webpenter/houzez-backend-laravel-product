<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['email_id','recipient','event','provider_response','meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
