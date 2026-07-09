<?php

use Illuminate\Foundation\Application;

return Application::configure(base_path())
    ->withProviders([
        'Illuminate\\Auth\\AuthServiceProvider',
        'Illuminate\\Broadcasting\\BroadcastServiceProvider',
        'Illuminate\\Bus\\BusServiceProvider',
        'Illuminate\\Cache\\CacheServiceProvider',
        'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
        'Illuminate\\Cookie\\CookieServiceProvider',
        'Illuminate\\Database\\DatabaseServiceProvider',
        'Illuminate\\Encryption\\EncryptionServiceProvider',
        'Illuminate\\Filesystem\\FilesystemServiceProvider',
        'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
        'Illuminate\\Hashing\\HashingServiceProvider',
        'Illuminate\\Mail\\MailServiceProvider',
        'Illuminate\\Notifications\\NotificationServiceProvider',
        'Illuminate\\Pagination\\PaginationServiceProvider',
        'Illuminate\\Pipeline\\PipelineServiceProvider',
        'Illuminate\\Queue\\QueueServiceProvider',
        'Illuminate\\Redis\\RedisServiceProvider',
        'Illuminate\\Session\\SessionServiceProvider',
        'Illuminate\\Translation\\TranslationServiceProvider',
        'Illuminate\\Validation\\ValidationServiceProvider',
        'Illuminate\\View\\ViewServiceProvider',
    ])
    ->withMiddleware(function ($middleware) {
        // Configure middleware
    })
    ->withExceptions(function ($exceptions) {
        // Configure exception handling
    })
    ->create();
