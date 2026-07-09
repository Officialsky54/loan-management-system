<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'template_id',
        'recipient',
        'subject',
        'body',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_SENT = 'sent';
    const STATUS_FAILED = 'failed';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class);
    }
}
