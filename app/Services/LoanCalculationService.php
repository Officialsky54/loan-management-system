<?php

namespace App\Services;

use App\Models\Application;
use App\Models\EmailTemplate;
use App\Models\EmailLog;

class LoanCalculationService
{
    public function calculateMonthlyPayment($loanAmount, $annualRate, $months)
    {
        $monthlyRate = ($annualRate / 100) / 12;
        
        if ($monthlyRate == 0) {
            return $loanAmount / $months;
        }
        
        $monthlyPayment = ($loanAmount * $monthlyRate * pow(1 + $monthlyRate, $months)) / 
                         (pow(1 + $monthlyRate, $months) - 1);
        
        return round($monthlyPayment, 2);
    }

    public function calculateTotalInterest($loanAmount, $monthlyPayment, $months)
    {
        $totalPaid = $monthlyPayment * $months;
        return round($totalPaid - $loanAmount, 2);
    }

    public function calculateTotalRepayment($loanAmount, $monthlyPayment, $months)
    {
        return round($monthlyPayment * $months, 2);
    }

    public function getLoanDetails($loanAmount, $months, $annualRate = null)
    {
        $rate = $annualRate ?? setting('interest_rate', 5.5);
        
        $monthlyPayment = $this->calculateMonthlyPayment($loanAmount, $rate, $months);
        $totalInterest = $this->calculateTotalInterest($loanAmount, $monthlyPayment, $months);
        $totalRepayment = $this->calculateTotalRepayment($loanAmount, $monthlyPayment, $months);
        
        return [
            'loan_amount' => $loanAmount,
            'months' => $months,
            'interest_rate' => $rate,
            'monthly_payment' => $monthlyPayment,
            'total_interest' => $totalInterest,
            'total_repayment' => $totalRepayment,
        ];
    }
}
