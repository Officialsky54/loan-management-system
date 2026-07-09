<?php

namespace App\Services;

use App\Models\Application;
use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Jobs\SendEmailJob;

class EmailService
{
    private LoanCalculationService $calculationService;

    public function __construct(LoanCalculationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    public function sendApplicationReceivedEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'application_received')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        dispatch(new SendEmailJob($emailLog));
    }

    public function sendApplicationVerifiedEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'application_verified')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        // Delay email by 5 minutes
        dispatch(new SendEmailJob($emailLog))->delay(now()->addMinutes(5));
    }

    public function sendBankDetailsRequestEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'bank_details_request')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        dispatch(new SendEmailJob($emailLog));
    }

    public function sendBankDetailsReceivedEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'bank_details_received')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        dispatch(new SendEmailJob($emailLog));
    }

    public function sendLoanApprovedEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'loan_approved')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        dispatch(new SendEmailJob($emailLog));
    }

    public function sendLoanRejectedEmail(Application $application)
    {
        $template = EmailTemplate::where('slug', 'loan_rejected')->first();
        
        if (!$template || !$template->is_active) {
            return;
        }

        $body = $this->replacePlaceholders($template->body, $application);

        $emailLog = EmailLog::create([
            'application_id' => $application->id,
            'template_id' => $template->id,
            'recipient' => $application->email,
            'subject' => $template->subject,
            'body' => $body,
            'status' => 'pending',
        ]);

        dispatch(new SendEmailJob($emailLog));
    }

    private function replacePlaceholders($body, Application $application)
    {
        $loanDetails = $this->calculationService->getLoanDetails(
            $application->loan_amount,
            $application->loan_duration
        );

        $placeholders = [
            '{customer_name}' => $application->full_name,
            '{reference_id}' => $application->reference_id,
            '{loan_amount}' => $application->loan_amount,
            '{loan_duration}' => $application->loan_duration,
            '{interest_rate}' => $loanDetails['interest_rate'],
            '{monthly_payment}' => $loanDetails['monthly_payment'],
            '{total_interest}' => $loanDetails['total_interest'],
            '{total_repayment}' => $loanDetails['total_repayment'],
            '{currency}' => setting('currency_symbol'),
            '{currency_code}' => setting('currency'),
            '{tracking_link}' => route('track'),
            '{bank_link}' => route('bank-details.show', $application->reference_id),
            '{company_name}' => setting('company_name'),
            '{company_email}' => setting('company_email'),
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $body);
    }
}
