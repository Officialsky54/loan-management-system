<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/admin/dashboard';

    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
