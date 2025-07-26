<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 24-02-2022
 */

namespace Modules\Refund\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Modules\Refund\Entities\{
    Refund
};

class RefundController extends Controller
{
    /**
     * Refund List
     *
     * @return \Illuminate\Contracts\View
     */
    public function index()
    {
        return view('site.myaccount.refund.index');
    }

    /**
     * Store Order Refund
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function refund(Request $request)
    {
        if (! preference('order_refund')) {
            abort(404);
        }

        $response = OrderDetail::find($request->order_detail_id);
        if (! empty($response)) {
            $request['user_id'] = auth()->user()->id;
            $request['refund_type'] = $response->quantity == $request->quantity_sent ? 'Full' : 'Partial';
            $request['refund_method'] = 'Wallet';
            $request['shipping_method'] = 'Drop';
            $request['payment_status'] = $response->order->total == $response->order->paid ? 'Paid' : 'Unpaid';
            $request['reference'] = \Str::random(6);
            $request['status'] = 'Opened';

            $validator = Refund::storeValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if ($response->quantity < $request->quantity_sent) {
                return back()->withErrors(__('You exceeded the maximum quantity.'));
            }

            $this->setSessionValue((new Refund())->store($request->all()));
            if (isset($request->type) && $request->type == 'admin') {
                return redirect()->back();
            }

            return redirect()->route('site.refundRequest');
        }
        $this->setSessionValue(['status' => 'fail', 'message' => __('Something went wrong, please try again.')]);

        return redirect()->back();

    }

    /**
     * Create Refund Request
     *
     * @return \Illuminate\Contracts\View
     */
    public function createRequest()
    {
        if (! preference('order_refund')) {
            abort(404);
        }

        return view('site.myaccount.refund.create');
    }

    /**
     * Order Refund Details
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View
     */
    public function refundDetails($id = null)
    {
        if (is_null($id)) {
            return redirect()->back()->withErrors(__('Refund not found.'));
        }

        $refund = Refund::where(['user_id' => auth()->user()->id, 'id' => $id]);

        if ($refund->doesntExist()) {
            return redirect()->back()->withErrors(__('Refund not found.'));
        }

        return view('site.myaccount.refund.view', compact('id', 'refund'));
    }

    /**
     * Get refund items with order reference
     *
     * @param  string  $reference
     * @return response
     */
    public function getProducts($reference = null)
    {
        return json_encode(Refund::getProducts($reference));
    }
}
