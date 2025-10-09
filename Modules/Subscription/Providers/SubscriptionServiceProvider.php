<?php

namespace Modules\Subscription\Providers;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\Subscription\Entities\SubscriptionDetails;

class SubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            \Modules\Subscription\Console\Commands\Subscription::class,
        ]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('subscription:run')->everyMinute();
        });

        User::resolveRelationUsing('subscriptionDescription', function (User $user) {
            return $user->hasOne(SubscriptionDetails::class)->latest()->first();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}
