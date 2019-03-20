<?php

namespace Nddcoder\Common;

use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;
use Nddcoder\Common\Logging\FileAndDebugbarLog;
use Nddcoder\Common\Providers\CollectionServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-common.php'),
            ], 'config');
        }

        $this->app->bind(Logger::class, FileAndDebugbarLog::class);
        $this->app->register(CollectionServiceProvider::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-common');
    }
}
