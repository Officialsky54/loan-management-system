<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BankDetail extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'application_id',
        'bank_name',
        'account_holder',
        'account_number',
        'iban',
        'swift_bic',
        'status',
        'approved_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
