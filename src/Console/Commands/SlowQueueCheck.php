<?php

namespace BrandonJBegle\LaravelQueueMonitoring\Console\Commands;

use BrandonJBegle\LaravelQueueMonitoring\Events\SlowQueueEvent;
use BrandonJBegle\LaravelQueueMonitoring\Jobs\SlowQueryCheckJob;
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
    protected $description = 'Monitoring queue timing.';

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

            $seconds = $this->argument('seconds');
            $greaterThanPeriod = now()->diffInSeconds($time) > $seconds;
            $notGreaterThanTwoPeriods = now()->diffInSeconds($time) < ($seconds * 2);

            if($greaterThanPeriod && $notGreaterThanTwoPeriods){
                $this->info('Dispatching Event');
                event(new SlowQueueEvent($this->argument('seconds')));
            }
        }else{
            Cache::put('laravel-queue-monitoring:slow-queue-check', now()->timestamp);
            dispatch(new SlowQueryCheckJob());
        }

        return Command::SUCCESS;
    }
}
