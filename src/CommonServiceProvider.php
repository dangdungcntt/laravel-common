<?php

namespace Pushtimize\Common;

use Illuminate\Container\Container;
use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;
use Pushtimize\Common\Logging\FileAndDebugbarLog;
use Pushtimze\Common\Providers\CollectionServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => Container::getInstance()->make('common.php'),
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'common');
    }
}
