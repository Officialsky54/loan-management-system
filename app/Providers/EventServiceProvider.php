<?php

namespace App\Providers;

use App\Events\ApplicationSubmitted;
use App\Listeners\SendApplicationReceivedEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ApplicationSubmitted::class => [
            SendApplicationReceivedEmail::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
