<?php

namespace Modules\Subscription\Jobs;

use App\Models\Product;
use App\Models\VendorUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubscriptionRemoveProduct implements ShouldQueue
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
        $meta = $this->subscription->metadata()->where('type', 'feature_product')->get()->pluck('value', 'key');

        $vendorId = VendorUser::firstWhere('user_id', $this->subscription->user_id)?->vendor_id;
        
        if (is_null($vendorId)) {
            return;
        }
        
        //Remove Limit exceeded product
        if ($meta['value'] - $meta['usage'] < 0 && now()->diffInDays($this->subscription->billing_date) >= preference('subscription_remove_product_day', 7)) {
            $products = Product::where('vendor_id', $vendorId)->whereNull('parent_id')->orderByDesc('created_at')->take(abs($meta['value'] - $meta['usage']))->pluck('id')->toArray();
            Product::whereIn('id', $products)->delete();

            subscription('sellerProductCount', $this->subscription->user_id);
            return;
        }

        // Remove subscription cancelled or expired product
        if ((subscription('isExpired', $this->subscription->user_id) || $this->subscription->status == 'Cancel') && now()->diffInDays($this->subscription->next_billing_date) >= preference('subscription_remove_product_day', 7)) {
            Product::where('vendor_id', $vendorId)->delete();
            subscription('sellerProductCount', $this->subscription->user_id);
        }
    }
}
