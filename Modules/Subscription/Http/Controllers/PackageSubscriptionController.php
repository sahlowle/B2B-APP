<?php

namespace Modules\Subscription\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Lib\Env;
use Illuminate\Http\Request;
use Modules\Subscription\DataTables\PackageSubscriptionDataTable;
use Modules\Subscription\Services\PackageSubscriptionService;
use Modules\Subscription\Entities\{
    Package,
    PackageSubscription,
    SubscriptionDetails
};
use Modules\Subscription\Http\Requests\{
    PackageSubscriptionStoreRequest,
    PackageSubscriptionUpdateRequest
};
use App\Models\{
    Preference,
    User
};
use Modules\Subscription\DataTables\PaymentDataTable;
use Modules\Subscription\Jobs\{
    SubscriptionExpireEmailNotification,
    SubscriptionRemainingEmailNotification
};
use Modules\Subscription\Notifications\SubscriptionInvoiceNotification;
use Modules\Subscription\Services\PackageService;

class PackageSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PackageSubscriptionDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function index(PackageSubscriptionDataTable $dataTable)
    {
        return $dataTable->render('subscription::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        do_action('before_admin_create_subscription');
        
        $data['packages'] = Package::active('status')->get();
        $data['users'] = User::has('vendors')->active('status')->get()->filter(function ($user) {
            return ! checkIfUserIsStaff($user->id);
        });

        return view('subscription::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PackageSubscriptionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PackageSubscriptionStoreRequest $request, PackageSubscriptionService $service)
    {
        $response = $service->store($request->all());
        $service->storeSubscriptionDetails($request->user_id);

        $detailsId = User::find($request->user_id)?->subscriptionDescription()?->id;

        if ($detailsId) {
            $this->invoiceEmail($detailsId);
        }

        $this->setSessionValue(['status' => $response['status'], 'message' => $response['message']]);

        if (isset($response['subscription'])) {
            return redirect()->route('package.subscription.edit', ['id' => $response['subscription']->id]);
        }

        return redirect()->route('package.subscription.index');
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
            return redirect()->route('package.subscription.payment')
                    ->withErrors(__('The :x does not exist.', ['x' => __('Subscription')]));
        }

        return view('subscription::invoice', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        do_action('before_admin_edit_subscription');
        
        $data['subscription'] = PackageSubscription::find($id);

        if (!$data['subscription']) {
            return redirect()->route('package.subscription.index')->withFail(__('The :x is not found.', ['x' => __('Plan Subscription')]));
        }

        $data['features'] = PackageSubscriptionService::getFeatures($data['subscription']);
        $data['defaultFeatures'] = PackageService::features();

        $data['packages'] = Package::active('status')->get();
        $data['users'] = User::has('vendors')->active('status')->get()->filter(function ($user) {
            return ! checkIfUserIsStaff($user->id);
        });

        return view('subscription::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PackageSubscriptionUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PackageSubscriptionUpdateRequest $request, PackageSubscriptionService $service, $id)
    {
        $response = (new PackageSubscriptionService)->update($request->all(), $id);

        if ($response['status'] == 'success') {
            $subscription = subscription('getSubscription', $id);

            $service->updateSubscriptionDetails($subscription->user_id);
            
            $detailsId = User::find($request->user_id)?->subscriptionDescription()?->id;

            if ($detailsId) {
                $this->invoiceEmail($detailsId);
            }
        }

        $this->setSessionValue($response);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $response = (new PackageSubscriptionService)->delete($id);
        $this->setSessionValue($response);

        return back();
    }

    /**
     * Package subscription setting.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setting(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('subscription::configuration');
        }

        $category = 'subscription';
        $i = 0;

        $request['subscription_remove_product_day'] = $request['subscription_remove_product_day'] ?? 7;
        $request['subscription_remaining_days'] = subscription('commaSeparateNumberValidation', $request['subscription_remaining_days']);
        $request['subscription_expire_days'] = subscription('commaSeparateNumberValidation', $request['subscription_expire_days']);

        foreach ($request->except('_token') as $key => $value) {
            $data[$i]['category'] = $category;
            $data[$i]['field']    = $key;
            $data[$i++]['value'] = $value ?? '';
        }

        foreach ($data as $key => $value) {
            (new Preference())->storeOrUpdate($value);
        }

        $connections = ['sync', 'database'];

        Env::set('QUEUE_CONNECTION', $connections[$request->email_automation == "1"]);

        return back()->withSuccess(__('The :x has been successfully saved.', ['x' => __('Subscription Settings')]));
    }

    /**
     * Display a listing of the resource.
     *
     * @param PaymentDataTable $dataTable
     * @return \Illuminate\Contracts\View\View
     */
    public function payment(PaymentDataTable $dataTable)
    {
        return $dataTable->render('subscription::payment');
    }

    /**
     * Send notification to subscriber.
     *
     * @param Request $request
     * @return json
     */
    public function notification(Request $request)
    {
        $subscription = subscription('getSubscription', $request->id);

        if (!$subscription) {
            return redirect()->back()->withFails(__(':x does not exist.', ['x' => __('Member')]));
        }

        if ($request->mail_type == 'Remaining') {
            \dispatch(new SubscriptionRemainingEmailNotification($subscription));
        } else {
            \dispatch(new SubscriptionExpireEmailNotification($subscription));
        }

        return redirect()->back()->withSuccess(__('Notification send successfully'));
    }

    /**
     * Subscription Email invoice
     *
     * @param int $id
     * @return array
     */
    public function invoiceEmail($id)
    {
        $subscription = SubscriptionDetails::find($id);
        if (empty($subscription)) {
            return redirect()->route('package.subscription.index');
        }
        
        $subscription->user()->first()->notify(new SubscriptionInvoiceNotification($subscription));

        return [
            'status' => true,
            'message' => __('Subscription invoice sent successfully.')
        ];
    }

    /**
     * Subscription invoice pdf
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|void
     */
    public function invoicePdf($id)
    {
        $subscription = SubscriptionDetails::find($id);

        if (!empty($subscription)) {
            $packageName = $subscription?->package?->name;

            $data['subscription'] = $subscription;
            $data['logo'] = \App\Models\Preference::getLogo('company_logo');
            return printPDF($data, $packageName . '-' . $subscription->code . '.pdf', 'subscription::invoice_print', view('subscription::invoice_print', $data), 'pdf');
        }
        
        return redirect()->route('package.subscription.invoice', ['id' => $id]);
    }

    /**
     * Paid unpaid plan
     *
     * @param int $id (history_id)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paid(PackageSubscriptionService $service, $id)
    {
        $history = SubscriptionDetails::find($id);

        if (!$history) {
            return back()->withErrors(__('Subscription does not exist.'));
        }

        $plan = $service->manualPaid($history);

        if ($plan['status'] == 'success') {
            return back()->withSuccess($plan['message']);
        }

        return back()->withErrors($plan['message']);
    }
}
