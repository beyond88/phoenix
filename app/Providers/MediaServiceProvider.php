<?php

namespace App\Providers;

use App\Services\MediaUploader;
use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MediaUploader::class, function ($app) {
            return new MediaUploader(config('filesystems.default'));
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