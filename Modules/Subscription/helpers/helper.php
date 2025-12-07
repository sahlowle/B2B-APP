<?php

use App\Models\Vendor;
use App\Models\VendorUser;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\MenuBuilder\Http\Models\MenuItems;
use Modules\MenuBuilder\Http\Models\Menus;
use Modules\Subscription\Entities\PackageSubscription;
use Modules\Subscription\Services\PackageSubscriptionService;

if (!function_exists('subscription')) {
    /**
     * Subscription
     *
     * @param string $methodName
     * @param array $args
     * @return mixed
     */
    function subscription($methodName, ...$args)
    {
        $subscription = new PackageSubscriptionService();
        
        return $subscription->$methodName(...$args);
    }
}

if (!function_exists('hasActiveSubscription')) {
    function hasActiveSubscription($userId, $feature = null): bool
    {
        // Get active subscription
        $subscription = PackageSubscription::activePackage()
            ->where('user_id', $userId)
            ->with('metadata')
            ->first();
        
        // No subscription → false
        if (!$subscription) {
            return false;
        }

        // Feature is null → subscription exists → true
        if (is_null($feature)) {
            return true;
        }

        // Fetch ALL metadata rows for this feature
        $meta = $subscription->metadata()
            ->where('type', 'feature_' . $feature)
            ->pluck('value', 'key')
            ->toArray();

        // Feature not found → false
        if (!$meta) {
            return false;
        }

        // Get type
        $type = $meta['type'] ?? null;

        /**
         * -------------------------------------
         * 1. BOOLEAN FEATURE (type = bool)
         * -------------------------------------
         */
        if ($type === 'bool') {
            return true;
        }

        /**
         * -------------------------------------
         * 2. UNLIMITED FEATURE
         * -------------------------------------
         */
        if ($type === 'number' && isset($meta['value']) && $meta['value'] == -1) {
            return true;
        }

        /**
         * -------------------------------------
         * 3. COUNTABLE FEATURE
         * -------------------------------------
         */
        if ($type === 'number') {
            $value = (int) ($meta['value'] ?? 0);
            $usage = (int) ($meta['usage'] ?? 0);
            return ($value - $usage) > 0;
        }

        /**
         * -------------------------------------
         * 4. OTHER TYPES (multi-select, etc.)
         * → Consider enabled
         * -------------------------------------
         */
        return false;
    }
}


if (!function_exists('subscriptionAlertDates')) {
    /**
     * Remaining Alert Dates
     *
     * @param Model $subscription
     * @param string $type
     * @param bool $format
     */
    function subscriptionAlertDates($subscription, $type = 'remaining', $format = false): array
    {
        $calculate = ' + ';
        $days = 'subscription_expire_days';

        if ($type == 'remaining') {
            $calculate = ' - ';
            $days = 'subscription_remaining_days';
        }

        $dates = [];
        foreach (explode(',', preference($days, '7')) as $value) {
            $date = date('Y-m-d', strtotime($subscription->next_billing_date . $calculate . $value . ' days'));

            if ($format) {
                $date = formatDate($date);
            }

            $dates[] = $date;
        }

        return $dates;
    }
}

if (!function_exists('differInDays')) {
    /**
     * Undocumented function
     *
     * @param string $startDateTime
     * @param string $endDateTime
     * @return mixed
     */
    function differInDays(string $startDateTime, string $endDateTime): mixed
    {
        $startDateTime =  str_replace(['/', '.', '-'], "-", $startDateTime);
        $endDateTime =  str_replace(['/', '.', '-'], "-", $endDateTime);
        $start = new DateTime($startDateTime);
        $end = new DateTime($endDateTime);

        $diff = $start->diff($end);

        return $diff->days;
    }
}

if (!function_exists('hasAccessToProductType')) {

    /**
     * Has access to product type
     *
     * @param string $type
     * @return mixed
     */
    function hasAccessToProductType($type): bool
    {
        if (auth()->user()->role()->type != 'vendor') {
            return true;
        }
        $subscription = subscription('getUserSubscription');

        if (is_null($subscription)) {
            return false;
        }

        $feature = subscription('featureSubscriptionMeta', $subscription->id, 'product_variation');

        if (empty($feature)) {
            return false;
        }
        
        $data = array_filter(json_decode($feature['value'], true), function ($value) use ($type) {
            return strpos($value, $type) !== false;
        });
        
        return !empty($data);
    }
}

if (! function_exists('getStaffVendorUserId')) {
    /**
     * Get staff vendor user ID.
     *
     * Works for both web and API guards.
     *
     * @return int|null
     */
    function getStaffVendorUserId()
    {
        $user = auth()->user() ?? auth()->guard('api')->user();

        if ($user && $user->vendor()?->vendor_id) {

            return \App\Models\VendorUser::where('vendor_id', auth()->user()->vendor()->vendor_id)
                ->orderByDesc('id')
                ->value('user_id');
        }

        return null;
    }
}

if (!function_exists('checkAccess')) {

    /**
     * Check Access
     *
     * @param object|null $parent
     * @param string $feature
     * @return mixed
     */
    function checkAccess($feature, $method = null, $message = null)
    {
        $userId = null;
        if (function_exists('getStaffVendorUserId')) {
            $userId = checkIfUserIsStaff() ? getStaffVendorUserId() : null;
        }


        $userId = $userId ?? optional(auth()->user())->id ?? optional(auth()->guard('api')->user())->id;

        $subscription = subscription('isValidSubscription',  $userId, $feature);
        $message = $message ?? $subscription['message'];
        if ($subscription['status'] == 'fail') {
            \Artisan::call('optimize:clear');
            session()->flash('fail', $message);
            
            if ($url = preference('subscription_restriction_url')) {
                return \Redirect::to($url)->send();
            }
            
            throw new HttpResponseException(
                redirect()->route('vendor.subscription.index')
            );
        }
        
        return $method;
    }
}

add_action('after_batch_delete', function() {
    if (request()->namespace == '\App\Models\Product') {
        subscription('sellerProductCount');
    }
    
    if (request()->namespace == '\App\Models\User') {
        foreach (request()->records as $key => $id) {
            if (subscription('isSubscribed', $id)) {
                subscription('cancel', $id);
            }
        }
    }
    
    if (request()->namespace == '\App\Models\Vendor') {
        foreach (request()->records as $key => $id) {
            $userId = VendorUser::where('vendor_id', $id)->first()?->user_id;
            if (subscription('isSubscribed', $userId)) {
                subscription('cancel', $userId);
            }
        }
    }
});

add_action('after_vendor_create_product', function() {
    subscription('sellerProductCount');
});

add_action('after_vendor_duplicate_product', function() {
    subscription('sellerProductCount');
});

add_action('after_vendor_delete_product', function() {
    subscription('sellerProductCount');
});

add_action('after_vendor_create_location', function() {
    subscription('sellerLocationCount');
});

add_action('after_vendor_delete_location', function() {
    subscription('sellerLocationCount');
});

add_action('after_vendor_create_staff', function() {
    subscription('sellerStaffCount');
});

add_action('after_vendor_delete_staff', function() {
    subscription('sellerStaffCount');
});

add_action('after_vendor_create_order', function() {
    subscription('sellerOrderCount');
});

add_action('after_vendor_terminal_create', function() {
    subscription('sellerTerminalCount');
});


foreach (['index', 'create', 'edit', ] as $value) {
    add_filter('Modules\Coupon\Http\Controllers\Vendor\CouponController@' . $value, function($method) {
        return checkAccess('coupon', $method, __('Coupon access is unavailable. Please activate a plan that includes coupon access.'));
    });
    
    add_filter('Modules\Report\Http\Controllers\Vendor\ReportController@'  . $value, function($method) {
        return checkAccess('report', $method, __('Report access is unavailable. Please activate a plan that includes report access.'));
    });
    
    add_filter('Modules\Ticket\Http\Controllers\Vendor\TicketController@'  . $value, function($method) {
        return checkAccess('ticket', $method, __('Ticket access is unavailable. Please activate a plan that includes ticket access.'));
    });
}

add_action('before_vendor_create_product', function() {
    return checkAccess('product', null, __('Product limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_action('before_vendor_duplicate_product', function() {
    return checkAccess('product', null, __('Product limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_action('before_vendor_create_location', function() {
    return checkAccess('inventory_location', null, __('Inventory location limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_action('before_vendor_create_staff', function() {
    return checkAccess('staff', null, __('Staff limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_action('before_vendor_create_order', function() {
    return checkAccess('invoice', null, __('Invoice limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_action('before_vendor_terminal_create', function() {
    return checkAccess('terminal', null, __('Terminal limit reached or no active subscription. Please subscribe or upgrade your plan.'));
});

add_filter('App\Http\Controllers\Vendor\ImportController@productImport', function($method) {
    return checkAccess('import_product', $method, __('Product import access is unavailable. Please activate a plan that includes product import access.'));
});

add_filter('App\Http\Controllers\Vendor\ExportController@productExport', function($method) {
    return checkAccess('export_product', $method, __('Product export access is unavailable. Please activate a plan that includes product export access.'));
});

$subscriptionRestriction = [
    'before_admin_create_subscription',
    'before_admin_edit_subscription',
    'before_admin_create_plan',
    'before_admin_edit_plan'
];

foreach ($subscriptionRestriction as $value) {
    add_action($value, function() {
        if (_d_f_e()) {
            return \Redirect::to(route('package.subscription.index'))->send();
        }
    });
}

add_filter('product_editor_type_selector', function($data) {
    $filterData['product'] = $data['product'];
    $filterData['options'] = [];
    foreach ($data['options'] as $key => $value) {
        if (hasAccessToProductType($key)) {
            $filterData['options'][$key] = $value;
        }
    }
    
    return $filterData;
});

add_action('after_user_update', function($data) {
    if ($data->status !== 'Active' && subscription('isSubscribed', $data->id)) {
        subscription('cancel', $data->id);
    }
});


add_action('after_user_delete', function($data) {
    if (subscription('isSubscribed', $data->id)) {
        subscription('cancel', $data->id);
    }
});

add_action('after_vendor_update', function($data) {
    $userId = VendorUser::where('vendor_id', request()->id)->first()?->user_id;
    
    if (request()->status !== 'Active' && subscription('isSubscribed', $userId)) {
        subscription('cancel', $userId);
    }
});

add_action('after_vendor_delete', function($data) {
    $userId = VendorUser::where('vendor_id', $data->id)->first()?->user_id;
    
    if (subscription('isSubscribed', $userId)) {
        subscription('cancel', $userId);
    }
});

add_action("after_subscription_addon_deactivation", function() {
    Menus::whereIn('slug', ['plans', 'members', 'payments', 'subscription-setting'])->delete();
    
    MenuItems::where('label', 'Subscriptions')->delete();
    MenuItems::whereIn('link', ['packages', 'package/subscriptions', 'payments', 'subscriptions/settings', 'subscription'])->delete();
});

add_filter('notification_files', function($data) {
    return array_merge($data, glob(base_path('Modules/Subscription/Notifications/') . '*.php'));
});
