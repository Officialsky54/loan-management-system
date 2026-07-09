<?php

namespace App\Helpers;

use App\Models\WebsiteSetting;

function setting($key, $default = null)
{
    return WebsiteSetting::getValue($key, $default);
}

function calculateLoan($amount, $duration, $rate = null)
{
    $rate = $rate ?? setting('interest_rate', 5.5);
    
    $monthlyRate = ($rate / 100) / 12;
    
    if ($monthlyRate == 0) {
        $monthly = $amount / $duration;
    } else {
        $monthly = ($amount * $monthlyRate * pow(1 + $monthlyRate, $duration)) / 
                  (pow(1 + $monthlyRate, $duration) - 1);
    }
    
    $totalPaid = $monthly * $duration;
    $totalInterest = $totalPaid - $amount;
    
    return [
        'monthly' => round($monthly, 2),
        'total_interest' => round($totalInterest, 2),
        'total_repayment' => round($totalPaid, 2),
    ];
}

function formatCurrency($amount)
{
    return setting('currency_symbol') . number_format($amount, 2);
}

function getApplicationStatus($status)
{
    $statuses = [
        'pending' => 'Pending',
        'verified' => 'Verified',
        'processing' => 'Processing',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'completed' => 'Completed',
    ];
    
    return $statuses[$status] ?? ucfirst($status);
}

function getApplicationStep($step)
{
    $steps = [
        'application_received' => 'Application Received',
        'identity_verified' => 'Identity Verified',
        'loan_processing' => 'Loan Processing',
        'awaiting_bank_details' => 'Awaiting Bank Details',
        'bank_details_review' => 'Bank Details Review',
        'loan_approved' => 'Loan Approved',
        'loan_rejected' => 'Loan Rejected',
        'completed' => 'Completed',
    ];
    
    return $steps[$step] ?? ucfirst(str_replace('_', ' ', $step));
}
