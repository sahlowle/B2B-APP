<?php

namespace Modules\Subscription\Console\Commands;

use Illuminate\Console\Command;
use Modules\Subscription\Entities\PackageSubscription;
use Modules\Subscription\Jobs\{
    SubscriptionEmailNotification,
    SubscriptionRemoveProduct
};

class Subscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscriptions = PackageSubscription::with('metadata')->select('id', 'user_id', 'activation_date', 'next_billing_date', 'payment_status', 'status')->get();

        foreach ($subscriptions as $subscription) {
            dispatch(new SubscriptionRemoveProduct($subscription));
            dispatch(new SubscriptionEmailNotification($subscription));
        }
    }
}
