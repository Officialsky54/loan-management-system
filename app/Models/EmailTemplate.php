<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body',
        'signature',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const APPLICATION_RECEIVED = 'application_received';
    const APPLICATION_VERIFIED = 'application_verified';
    const BANK_DETAILS_REQUEST = 'bank_details_request';
    const BANK_DETAILS_RECEIVED = 'bank_details_received';
    const LOAN_APPROVED = 'loan_approved';
    const LOAN_REJECTED = 'loan_rejected';
}
