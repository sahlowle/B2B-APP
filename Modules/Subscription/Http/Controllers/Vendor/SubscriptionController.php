<?php

namespace Modules\Subscription\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\{
    Preference,
    Product,
    VendorUser
};
use Illuminate\Http\Request;
use Modules\Subscription\Entities\{
    Package,
    PackageMeta,
    PackageSubscription,
    SubscriptionDetails
};
use Modules\Subscription\Services\{
    PackageService, PackageSubscriptionService
};

use Illuminate\Support\Facades\{
    DB, Auth, Session
};
use Modules\Gateway\Redirect\GatewayRedirect;
use Modules\Subscription\DataTables\VendorSubscriptionHistoryDataTable;
use Modules\Subscription\Notifications\SubscriptionInvoiceNotification;

class SubscriptionController extends Controller
{
    /**
     * Package Subscription Service
     *
     * @var object
     */
    protected $subscriptionService;

    /**
     * Constructor for Subscription controller
     *
     * @param SubscriptionService $subscriptionService
     * @return void
     */
    public function __construct(PackageSubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PackageDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data['packages'] = Package::where(['status' => 'Active', 'is_private' => '0'])->orderBy('sort_order')->get();
        
        $data['billingCycles'] = $this->billingCycle($data['packages']);

        if (checkIfUserIsStaff()) {
            $vendorId = getStaffVendorUserId();
        }

        $data['subscription'] = PackageSubscription::where('user_id', $vendorId ?? auth()->user()->id)->with('metadata')->first();

        foreach ($data['packages'] as $package) {
            $data['features'][$package->id] = PackageService::editFeature($package);
        }

        if ($data['subscription']) {
            $data['meta'] = $data['subscription']->metadata()->where('type', 'feature_product')->get()->pluck('value', 'key');
            $data['subscriptionFeatures'] = subscription('getActiveFeature', $data['subscription']->id);

            $data['product'] = Product::where('vendor_id', VendorUser::firstWhere('user_id', $data['subscription']->user_id)->vendor_id)->count();
        }

        return view('subscription::vendor.index', $data);
    }

    /**
     * Store subscription data
     *
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request)
    {
        try {
            $paymentType = ['automate' => 'recurring', 'manual' => 'single', 'customer_choice' => null];
            $renewal = $request->billing_cycle == 'lifetime' ? 'manual' : preference('subscription_renewal');

            DB::beginTransaction();

            $response = $this->subscriptionService->storePackage($request->package_id, Auth::user()?->id, $request->billing_cycle);

            if ($response['status'] != 'success') {
                throw new \Exception(__('Subscription fail.'));
            }

            $subscriptionDetails = $this->subscriptionService->storeSubscriptionDetails();

            if ($subscriptionDetails->is_trial ||  $subscriptionDetails->billing_price == 0) {
                $this->subscriptionService->activatedSubscription($subscriptionDetails->id);
                DB::commit();

                return redirect()->route('vendor.subscription.index')->withSuccess($response['message']);
            }

            request()->query->add(['payer' => 'user', 'to' => techEncrypt('vendor.subscription.paid')]);

            $route = GatewayRedirect::paymentRoute($subscriptionDetails, $subscriptionDetails->amount_billed, $subscriptionDetails->currency, $subscriptionDetails->id, $request, null, $paymentType[$renewal]);

            DB::commit();
            return redirect($route);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vendor.subscription.index')->withErrors($e->getMessage());
        }
    }

    /**
     * Cancel Subscription
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel($user_id)
    {
        $response = $this->subscriptionService->cancel($user_id);
        $this->setSessionValue($response);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paid(Request $request)
    {
        if (!checkRequestIntegrity()) {
            return redirect(GatewayRedirect::failedRedirect('integrity'));
        }

        try {

            $this->subscriptionService->subscriptionPaid($request);

            $code = techDecrypt($request->code);
        
            $packageSubscriptionDetail = SubscriptionDetails::where('id', $code)->first();

            $packageSubscriptionDetail?->user?->notify(new SubscriptionInvoiceNotification($packageSubscriptionDetail));

            Session::flash('success', __('You have successfully paid for the subscription.'));
        } catch (\Exception $e) {
            Session::flash('error', $e->getMessage());
        }

        return redirect()->route('vendor.subscription.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param PackageDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function history(VendorSubscriptionHistoryDataTable $dataTable)
    {
        return $dataTable->render('subscription::vendor.history');
    }

    /**
     * Subscription invoice
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function invoice($id)
    {
        $data['subscription'] = SubscriptionDetails::find($id);

        if (!$data['subscription']) {
            return redirect()->route('vendor.subscription.index')->withErrors(__(':x not found', ['x' => __('Invoice')]));
        }

        return view('subscription::vendor.invoice', $data);
    }

    /**
     * Subscription invoice pdf
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function pdfInvoice($id)
    {
        $subscription = SubscriptionDetails::find($id);
        $data['subscriptionFeatures'] = subscription('getActiveFeature', $subscription->subscription->id);
        if (!empty($subscription)) {
            $data['subscription'] = $subscription;
            $data['logo'] = Preference::where('field', 'company_logo')->first()->fileUrl();
            
            return printPDF($data, $subscription?->package?->name . '-' . $subscription->code . '.pdf', 'subscription::vendor.invoice-pdf', view('subscription::vendor.invoice-pdf', $data), 'pdf');
        }
        return redirect()->route('vendor.subscription.history');
    }

    /**
     * Private Plan
     *
     * @param string $link
     * @return
     */
    public function privatePlan($link)
    {
        $data = json_decode(techDecrypt($link), true);

        $response['status'] = 'fail';
        if (!$this->isValidPrivatePlan($data, $link)) {
            return view('subscription::vendor.private-plan', $response);
        }

        $plan = Package::find($data['plan_id']);

        if (!$plan) {
            return view('subscription::vendor.private-plan', $response);
        }

        $features = PackageService::editFeature($plan);
        $plan['features'] = $features;
        $plan['duration'] = $plan->duration;
        $plan['discount_price'] = $plan->discount_price;
        $plan['sale_price'] = $plan->sale_price;
        $plan['billing_cycle'] = $plan->billing_cycle;

        cache()->put('private-plan-' . auth()->user()->id, $link, 60);

        return view('subscription::vendor.private-plan', [
            'status' => 'success',
            'package' => $plan,
            'subscription' => subscription('getUserSubscription', auth()->user()->id)
        ]);
    }

    /**
     * Is Valid Private Plan
     *
     * @param array $data
     * @param string $link
     * @return bool
     */
    private function isValidPrivatePlan($data, $link)
    {
        if (is_null($data) || !isset($data['plan_id'])) {
            return false;
        }

        if (isset($data['email']) && $data['email'] != auth()->user()->email) {
            return false;
        }

        if (!PackageMeta::where('value', $link)->first()) {
            return false;
        }

        return true;
    }
    
    /**
     * Available Billing Cycle 
     * 
     * @param collection $packages
     * @return array
     */
    private function billingCycle($packages)
    {
        $cycleList = [
            'lifetime' => __('Lifetime'),
            'yearly' => __('Yearly'),
            'monthly' => __('Monthly'),
            'weekly' => __('Weekly'),
            'days' => __('Days'),
        ];
        
        $cycles = [];
        
        foreach ($packages as $package) {
            foreach ($package['billing_cycle'] as $billingKey => $value) {
                if ($value == 1) {
                    $cycles[$billingKey] = $cycleList[$billingKey];
                }
            }
        }
        
        // Sort the $cycles array based on the order of $cycle array
        uksort($cycles, function ($a, $b) use ($cycleList) {
            return array_search($a, array_keys($cycleList)) - array_search($b, array_keys($cycleList));
        });
        
        return $cycles;
    }

}
