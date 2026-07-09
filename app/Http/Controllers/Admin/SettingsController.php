<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = $this->getAllSettings();
        return view('admin.settings.index', ['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'website_title' => 'required|string|max:255',
            'company_email' => 'required|email',
            'company_phone' => 'required|string',
            'company_address' => 'required|string',
            'minimum_loan_amount' => 'required|numeric|min:0',
            'maximum_loan_amount' => 'required|numeric|gt:minimum_loan_amount',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'loan_duration_options' => 'required|string',
            'currency' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:5',
            'website_language' => 'required|string',
            'ocr_enabled' => 'boolean',
            'ocr_provider' => 'nullable|string',
            'maintenance_mode' => 'boolean',
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|numeric',
            'smtp_username' => 'required|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'required|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        try {
            // Update basic settings
            $settingsToUpdate = [
                'company_name',
                'website_title',
                'company_email',
                'company_phone',
                'company_address',
                'minimum_loan_amount',
                'maximum_loan_amount',
                'interest_rate',
                'loan_duration_options',
                'currency',
                'currency_symbol',
                'website_language',
                'ocr_provider',
                'smtp_host',
                'smtp_port',
                'smtp_username',
                'smtp_encryption',
                'facebook_url',
                'twitter_url',
                'linkedin_url',
                'instagram_url',
            ];

            foreach ($settingsToUpdate as $key) {
                if ($request->has($key)) {
                    WebsiteSetting::setValue($key, $request->input($key));
                }
            }

            // Handle boolean settings
            WebsiteSetting::setValue('ocr_enabled', $request->has('ocr_enabled') ? 'true' : 'false');
            WebsiteSetting::setValue('maintenance_mode', $request->has('maintenance_mode') ? 'true' : 'false');

            // Handle SMTP password
            if ($request->filled('smtp_password')) {
                WebsiteSetting::setValue('smtp_password', $request->smtp_password);
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('assets', 'public');
                WebsiteSetting::setValue('logo', $path);
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                $path = $request->file('favicon')->store('assets', 'public');
                WebsiteSetting::setValue('favicon', $path);
            }

            return redirect()->back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function getAllSettings()
    {
        return WebsiteSetting::all()->pluck('value', 'key')->toArray();
    }
}
