<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Application extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'reference_id',
        'user_id',
        'full_name',
        'date_of_birth',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'employment_status',
        'monthly_income',
        'employer_name',
        'loan_amount',
        'loan_duration',
        'loan_purpose',
        'identity_status',
        'loan_status',
        'current_step',
        'ocr_results',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'ocr_results' => 'json',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_VERIFIED = 'verified';
    const STATUS_PROCESSING = 'processing';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';

    const IDENTITY_UNVERIFIED = 'unverified';
    const IDENTITY_VERIFIED = 'verified';
    const IDENTITY_UNDER_REVIEW = 'under_review';

    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function bankDetails(): HasOne
    {
        return $this->hasOne(BankDetail::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
