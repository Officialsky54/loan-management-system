<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use App\Models\Application;
use App\Models\WebsiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('web.home', ['settings' => $settings]);
    }

    public function about()
    {
        $settings = $this->getSettings();
        return view('web.about', ['settings' => $settings]);
    }

    public function services()
    {
        $settings = $this->getSettings();
        return view('web.services', ['settings' => $settings]);
    }

    public function loanCalculator()
    {
        $settings = $this->getSettings();
        $interestRate = WebsiteSetting::getValue('interest_rate', 5.5);
        return view('web.loan-calculator', ['settings' => $settings, 'interestRate' => $interestRate]);
    }

    public function applyLoan()
    {
        $settings = $this->getSettings();
        $minAmount = WebsiteSetting::getValue('minimum_loan_amount', 1000);
        $maxAmount = WebsiteSetting::getValue('maximum_loan_amount', 100000);
        $durations = explode(',', WebsiteSetting::getValue('loan_duration_options', '6,12,24,36,48,60'));
        
        return view('web.apply-loan', [
            'settings' => $settings,
            'minAmount' => $minAmount,
            'maxAmount' => $maxAmount,
            'durations' => $durations
        ]);
    }

    public function faq()
    {
        $settings = $this->getSettings();
        return view('web.faq', ['settings' => $settings]);
    }

    public function contact()
    {
        $settings = $this->getSettings();
        return view('web.contact', ['settings' => $settings]);
    }

    public function privacy()
    {
        $settings = $this->getSettings();
        return view('web.privacy', ['settings' => $settings]);
    }

    public function terms()
    {
        $settings = $this->getSettings();
        return view('web.terms', ['settings' => $settings]);
    }

    public function track()
    {
        $settings = $this->getSettings();
        return view('web.track', ['settings' => $settings]);
    }

    public function getSettings()
    {
        return [
            'company_name' => WebsiteSetting::getValue('company_name'),
            'website_title' => WebsiteSetting::getValue('website_title'),
            'website_language' => WebsiteSetting::getValue('website_language', 'en'),
            'currency' => WebsiteSetting::getValue('currency', 'USD'),
            'currency_symbol' => WebsiteSetting::getValue('currency_symbol', '$'),
        ];
    }
}
