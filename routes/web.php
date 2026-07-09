<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Installer\InstallerController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\BankDetailController;
use App\Http\Controllers\Admin\EmailTemplateController;

// Installer routes
Route::middleware('web')->group(function () {
    Route::get('/install', [InstallerController::class, 'index'])->name('installer.index');
    Route::post('/install', [InstallerController::class, 'store'])->name('installer.store');
});

// Web routes
Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/loan-calculator', [HomeController::class, 'loanCalculator'])->name('loan-calculator');
    Route::get('/apply-loan', [HomeController::class, 'applyLoan'])->name('apply-loan');
    Route::post('/apply-loan', [ApplicationController::class, 'store'])->name('apply-loan.store');
    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
    Route::get('/track', [HomeController::class, 'track'])->name('track');
    Route::post('/track', [ApplicationController::class, 'trackApplication'])->name('track.search');
});

// Admin routes
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Applications
    Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
    Route::get('/applications/search', [AdminApplicationController::class, 'search'])->name('applications.search');
    Route::get('/applications/export/{format}', [AdminApplicationController::class, 'export'])->name('applications.export');
    
    // Manual Review
    Route::get('/manual-review', [AdminApplicationController::class, 'manualReview'])->name('manual-review');
    Route::post('/applications/{application}/approve', [AdminApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [AdminApplicationController::class, 'reject'])->name('applications.reject');
    
    // Bank Details
    Route::get('/bank-details', [BankDetailController::class, 'index'])->name('bank-details.index');
    Route::get('/bank-details/{bankDetail}', [BankDetailController::class, 'show'])->name('bank-details.show');
    Route::post('/bank-details/{bankDetail}/approve', [BankDetailController::class, 'approve'])->name('bank-details.approve');
    Route::post('/bank-details/{bankDetail}/reject', [BankDetailController::class, 'reject'])->name('bank-details.reject');
    
    // Email Templates
    Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
    Route::get('/email-templates/{template}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
    Route::post('/email-templates/{template}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
    Route::get('/email-templates/{template}/preview', [EmailTemplateController::class, 'preview'])->name('email-templates.preview');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        session()->invalidate();
        return redirect('/');
    })->name('logout');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (auth()->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
})->name('login.store');
