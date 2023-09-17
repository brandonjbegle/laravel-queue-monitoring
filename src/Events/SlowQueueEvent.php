<?php

namespace BrandonJBegle\LaravelQueueMonitoring\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SlowQueueEvent
{
    use Dispatchable, SerializesModels;

    public $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }
}
