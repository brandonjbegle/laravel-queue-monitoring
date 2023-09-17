<?php

namespace BrandonJBegle\LaravelQueueMonitoring\Listeners;

use BrandonJBegle\LaravelQueueMonitoring\Notifications\SlowQueueNotification;
use Illuminate\Support\Facades\Notification;

class SendSlowQueueNotificationListener
{
    public function __construct()
    {
    }

    public function handle($event): void
    {
        $users = config('laravel-queue-monitoring.alert-email-addresses');

        if($users && count($users) > 0){
            Notification::route('mail', $users)->notify(new SlowQueueNotification($event->seconds));
        }
    }
}
