<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Application Received',
                'slug' => 'application_received',
                'subject' => 'Your Loan Application Has Been Received - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Thank you for submitting your loan application.</p>
<p><strong>Application Reference ID:</strong> {reference_id}</p>
<p><strong>Loan Amount:</strong> {currency}{loan_amount}</p>
<p><strong>Loan Duration:</strong> {loan_duration} months</p>
<p>We have received your application and it is currently being processed. You can track your application status using the link below:</p>
<p><a href="{tracking_link}">Track Your Application</a></p>
<p>We will notify you as soon as we have reviewed your application.</p>
<p>Thank you,<br>{company_name}</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
            [
                'name' => 'Application Verified',
                'slug' => 'application_verified',
                'subject' => 'Your Identity Has Been Verified - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Great news! Your identity has been verified successfully.</p>
<p><strong>Loan Amount:</strong> {currency}{loan_amount}</p>
<p><strong>Interest Rate:</strong> {interest_rate}% per annum</p>
<p><strong>Monthly Payment:</strong> {currency}{monthly_payment}</p>
<p><strong>Total Interest:</strong> {currency}{total_interest}</p>
<p><strong>Total Repayment:</strong> {currency}{total_repayment}</p>
<p>Your application is now being processed. Please submit your bank details to proceed.</p>
<p><a href="{bank_link}">Submit Bank Details</a></p>
<p>Thank you,<br>{company_name}</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Details Request',
                'slug' => 'bank_details_request',
                'subject' => 'Please Submit Your Bank Details - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Your loan application has been approved and we need your bank details to process the transfer.</p>
<p><strong>Application Reference ID:</strong> {reference_id}</p>
<p>Please provide the following information:</p>
<ul>
<li>Bank Name</li>
<li>Account Holder Name</li>
<li>Account Number</li>
<li>IBAN (if available)</li>
<li>SWIFT/BIC Code (if available)</li>
</ul>
<p><a href="{bank_link}">Submit Bank Details Now</a></p>
<p>Thank you,<br>{company_name}</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
            [
                'name' => 'Bank Details Received',
                'slug' => 'bank_details_received',
                'subject' => 'Bank Details Received - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Thank you for submitting your bank details.</p>
<p><strong>Application Reference ID:</strong> {reference_id}</p>
<p>Your bank details have been received and are currently being reviewed by our team. We will notify you shortly.</p>
<p>You can track your application status here:</p>
<p><a href="{tracking_link}">Track Your Application</a></p>
<p>Thank you,<br>{company_name}</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
            [
                'name' => 'Loan Approved',
                'slug' => 'loan_approved',
                'subject' => 'Your Loan Has Been Approved! - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Congratulations! Your loan application has been approved.</p>
<p><strong>Application Reference ID:</strong> {reference_id}</p>
<p><strong>Loan Amount:</strong> {currency}{loan_amount}</p>
<p><strong>Loan Duration:</strong> {loan_duration} months</p>
<p><strong>Monthly Payment:</strong> {currency}{monthly_payment}</p>
<p>The funds will be transferred to your account within 2-3 business days.</p>
<p>Thank you for choosing {company_name}.</p>
<p>Best regards,<br>{company_name} Team</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
            [
                'name' => 'Loan Rejected',
                'slug' => 'loan_rejected',
                'subject' => 'Your Loan Application - {reference_id}',
                'body' => '<p>Dear {customer_name},</p>
<p>Thank you for your interest in our loan services.</p>
<p><strong>Application Reference ID:</strong> {reference_id}</p>
<p>Unfortunately, your loan application has not been approved at this time. This decision was made based on our review criteria.</p>
<p>If you would like to discuss this further or have any questions, please contact us.</p>
<p>Thank you,<br>{company_name}</p>',
                'signature' => 'Best regards,\n{company_name} Team',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::firstOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
