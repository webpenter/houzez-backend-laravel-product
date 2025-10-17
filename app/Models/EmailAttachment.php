<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    public $timestamps = false;
    protected $fillable = ['email_id','filename','path','size','mime'];

    public function email()
    {
        return $this->belongsTo(Email::class);
    }
}
