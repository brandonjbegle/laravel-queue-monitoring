<?php

namespace BrandonJBegle\LaravelQueueMonitoring;

use BrandonJBegle\LaravelQueueMonitoring\Console\Commands\SlowQueueCheck;
use BrandonJBegle\LaravelQueueMonitoring\Events\SlowQueueEvent;
use BrandonJBegle\LaravelQueueMonitoring\Listeners\SendSlowQueueNotificationListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class LaravelQueueMonitoringServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/queue-monitoring.php', 'laravel-queue-monitoring');

    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__ . '/../config' => config_path(),
            ], 'laravel-queue-monitoring');
        }

        $this->commands([
            SlowQueueCheck::class
        ]);

        if(!config('laravel-queue-monitoring.disable-default-alerts')){
            Event::listen(
                SlowQueueEvent::class,
                [SendSlowQueueNotificationListener::class, 'handle']
            );
        }
    }
}
