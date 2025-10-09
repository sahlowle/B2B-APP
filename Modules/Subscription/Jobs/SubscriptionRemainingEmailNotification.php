<?php
namespace Modules\Subscription\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Subscription\Services\Mail\SubscriptionRemainingMailService;

class SubscriptionRemainingEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * Subscription
     *
     * @var Model
     */
    protected $subscription;

    /**
     * Create a new job instance.
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;

    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new SubscriptionRemainingMailService)->send($this->subscription->id);
    }
}
