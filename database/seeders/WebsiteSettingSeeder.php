<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'company_name' => 'Loan Management System',
            'website_title' => 'Quick Loan Services',
            'company_email' => 'info@example.com',
            'company_phone' => '+1 (555) 123-4567',
            'company_address' => '123 Business St, City, State 12345',
            'minimum_loan_amount' => '1000',
            'maximum_loan_amount' => '100000',
            'interest_rate' => '5.5',
            'loan_duration_options' => '6,12,24,36,48,60',
            'currency' => 'USD',
            'currency_symbol' => '$',
            'website_language' => 'en',
            'ocr_enabled' => 'false',
            'ocr_provider' => 'tesseract',
            'maintenance_mode' => 'false',
            'facebook_url' => 'https://facebook.com',
            'twitter_url' => 'https://twitter.com',
            'linkedin_url' => 'https://linkedin.com',
            'instagram_url' => 'https://instagram.com',
            'homepage_title' => 'Get Your Loan Today',
            'homepage_subtitle' => 'Fast, Easy, and Secure Loan Applications',
            'smtp_host' => 'smtp.mailtrap.io',
            'smtp_port' => '2525',
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_encryption' => 'tls',
        ];

        foreach ($settings as $key => $value) {
            WebsiteSetting::setValue($key, $value);
        }
    }
}
