<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LoanCalculationService;
use App\Services\EmailService;
use App\Services\OCRService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoanCalculationService::class, function () {
            return new LoanCalculationService();
        });

        $this->app->singleton(EmailService::class, function () {
            return new EmailService($this->app->make(LoanCalculationService::class));
        });

        $this->app->singleton(OCRService::class, function () {
            return new OCRService();
        });
    }

    public function boot(): void
    {
        //
    }
}
