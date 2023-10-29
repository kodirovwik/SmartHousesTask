<?php

namespace App\Console;

use App\Jobs\JobHelpers\JobHelpersInterface;
use App\Jobs\JobHelpers\MarketingNewsletterHelpers\MessageInterface;
use App\Jobs\JobHelpers\MarketingNewsletterHelpers\MessagesList;
use App\Jobs\MarketingNewsletterJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         foreach (MessagesList::list() as $className) {
             $messageClass = resolve($className);

             $schedule->job(new MarketingNewsletterJob($messageClass))
                 ->cron($messageClass->getScheduleTime());
         }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
