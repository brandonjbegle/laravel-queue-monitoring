<?php

namespace BrandonJBegle\LaravelQueueMonitoring\Console\Commands;

use BrandonJBegle\LaravelQueueMonitoring\Events\SlowQueueEvent;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SlowQueueCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue-monitoring:slow-queue {seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Poll queue for age of oldest job.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!$this->argument('seconds')){
            $this->error('The seconds argument is required.');
            return Command::FAILURE;
        }

        $timestamp = Cache::get('laravel-queue-monitoring:slow-queue-check');
        if($timestamp){
            $time = Carbon::createFromTimestamp($timestamp);

            if(now()->diffInSeconds($time) > $this->argument('seconds')){
                $this->info('Dispatching Event');
                event(new SlowQueueEvent($this->argument('seconds')));
            }
        }


        Cache::put('laravel-queue-monitoring:slow-queue-check', now()->timestamp);


        return Command::SUCCESS;
    }
}
