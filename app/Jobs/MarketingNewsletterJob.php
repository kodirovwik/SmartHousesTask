<?php

namespace App\Jobs;

use App\Jobs\JobHelpers\MarketingNewsletterHelpers\MessageInterface;
use App\Mail\DefaultMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MarketingNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private MessageInterface $helper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MessageInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->helper->getUsers();

        /** @var User $user */
        foreach ($users as $user) {
            $message = $this->helper->getMessage($user);

            try {
                Mail::to($user)->send(new DefaultMail($message));
            } catch (\Throwable $e) {
                Log::error($e);
            }
        }
    }
}
