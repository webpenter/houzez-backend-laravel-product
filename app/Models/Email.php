<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'template_id', 'to_email','cc_email','bcc_email','subject','content',
        'status','sent_at','fail_reason','created_by'
    ];

    protected $casts = [
        'to_email' => 'array',
        'cc_email' => 'array',
        'bcc_email' => 'array',
        'sent_at' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }

    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class);
    }

    public function logs()
    {
        return $this->hasMany(EmailLog::class);
    }
}
