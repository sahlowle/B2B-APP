<?php

namespace Modules\Subscription\Database\Seeders\versions\v2_0_0;

use App\Models\NotificationSetting;
use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use Illuminate\Database\Seeder;
use Modules\Subscription\Notifications\PrivatePlanNotification;
use Modules\Subscription\Notifications\SubscriptionExpireNotification;
use Modules\Subscription\Notifications\SubscriptionInvoiceNotification;
use Modules\Subscription\Notifications\SubscriptionRemainingNotification;

class NotificationSettingsTableSeeder extends Seeder
{
    private function update($notificationType)
    {
        foreach (['mail', 'database', SmsChannel::class, AdminDatabaseChannel::class] as $channel) {
            NotificationSetting::updateOrInsert(['notification_type' => $notificationType, 'channel' => $channel], ['is_active' => 1]);
        }
    }

    public function run()
    {
        $this->update(PrivatePlanNotification::class);
        $this->update(SubscriptionInvoiceNotification::class);
        $this->update(SubscriptionExpireNotification::class);
        $this->update(SubscriptionRemainingNotification::class);
    }
}
