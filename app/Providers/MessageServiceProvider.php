<?php

namespace App\Providers;

use App\Services\MessageService;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService(config('filesystems.default'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
