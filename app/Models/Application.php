<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

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
        'loan_amount' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'ocr_results' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }
}
