<?php

namespace Modules\Subscription\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Subscription\Notifications\SubscriptionExpireNotification;
use Modules\Subscription\Notifications\SubscriptionRemainingNotification;

class SubscriptionEmailNotification implements ShouldQueue
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
        if ($this->subscription->status == 'Inactive' || $this->subscription->payment_status  == 'Unpaid') {
            return;
        }

        if (subscription('isExpired', $this->subscription->user_id) && in_array(date('Y-m-d'), subscriptionAlertDates($this->subscription, 'expire'))) {
            $this->subscription?->user->notify(
                new SubscriptionExpireNotification($this->subscription->id)
            );
        } else if (in_array(date('Y-m-d'), subscriptionAlertDates($this->subscription, 'remaining'))) {
            $this->subscription?->user->notify(
                new SubscriptionRemainingNotification($this->subscription->id)
            );
        }
    }
}
