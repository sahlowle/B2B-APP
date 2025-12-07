<?php

/**
 * @package PackageSubscriptionService
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 18-02-2023
 */

 namespace Modules\Subscription\Services;

use App\Models\Currency;
use Illuminate\Http\Request;
use Modules\Gateway\Facades\GatewayHelper;

use Modules\Subscription\Traits\SubscriptionTrait;

use App\Models\{
    Order,
    OrderDetail,
    Preference,
    Product,
    User,
    VendorUser
};
use Modules\Subscription\Entities\{
    Package, PackageMeta, PackageSubscription, PackageSubscriptionMeta, SubscriptionDetails
};

use Illuminate\Support\Facades\{
    Auth, DB
};
use Modules\Gateway\Contracts\RecurringCancelInterface;
use Modules\Gateway\Facades\GatewayHandler;
use Modules\Inventory\Entities\Location;
use Modules\Pos\Entities\Terminal;
use Modules\Subscription\Console\Commands\Subscription;
 
 class PackageSubscriptionService
 {
    use SubscriptionTrait;

    /**
     * service name
     * @var string
     */
    public string|null $service;

    /**
     * Subscription
     *
     * @var object
     */
    private $subscription;

    /**
     * Initialize
     *
     * @return void
     */
    public function __construct($service = null)
    {
        $this->service = $service;

        if (is_null($service)) {
            $this->service = __('Plan Subscription');
        }
    }

    /**
     * Store package from frontend
     *
     * @param int $packageId
     * @param int $userId
     * @param string $billing_cycle
     * @return array
     */
    public function storePackage($packageId, $userId, $billing_cycle)
    {
        $package = Package::find($packageId);
        $days = ['weekly' => 7, 'monthly' => 30, 'yearly' => 365, 'days' => $package->duration, 'lifetime' => 0];
        $billed = $package->discount_price[$billing_cycle] > 0 ? $package->discount_price[$billing_cycle] : $package->sale_price[$billing_cycle];

        $next_billing = $days[$billing_cycle];
        if ($package->trial_day && !$this->isUsedTrial($package->id)) {
            $next_billing = $package->trial_day;
            $billed = 0;
        }

        $data = [
            "package_id" => $package->id,
            "user_id" => $userId,
            "billing_price" => $billed,
            "billing_cycle" => $billing_cycle,
            "meta" => [
                [
                    "duration" => $package->duration,
                    'trial' => $this->isUsedTrial($package->id) ? 0 : $package->trial_day
                ],
            ],
            "activation_date" => date('Y-m-d'),
            "billing_date" => date('Y-m-d'),
            "next_billing_date" => date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $next_billing . ' days')),
            "amount_billed" => $billed,
            "amount_received" => "0",
            "amount_due" => $billed,
            "is_customized" => "0",
            "renewable" => $package->renewable ?? 0,
            "payment_status" => "Unpaid",
            "status" => "Pending"
        ];

        return $this->store($data);
    }

    public function storeNewPackage($packageId, $userId, $billing_cycle)
    {
        $package = Package::find($packageId);
        $days = ['weekly' => 7, 'monthly' => 30, 'yearly' => 365, 'days' => $package->duration, 'lifetime' => 0];
        $billed = $package->discount_price[$billing_cycle] > 0 ? $package->discount_price[$billing_cycle] : $package->sale_price[$billing_cycle];
        
        $next_billing = $days[$billing_cycle];
        if ($package->trial_day && !$this->isUsedTrial($package->id)) {
            $next_billing = $package->trial_day;
            $billed = 0;
        }

        $data = [
            "package_id" => $package->id,
            "user_id" => $userId,
            "billing_price" => $billed,
            "billing_cycle" => $billing_cycle,
            "meta" => [
                [
                    "duration" => $package->duration,
                    'trial' => $this->isUsedTrial($package->id) ? 0 : $package->trial_day
                ],
            ],
            "activation_date" => date('Y-m-d'),
            "billing_date" => date('Y-m-d'),
            "next_billing_date" => date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $next_billing . ' days')),
            "amount_billed" => $billed,
            "amount_received" => "0",
            "amount_due" => $billed,
            "is_customized" => "0",
            "renewable" => $package->renewable ?? 0,
            "payment_status" => "Unpaid",
            "status" => "Pending"
        ];

        return $this->storeNew($data);
        
    }

    public function storeNew(array $data): array
    {
        $data['code'] =  strtoupper(\Str::random(10));
        $userId = $data['user_id'];
        // unset($data['user_id']);

        if ($renew = $this->isRenew($data, $userId)) {
            if ($renew === 'nonrenewable') {
                return [
                    'status' => 'fail',
                    'message' => __('The package is not renewable.')
                ];
            }
            return $this->saveSuccessResponse() + ['subscription' => $this->subscription];
        }

        $subscription = PackageSubscription::create($data);

        if ($subscription) {
                $subscription = $subscription->fresh();
                $this->storeMeta($subscription->id, $subscription->package_id, $data['meta']);

                $this->updateProductCount($subscription->id, $userId);

                $this->updateLocationCount($subscription->id, $userId);

                $this->updateStaffCount($subscription->id, $userId);

                return $this->saveSuccessResponse() + ['subscription' => $subscription];
        }

        


        return $this->saveFailResponse();
    }

    /**
     * Store Package Subscription
     *
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {  
        $data = $this->validateData($data);
        $userId = $data['user_id'];
        unset($data['user_id']);

        if ($renew = $this->isRenew($data, $userId)) {
            if ($renew === 'nonrenewable') {
                return [
                    'status' => 'fail',
                    'message' => __('The package is not renewable.')
                ];
            }
            return $this->saveSuccessResponse() + ['subscription' => $this->subscription];
        }

        if ($subscription = PackageSubscription::updateOrCreate([
                'user_id' => $userId
            ], $data)) {
                $this->storeMeta($subscription->id, $subscription->package_id, $data['meta']);

                $this->updateProductCount($subscription->id, $userId);

                $this->updateLocationCount($subscription->id, $userId);

                $this->updateStaffCount($subscription->id, $userId);

                return $this->saveSuccessResponse() + ['subscription' => $subscription];
        }

        


        return $this->saveFailResponse();
    }

    /**
     * Update product count
     *
     * @param int $subscriptionId
     * @param int $userId
     * @return void
     */
    public function updateProductCount($subscriptionId, $userId)
    {

        PackageSubscriptionMeta::where([
            'package_subscription_id' => $subscriptionId,
            'type' => 'feature_product',
            'key' => 'usage'
        ])->update(['value' => Product::where('vendor_id', VendorUser::where('user_id', $userId)->first()->vendor_id)
            ->where('slug', '!=', null)
            ->count()]);  

    }


    /**
     * Update Location count
     *
     * @param int $subscriptionId
     * @param int $userId
     * @return void
     */
    public function updateLocationCount($subscriptionId, $userId)
    {
        PackageSubscriptionMeta::where([
            'package_subscription_id' => $subscriptionId,
            'type' => 'feature_inventory_location',
            'key' => 'usage'
        ])->update(['value' => Location::where('vendor_id', VendorUser::where('user_id', $userId)->first()->vendor_id)
            ->where('slug', '!=', null)
            ->count()]);
    }


    /**
     * Update Terminal count
     *
     * @param int $subscriptionId
     * @param int $userId
     * @return void
     */
    public function updateTerminalCount($subscriptionId, $userId)
    {
        PackageSubscriptionMeta::where([
            'package_subscription_id' => $subscriptionId,
            'type' => 'feature_terminal',
            'key' => 'usage'
        ])->update(['value' => Terminal::where('vendor_id', VendorUser::where('user_id', $userId)->first()->vendor_id)
            ->count()]);
    }

    


    /**
     * Update Staff count
     *
     * @param int $subscriptionId
     * @param int $userId
     * @return void
     */
    public function updateStaffCount($subscriptionId, $userId)
    {
        PackageSubscriptionMeta::where([
            'package_subscription_id' => $subscriptionId,
            'type' => 'feature_staff',
            'key' => 'usage'
        ])->update([
            'value' => VendorUser::where('vendor_id', VendorUser::where('user_id', $userId)->first()->vendor_id)
            ->where('user_id', '!=', auth()->user()->id)
            ->count()
        ]);
    }


    /**
     * Update Order count
     *
     * @param int $subscriptionId
     * @param int $userId
     * @return void
     */
    public function updateOrderCount($subscriptionId, $userId)
    {
        
       $count = OrderDetail::where('vendor_id', $userId)->select('order_id')->distinct()->where('created_at', '>=', PackageSubscription::where('id', $subscriptionId)->latest('created_at')->first()->created_at)->count(); 

        PackageSubscriptionMeta::where([
            'package_subscription_id' => $subscriptionId,
            'type' => 'feature_invoice',
            'key' => 'usage'
        ])->update(['value' => $count]);

    }

    /**
     * Cancel Subscription
     */
    public function cancel(int $userId): array
    {        
        try {
            $subscription = $this->getUserSubscription($userId);
            $history = $subscription->activeDetail();
            
            $gateway = preg_replace('/([a-z])([A-Z])/', '$1_$2', $history?->payment_method);
            
            $gateway = strtolower($gateway);
    
            $subscriptionId = $subscription->{$gateway . '_subscription_id'};
            $customerId = User::find($userId)->{$gateway . '_customer_id'};

            $response['status'] = 'failed';
            if (str_contains($gateway, 'recurring')) {
                $response = $this->cancelRecurring(strtolower($history?->payment_method), $subscriptionId, $customerId);
            }

            if (!str_contains($gateway, 'recurring') || $response['status'] == 'success') {
                $this->getUserSubscription($userId)?->update(['status' => 'Cancel', 'renewable' => 0]);

                User::find($userId)->subscriptionDescription()?->update(['status' => 'Cancel', 'renewable' => 0]);

                return [
                    'status' => 'success',
                    'message' => __('The :x has been successfully canceled.', ['x' => $this->service])
                ];
            }

            return [
                'status' => 'fail',
                'message' => __(':x cancel failed. Please try again.', ['x' => $this->service])
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'fail',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Is renew subscription
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    private function isRenew($data, $userId)
    {
        $subscription = PackageSubscription::where(['user_id' => $userId, 'package_id' => $data['package_id']])->first();

        if (!$subscription || boolval($subscription->trial)) {
            return false;
        }

        $package = Package::find($data['package_id']);

        if (!$data['renewable'] || !$package || $package->status <> 'Active') {
            return 'nonrenewable';
        }

        //Update subscription
        $diffDays = $this->diffInDays($data['billing_date'], $data['next_billing_date']);

        if ($this->isActive($subscription->id)) {
            $next_billing = \Carbon\Carbon::createFromFormat('Y-m-d', $subscription->next_billing_date)->addDays($diffDays);
        } else {
            $next_billing = now()->addDays($diffDays);
        }

        $subscription->update([
            'renewable' => $data['renewable'],
            'billing_cycle' => $data['billing_cycle'],
            'status' => $data['status'],
            'amount_received' => $data['amount_received'],
            'amount_due' => $data['amount_due'],
            'payment_status' => $data['payment_status'],
            'billing_price' => $data['billing_price'],
            'next_billing_date' => $next_billing
        ]);

        $subscription->refresh();

        $this->subscription = $subscription;

        return true;
    }

    /**
     * Find difference between two days
     *
     * @param string $start_date
     * @param string $end_date
     *
     * @return string
     */
    public function diffInDays($start_date, $end_date)
    {
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $start_date);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $end_date);

        return $to->diffInDays($from);
    }

    /**
     * Update Package Subscription
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(array $data, int $id): array
    {
        $subscription = PackageSubscription::find($id);

        if (is_null($subscription)) {
            return $this->notFoundResponse();
        }

        $data['billing_price'] = validateNumbers($data['billing_price']);
        $data['amount_billed'] = validateNumbers($data['amount_billed']);
        $data['amount_received'] = validateNumbers($data['amount_received']);
        $data['amount_due'] = validateNumbers($data['amount_due']);

        $data = $this->validateData($data);

        if ($subscription->update($data)) {
            $this->updateMeta($data['meta'], $id);

            return $this->saveSuccessResponse();
        }

        return $this->saveFailResponse();
    }

    /**
     * Delete Package Subscription
     *
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        $subscription = PackageSubscription::find($id);

        if (is_null($subscription)) {
            return $this->notFoundResponse();
        }

        if ($subscription->delete()) {
            $subscription->details()->where('status', 'active')->update(['status' => 'Expired']);
            return $this->deleteSuccessResponse();
        }

        return $this->deleteFailResponse();
    }

    /**
     * Validate Data
     *
     * @param array $data
     * @return array $data
     */
    private function validateData($data)
    {
        if (!$this->getUserSubscription($data['user_id'])) {
            $data['code'] =  strtoupper(\Str::random(10));
        }

        return $data;
    }

    /**
     * Store meta data
     *
     * @param array $data
     * @param int $package_id
     * @return void
     */
    private function storeMeta($subscription_id, $package_id, $optional): void
    {
        $package = Package::find($package_id);

        $optional[0]['trial'] = $this->isUsedTrial($package->id) ? 0 : $package->trial_day;

        $data = PackageService::editFeature($package, false);
        $mergeData = array_merge($data, $optional);

        $meta = [];
        foreach ($mergeData as $key => $metaData) {
            $feature = null;

            if (!is_int($key)) {
                $feature = 'feature_' . $key;
                $metaData['usage'] = 0;
            }

            foreach ($metaData as $k => $value) {
                $meta[] = [
                    'package_subscription_id' => $subscription_id,
                    'type' => $feature,
                    'key' => $k,
                    'value' => $value
                ];
            }
        }

        PackageSubscriptionMeta::upsert($meta, ['package_subscription_id', 'type', 'key']);
    }

    /**
     * Get Subscription Features
     *
     * @param PackageSubscription $subscription
     * @return \App\Lib\MiniCollection;
     */
    public static function getFeatures(PackageSubscription $subscription)
    {
        $meta = $subscription->metadata()->whereBeginsWith('type', 'feature_')->get();

        $formatData = [];

        foreach ($meta as $data) {
            $formatData[str_replace('feature_', '', $data->type)][$data->key] = $data->value;
        }

        return miniCollection($formatData, true);
    }

    /**
     * Update meta data
     *
     * @param array $data
     * @param int $subscription_id
     * @return void
     */
    private function updateMeta($data, $subscriptionId): void
    {
        $meta = [];
        foreach ($data as $key => $metaData) {
            foreach ($metaData as $k => $value) {
                $value = !is_array($value) ? $value : json_encode($value);

                $meta[] = [
                    'package_subscription_id' => $subscriptionId,
                    'type' => is_int($key) ? null : 'feature_' . $key,
                    'key' => $k,
                    'value' => $value == 0 || !empty($value) ? $value : PackageService::features()[$key][$k]
                ];
            }
        }

        PackageSubscriptionMeta::upsert($meta, ['package_subscription_id', 'type', 'key']);
    }

    /**
     * Check user id
     */
    private function checkUserId(int|null $userId): int|null
    {
        if (!is_null($userId)) {
            return $userId;
        }

        if (checkIfUserIsStaff()) {   
            return getStaffVendorUserId();
        }

        return optional(auth()->user())->id ?? optional(auth()->guard('api')->user())->id;
        
    }

    /**
     * Get subscription information
     */
    public function getSubscription(int $id, string $type = 'id', bool $newInstance = false): object|null
    {
        return PackageSubscription::getInstance($type, $id, $newInstance);
    }

    /**
     * Get user subscription information
     */
    public function getUserSubscription(int|null $userId = null, bool $newInstance = false): object|null
    {
        $userId = $this->checkUserId($userId);

        return $this->getSubscription($userId, 'user_id', $newInstance);
    }

    /**
     * Get user active subscription
     */
    public function getUserActiveSubscription(int|null $userId = null)
    {
        return $this->getUserSubscription($userId)->where('status', 'Active')->first();
    }

    /**
     * Get All primary feature
     */
    public function getFeatureList(): array
    {
        return array_keys(PackageService::features());
    }

    /**
     * Get subscription feature option
     */
    public function getFeatureOption(int $subscription_id, string $feature): array
    {
        return $this->featureSubscriptionMeta($subscription_id, $feature);
    }

    /**
     * All feature remaining limit
     */
    public function featuresLimitRemaining(int $subscriptionId): array
    {
        $data = [];

        foreach ($this->getFeatureList() as $value) {
            $feature = $this->getFeatureOption($subscriptionId, $value);

            if (!$feature) {
                continue;
            }

            if ($feature['value'] == -1) {
                $data[$value] = -1;

                continue;
            }

            $data[$value] = $feature['type'] == 'number' ? $feature['value'] - $feature['usage'] : $feature['value'];
        }

        return $data;
    }

    public function getActiveFeature(int $subscriptionId)
    {
      $limit =  $this->featuresLimitRemaining($subscriptionId);
      $usage =  $this->featuresUsage($subscriptionId);
      $data = [];
        foreach ($limit as $key => $value) {
            $usage[$key] = $usage[$key] ?? 0;
            $data[$key]['limit'] = $value;
            $data[$key]['used'] = $usage[$key];
            $data[$key]['remain'] = is_int($value) ? $value - $usage[$key] : 0;
            $data[$key]['percentage'] = $value == 0 ? 100 : (is_int($value) ? round((($value - $usage[$key]) * 100) / $value) : 0);
        }

        return $data;
    }

    /**
     * Specific feature remaining limit
     */
    public function featureLimitRemaining(int $subscriptionId, string $feature): int
    {
        $feature = $this->getFeatureOption($subscriptionId, $feature);

        if (!$feature) {
            return 0;
        }

        if ($feature['value'] == -1) {
            return -1;
        }

        return $feature['value'] - $feature['usage'];
    }

    /**
     * Specific feature check active status
     */
    public function isFeatureActive(int $subscriptionId, string $feature): bool
    {
        return count($this->getFeatureOption($subscriptionId, $feature));
    }

    /**
     * Is The feature limited
     */
    public function isFeatureUnlimited(int $subscriptionId, string $feature): bool
    {
        $feature = $this->getFeatureOption($subscriptionId, $feature);

        if (!$feature) {
            return false;
        }

        if ($feature['value'] == -1) {
            return true;
        }

        return false;
    }

    /**
     * All feature usage
     */
    public function featuresUsage(int $subscriptionId): array
    {
        $data = [];


        foreach ($this->getFeatureList() as $value) {
            $feature = $this->getFeatureOption($subscriptionId, $value);

            if (!$feature) {
                return $data;
            }

            $data[$value] = $feature['usage'];
        }

        return $data;
    }

    /**
     * Specific feature usage
     */
    public function featureUsage(int $subscriptionId, string $feature): int
    {
        $features = $this->featuresUsage($subscriptionId);

        if (!count($features) || !in_array($feature, $features)) {
            return 0;
        }

        return $features[$feature];
    }

    /**
     * Time left to expire
     */
    public function timeLeft(int|null $subscriptionId): string
    {
        $subscription = $this->getSubscription($subscriptionId);

        if ($this->isExpired($subscription->user_id)) {
            return '0 day';
        }

        return timeToGo($subscription->next_billing_date, false, '');
    }

    /**
     * Subscription meta object for usage
     */
    private function featureUsageMeta(int $subscriptionId, string $feature): object|null
    {
        return PackageSubscriptionMeta::where([
                'package_subscription_id' => $subscriptionId,
                'type' => 'feature_'. $feature,
                'key' => 'usage'
            ])->first();
    }

    /**
     * Usage value increment
     */
    public function usageIncrement(int $subscriptionId, string $feature, int $value): bool
    {
        $usage = $this->featureUsageMeta($subscriptionId, $feature);

        return $usage && $usage->increment('value', $value);
    }

    /**
     * Usage value decrement
     */
    public function usageDecrement(int $subscriptionId, string $feature, int $value): bool
    {
        $usage = $this->featureUsageMeta($subscriptionId, $feature);

        return $usage && $usage->decrement('value', $value);
    }

    /**
     * Get all subscription status
     */
    public function getStatuses(): array
    {
        return PackageService::getStatuses();
    }

    /**
     * Get specific subscription current status
     */
    public function getCurrentStatus(int $subscriptionId): null|string
    {
        return $this->getSubscription($subscriptionId)?->status;
    }

    /**
     * Get token to word
     */
    public function tokenToWord($token): float
    {
        return $token * 0.75;
    }

    /**
     * Get word to token
     */
    public function wordToToken($word): float
    {
        return $word / 0.75;
    }

    /**
     * Get trial day
     */
    public function isTrialMode(int $subscriptionId): bool
    {
        return (bool) $this->getSubscription($subscriptionId)->trial;
    }

    /**
     * Is user subscribed any package
     */
    public function isSubscribed(int|null $userId = null): bool
    {
        $userId = $this->checkUserId($userId);

        return !is_null($this->getUserSubscription($userId));
    }

    /**
     * Is Subscription started
     */
    public function isStarted(int|null $userId = null): bool
    {
        $subscription = $this->getUserSubscription($userId);

        return $subscription->activation_date <= now();
    }
    
    /**
     * Is Subscription expired
     */
    public function isExpired(int|null $userId = null): bool
    {
        $subscription = PackageSubscription::activePackage()->where('user_id', $vendorId ?? auth()->user()->id)->with('metadata')->first();

        if (!$subscription) {
            return true;
        }

        if ($subscription->billing_cycle == 'lifetime' && !$this->isTrialMode($subscription->id)) {
            return false;
        }

        return $subscription->next_billing_date < now() || $subscription->status == 'Expired';
    }

    /**
     * Is subscription active yet
     */
    public function isActive(int $subscriptionId): bool
    {
        $subscription = $this->getSubscription($subscriptionId);

        if ($subscription && $this->isPaid($subscriptionId)) {
            return in_array($subscription->status, ['Active', 'Cancel']);
        }

        return false;
    }

    /**
     * Subscription payment status
     */
    public function isPaid(int $subscriptionId): bool
    {
        $subscription = $this->getSubscription($subscriptionId);

        if ($subscription) {
            return $subscription->payment_status == 'Paid';
        }

        return false;
    }

    /**
     * The plan is renewable or not
     */
    public function isRenewable(int $subscriptionId): bool
    {
        $subscription = $this->getSubscription($subscriptionId);

        return boolval($subscription?->renewable);
    }

    /**
     * Check subscription validity
     */
    public function isValidSubscription(int|null $userId = null, string|null $feature = null): array
    {
       
        $status = 'fail';

        if (!$this->isSubscribed($userId)) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }

        $subscription = PackageSubscription::activePackage()->where('user_id', $vendorId ?? auth()->user()->id)->with('metadata')->first();

        $this->sellerProductCount($userId);

        if (!$this->isActive($subscription->id)) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }
        
        if (!$this->isStarted($userId)) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }

        if ($this->isExpired($userId)) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }

        if (!is_null($feature) && !$this->isFeatureActive($subscription->id, $feature)) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }

        if (!is_null($feature) && !$this->isFeatureUnlimited($subscription->id, $feature) && $this->featureLimitRemaining($subscription->id, $feature) <= 0) {
            return [
                'status' => $status,
                'message' => preference('subscription_restriction_message'),
                'url' => preference('subscription_restriction_url')
            ];
        }

        return [
            'status' => 'success',
            'message' => __('Subscription valid.'),
            'data' => $subscription
        ];
    }

    /**
     * generate & store pdf
     *
     * @param object $subscription
     * @param string $invoiceName
     * @return bool|void
     */
    public function invoicePdfEmail($subscription , $invoiceName = 'subscription-invoice.pdf')
    {
        if (empty($subscription)) {
            return false;
        }
        $data['subscription'] = $subscription;
        $data['logo'] = Preference::where('field', 'company_logo')->first()->fileUrl();

        return printPDF($data, '/public/uploads/invoices/' . $invoiceName, 'subscription::invoice_print', view('subscription::invoice_print', $data), null, "email");

    }

    /**
     * Prepare Subscription data
     *
     * @return void
     */
    public function prepareData(array|object $data, array|object $features, string|null $paymentMethod = null, $uniqCode = null): array
    {
        return [
            'package_subscription_id' => $data->id,
            'code' => $data->code,
            'unique_code' => $uniqCode ?? uniqid(rand(), true),
            'user_id' => $data->user_id,
            'package_id' => $data->package_id,
            'is_trial' => boolval($data->trial),
            'renewable' => $data['renewable'],
            'activation_date' => $data->activation_date,
            'billing_date' => $data->billing_date,
            'next_billing_date' => $data->next_billing_date,
            'billing_price' => $data->billing_price,
            'billing_cycle' => $data->billing_cycle,
            'amount_billed' => $data->billing_price,
            'amount_received' => $data->amount_received,
            'currency' => Currency::getDefault()?->name,
            'payment_status' => $data->payment_status,
            'status' => $data->status,
            'features' => json_encode($features),
            'payment_method' => $paymentMethod
        ];
    }

    /**
     * Store subscription details
     *
     * @return object
     */
    public function storeSubscriptionDetails(int|null $userId = null, string|null $paymentMethod = null, $uniqCode = null, $packageSubscription = null)
    {
        if(is_null($packageSubscription)) {
            $packageSubscription = $this->getUserSubscription($userId, true);
        }

        $features = $this->getFeatureList();

        $data = $this->prepareData($packageSubscription, $features, $paymentMethod, $uniqCode);

        // SubscriptionDetails::where('user_id', $userId)->where('status', 'Active')->update(['status' => 'Expired']);

        return SubscriptionDetails::create($data);
    }

    /**
     * Update subscription details
     *
     * @param integer|null $userId
     * @return bool
     */
    public function updateSubscriptionDetails(int|null $userId = null) : bool
    {
        $packageSubscription = $this->getUserSubscription($userId, true);

        $features = $this->getFeatureList();

        $data = $this->prepareData($packageSubscription, $features, null);

        if ($data['status'] == 'Active') {
            SubscriptionDetails::where('user_id', $userId)->where('status', 'Active')->update(['status' => 'Expired']);
        }

        return SubscriptionDetails::where('user_id', $userId)->orderBy('id', 'desc')->first()->update($data);
    }

    /**
     * Get plan description data
     *
     * @return String $id
     */
    public function planDescription(string $id)
    {
        $data['package'] = Package::with('metadata')->find($id);
        $data['features'] = $this->getFeatures($data['package']);
        return $data;
    }


    /**
     * get Feature
     *
     * @param Package $package
     * @param bool $option
     * @return \App\Lib\MiniCollection
     */
    public static function getPackageFeatures(Package $package, $option = true)
    {
        $features = $package->metaData()->whereNot('feature', '')->get();
        $formatFeature = [];

        foreach ($features as $data) {
            $formatFeature[$data->feature][$data->key] = $data->value;
        }

        if (!$option) {
            return $formatFeature;
        }

        return miniCollection($formatFeature, true);
    }

    /**
     * Updated subscription data
     *
     * @param Request $request
     * @return $packageSubscription
     */
    public function subscriptionPaid(Request $request)
    {
        $code = techDecrypt($request->code);
        
        $packageSubscriptionDetail = SubscriptionDetails::where('id', $code)->first();

        if (!$packageSubscriptionDetail) {
            throw new \Exception(__('Payment data not found.'));
        }

        $packageSubscription = PackageSubscription::where('code', $packageSubscriptionDetail->code)->first();
        
        $log = GatewayHelper::getPaymentLog($code);

        if (!$log) {

            throw new \Exception(__('Subscription not found.'));
        }

        if (!Auth::id()) {
            Auth::onceUsingId($packageSubscriptionDetail->user_id);
        }

        if ($log->status == 'completed') {

            PackageSubscription::where('user_id', $packageSubscriptionDetail->user_id)
                // ->where('status', 'Active')
                ->where('id', '!=', $packageSubscription->id)
                ->forceDelete();

            SubscriptionDetails::where('user_id', $packageSubscriptionDetail->user_id)->where('status', 'Active')->update(['status' => 'Expired']);

            $data = json_decode($log->response);
            $packageSubscriptionDetail->amount_received = $data->amount;
            $packageSubscriptionDetail->payment_status = "Paid";
            $packageSubscriptionDetail->status = 'Active';

            $packageSubscription->payment_status = "Paid";
            $packageSubscription->status = 'Active';
        }

        $packageSubscriptionDetail->payment_method = $log->gateway;

        $packageSubscription->save();
        $packageSubscriptionDetail->save();

        $link = cache()->get('private-plan-' . auth()->user()->id, 'default');

        PackageMeta::where('value', $link)->delete();

        return $packageSubscriptionDetail;
    }

    /**
     * Get activePackage
     *
     * @return Object $response
     */
    public function activePackage()
    {

        if (Auth::check() && PackageSubscription::where('user_id', Auth::user()->id)->count() > 0) {
            $activePlan = PackageSubscription::where('user_id', Auth::user()->id)->latest()->first();
            return Package::find($activePlan->package_id);
        }

        return Package::with('metadata')->first();
    }

    /**
     * Seller Product Count
     *
     * @param int|null $userId
     * @return void
     */
    public function sellerProductCount($userId = null)
    {
        $subscription = $this->getUserSubscription($userId);

        if ($subscription) {
            $this->updateProductCount($subscription->id, $subscription->user_id);
        }
    }


    /**
     * Seller Location Count
     *
     * @param int|null $userId
     * @return void
     */
    public function sellerLocationCount($userId = null)
    {
        $subscription = $this->getUserSubscription($userId);

        if ($subscription) {
            $this->updateLocationCount($subscription->id, $subscription->user_id);
        }
    }

     /**
     * Seller Location Count
     *
     * @param int|null $userId
     * @return void
     */
    public function sellerTerminalCount($userId = null)
    {
        $subscription = $this->getUserSubscription($userId);

        if ($subscription) {
            $this->updateTerminalCount($subscription->id, $subscription->user_id);
        }
    }


    /**
     * Seller Staff Count
     *
     * @param int|null $userId
     * @return void
     */
    public function sellerStaffCount($userId = null)
    {
        $subscription = $this->getUserSubscription($userId);

        if ($subscription) {
            $this->updateStaffCount($subscription->id, $subscription->user_id);
        }
    }

    /**
     * Seller Order Count
     *
     * @param int|null $userId
     * @return void
     */
    public function sellerOrderCount($userId = null)
    {
        $subscription = $this->getUserSubscription($userId);

        if ($subscription) {
            $this->updateOrderCount($subscription->id, $subscription->user_id);
        }
    }

    /**
     * Activate subscription and details
     *
     * @param int $subscriptionDetailId
     * @return void
     */
    public function activatedSubscription($subscriptionDetailsId)
    {
        $details = SubscriptionDetails::find($subscriptionDetailsId);

        $subscription = PackageSubscription::find($details->package_subscription_id);

        $details->update(['payment_status' => 'Paid', 'status' => 'Active']);
        $subscription->update(['payment_status' => 'Paid', 'status' => 'Active']);

        SubscriptionDetails::where('user_id', $details->user_id)
            ->where('status', 'Active')
            ->where('id', '!=', $details->id)
            ->update(['status' => 'Expired']);

            PackageSubscription::where('user_id', $details->user_id)
            ->where('id', '!=', $subscription->id)
            ->forceDelete();
    }

    /**
     * Is used trial period
     *
     * @param int $packageId
     * @param int|null $userId
     * @return bool
     */
    public function isUsedTrial($packageId, $userId = null): bool
    {
        if (is_null($userId)) {
            $userId = auth()->user()->id;
        }

        return SubscriptionDetails::where(['package_id' => $packageId, 'user_id' => $userId])
            ->where('is_trial', '!=', '0')->count();
    }

    /**
     * Manually paid by admin
     *
     * @param SubscriptionDetails $history
     *
     * @return array
     */
    public function manualPaid($history)
    {
        $package = Package::find($history->package_id);

        if (!$package) {
            return $this->notFoundResponse();
        }

        DB::beginTransaction();
        try {
            $history->update([
                'amount_received' => $history->amount_billed,
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            PackageSubscription::where('user_id', $history->user_id)->update([
                "amount_received" => $history->amount_billed,
                "amount_due" => "0",
                'payment_status' => 'Paid',
                'status' => 'Active'
            ]);

            DB::commit();

            return [
                'status' => 'success',
                'message' => __('The payment has been successfully paid.')
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => 'fail',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Comma Separate Number Validation
     *
     * @param string|null $text
     * @param int $default
     * @return string
     */
    public function commaSeparateNumberValidation(string|null $text, int $default = 7)
    {
        if (empty($text)) {
            return $default;
        }

        $cleanedString = preg_replace("/[^0-9, ]/", "", $text);
        $string = preg_replace('/,+/', ',', trim($cleanedString, ','));
        $array = explode(',', $string);
        $uniqueArray = array_unique($array);
        sort($uniqueArray);

        return implode(',', $uniqueArray);
    }

    /** Recurring renew
     *
     * @param object|array $request
     * @return boolean
     */
    public function updateStripeRecurring($request)
    {
        if ($request->type != 'invoice.payment_succeeded') {
            return false;
        }

        $packageSubscriptionMeta = PackageSubscriptionMeta::where(['key' => 'stripe_recurring_subscription_id', 'value' => $request->data['object']['subscription']])->first();
        $packageSubscription = PackageSubscription::find($packageSubscriptionMeta?->package_subscription_id);

        if (empty($packageSubscriptionMeta) || empty($packageSubscription)) {
            return false;
        }

        $receiveAmount = $request->data['object']['amount_paid'] / 100;
        $data = $this->prepareRenewData($packageSubscription, $receiveAmount);

        if ($this->renew($data, $packageSubscription->user_id)) {

            if ($this->isRecurringSubscriptionDetailUpdate($packageSubscription->code, $receiveAmount, 'StripeRecurring')) {

                return true;
            } else {

                return (bool) $this->storeSubscriptionDetails($packageSubscription->user_id, 'StripeRecurring');
            }
        }

        return false;
    }

    /**
     * Renew subscription
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    private function renew($data, $userId)
    {
        $subscription = PackageSubscription::where(['user_id' => $userId, 'package_id' => $data['package_id']])->first();

        if (!$subscription) {
            return false;
        }

        //Update subscription
        $diffDays = differInDays($data['billing_date'], $data['next_billing_date']);

        if ($this->isActive($subscription->id)) {
            $next_billing = \Carbon\Carbon::createFromFormat('Y-m-d', $subscription->next_billing_date)->addDays($diffDays);
        } else {
            $next_billing = now()->addDays($diffDays);
        }

        $subscription->update([
            'renewable' => $data['renewable'],
            'status' => $data['status'],
            'payment_status' => $data['payment_status'],
            'billing_price' => $data['billing_price'],
            'amount_received' => $data['amount_received'],
            'billing_date' => $data['billing_date'],
            'next_billing_date' => $next_billing
        ]);

        if ($subscription->status == 'Active') {
            // Update subscription meta
            foreach ($this->getFeatureList() as $value) {
                $feature = PackageMeta::where(['package_id' => $data['package_id'], 'feature' => $value,])->get();

                if ($feature->where('key', 'is_value_fixed')->first()->value) {
                    continue;
                }

                $limit = $feature->where('key', 'value')->first()->value;

                if ($limit == -1) {
                    PackageSubscriptionMeta::where([
                        'package_subscription_id' => $subscription->id,
                        'type' => 'feature_' . $value,
                        'key' => 'value'
                    ])
                        ->update('value', $limit);
                    continue;
                }

                PackageSubscriptionMeta::where([
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_' . $value,
                    'key' => 'value'
                ])
                    ->increment('value', $limit);
            }
        }

        return true;
    }

    /**
     * Prepare renew data
     *
     * @param array|object $subscription
     * @param integer|float|string $receiveAmount
     * @return array
     */
    public function prepareRenewData(array|object $subscription, int|float|string $receiveAmount): array
    {
        $days = ['weekly' => 7, 'monthly' => 30, 'yearly' => 365, 'days' => $subscription->duration];
        return [
            "package_id" => $subscription->package_id,
            "user_id" => $subscription->user_id,
            "billing_price" => $receiveAmount,
            "billing_date" => date('Y-m-d'),
            "next_billing_date" => $this->calculateNextBillingDate($days[$subscription->billing_cycle]),
            "amount_billed" => $receiveAmount,
            "amount_received" => $receiveAmount,
            "amount_due" => "0",
            "is_customized" => "0",
            "renewable" => $subscription->renewable,
            "payment_status" => "Paid",
            "status" => "Active"
        ];
    }

    /**
     * Update subscription details data
     *
     * @param string|integer $subscriptionId
     * @param integer|float|string $amount_received
     * @param null|string $paymentMethod
     * @return boolean
     */
    public function isRecurringSubscriptionDetailUpdate(string|int $subscriptionId, int|float|string $amount_received, string|null $paymentMethod = null): bool
    {
        $subscriptionDetails = SubscriptionDetails::where(['payment_status' => 'Unpaid', 'billing_date' => date('Y-m-d'), 'code' => $subscriptionId])->latest()->first();

        if ($subscriptionDetails) {
            $subscriptionDetails->payment_status = "Paid";
            $subscriptionDetails->status = "Active";
            $subscriptionDetails->amount_received = $amount_received;
            $subscriptionDetails->payment_method = $paymentMethod;
            $subscriptionDetails->save();

            return true;
        }

        return false;
    }

    public function calculateNextBillingDate($days)
    {
        return date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $days . ' days'));
    }

    /**
     * Paypal recurring renew
     *
     * @param object|array $request
     * @return boolean
     */
    public function updatePaypalRecurring($request)
    {

        if ($request->event_type != 'PAYMENT.SALE.COMPLETED') {
            return false;
        }
        $packageSubscriptionMeta = PackageSubscriptionMeta::where(['key' => 'paypal_recurring_subscription_id', 'value' => $request->resource['billing_agreement_id']])->first();
        $packageSubscription = PackageSubscription::find($packageSubscriptionMeta?->package_subscription_id);

        if (empty($packageSubscriptionMeta) || empty($packageSubscription)) {
            return false;
        }

        $receiveAmount = $request->resource['amount']['total'];
        $data = $this->prepareRenewData($packageSubscription, $receiveAmount);

        if (!$this->renew($data, $packageSubscription->user_id)) {
            return false;
        }

        if ($this->isRecurringSubscriptionDetailUpdate($packageSubscription->code, $receiveAmount, 'PaypalRecurring')) {
            return true;
        } else {
            return (bool) $this->storeSubscriptionDetails($packageSubscription->user_id, 'PaypalRecurring');
        }
    }

    /**
     * Cancel recurring
     */
    public function cancelRecurring(string $gatewayName, string $subscriptionId, string $customId): mixed
    {
        try {
            $processor = GatewayHandler::getRecurringCancelProcessor($gatewayName);

            if (!$processor instanceof RecurringCancelInterface) {
                throw new \Exception(__('This gateway does not support recurring.'));
            }

            return $processor->execute($subscriptionId, $customId);
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'message' => $e->getMessage()
            ];
        }
    }
 }

