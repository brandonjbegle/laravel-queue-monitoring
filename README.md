# Laravel Queue Monitoring

## Caveats
This is currently a brand new package and only works for the default queue. There is no configuration for additional/other queues at this time.

## Installation

```composer require brandonjbegle/laravel-queue-monitoring```

### Optionally publish the config file

```shell
php artisan vendor:publish --provider="BrandonJBegle\LaravelQueueMonitoring\LaravelQueueMonitoringServiceProvider"
```

### env
If you plan on using the basic built in listener and notification, add the env value. Multiple emails should be comma separated

```dotenv
QUEUE_MONITORING_EMAILS=test@email.com,email2@email.com

```

### Scheduled Command
Add the command to your app\Console\Kernel.php

```php
$schedule->command('queue-monitoring:slow-queue {seconds}')->everySecond();
```

### Optional Configuration

Change disable-default-alerts to true if you would like to listen to the SlowQueueEvent with your own listener to send your own alerts and notifications.

```php
 'disable-default-alerts' => false/true
```
