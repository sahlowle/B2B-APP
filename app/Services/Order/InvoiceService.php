<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderMeta;
use App\Models\OrderNoteHistory;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Services\Actions\OrderAction;
use Modules\Refund\Entities\RefundReason;

class InvoiceService
{
    private $order;

    private $request;

    private $requestUser;

    public function __construct($request = null, $requestUser = 'admin')
    {
        $this->request = $request;
        $this->order = Order::where('id', $request->order_id)->first();
        $this->requestUser = $requestUser;
    }

    /**
     * invoice customize
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function customize($statusCheck = true)
    {
        $request = $this->request;
        $order = $this->order;
        $msg = __('The :x has been successfully deleted.', ['x' => __('Data')]);

        if (empty($order) || $statusCheck && $order->orderStatus->payment_scenario == 'paid') {
            return $this->redirectPage($order, __('Something went wrong, please try again.'));
        }

        if (isset($request->action) && $request->action == 'delete' && $request->type == 'product') {
            $response = $order->deleteProductFromOrder($request);

            if ($response) {

                return $this->redirectPage($order, $msg);
            }
        }

        if (isset($request->action) && $request->action == 'delete' && $request->type == 'fee') {
            $response = $order->deleteFeeFromOrder($request);

            if ($response) {

                return $this->redirectPage($order, $msg);
            }
        }

        if (isset($request->action) && $request->action == 'delete' && $request->type == 'custom_tax') {
            $response = $order->deleteCustomTaxFromOrder($request);

            if ($response) {

                return $this->redirectPage($order, $msg);
            }
        }

        if (isset($request->action) && $request->action == 'edit') {

            parse_str($request->data, $inputData);

            if (is_array($inputData) && count($inputData) > 0) {
                $response = $order->updateProductValueFromOrder($request, $inputData);

                if (isset($response['status']) && $response['status']) {
                    return $this->redirectPage($order);
                } else {
                    return $this->redirectPage($order, $response['message']);
                }
            }
        }

        if (isset($request->action) && $request->action == 'add_fee') {
            $response = $order->addFeeInOrder($request);

            if ($response) {

                return $this->redirectPage($order);
            }
        }

        if (isset($request->action) && $request->action == 'add_tax') {
            $response = $order->addCustomTaxInOrder($request);

            if ($response) {

                return $this->redirectPage($order);
            }
        }

        if (isset($request->action) && $request->action == 'add_coupon') {
            $request['request_user'] = $this->requestUser;
            $response = $order->addCouponInOrder($request);

            if ($response) {

                if (isset($response['message'])) {
                    return $this->redirectPage($order, $response['message']);
                } else {
                    return $this->redirectPage($order);
                }
            }
        }

        if (isset($request->action) && $request->action == 'delete' && $request->type == 'coupon_delete') {
            $response = $order->deleteCouponFromOrder($request);

            if ($response) {

                return $this->redirectPage($order);
            }
        }

        if (isset($request->product_id) && is_array($request->product_id)) {
            $response = $order->orderCustomization($request);

            if (isset($response['status']) && $response['status']) {
                return $this->redirectPage($order);
            } else {
                return $this->redirectPage($order, $response['message']);
            }
        }

        return $this->redirectPage($order, __('Something went wrong, please try again.'));
    }

    /**
     * redirect page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectPage($order, $msg = null)
    {
        $order = Order::where('id', $order->id)->first();
        if (! empty($order)) {
            $data['orderStatus'] = OrderStatus::getAll()->sortBy('order_by');
            $data['order'] = $order;
            $data['orderDetails'] = $order->orderDetails->groupBy('vendor_id');
            $data['refundReasons'] = RefundReason::where('status', 'Active')->get();
            $data['orderStatusHistories'] = OrderStatusHistory::where('order_id', $order->id)->whereNotNull('product_id')->orderByDesc('id')->get();
            $data['finalOrderStatus'] = OrderStatus::orderBy('order_by', 'DESC')->first()->id;
            $data['orderNotes'] = OrderNoteHistory::where(['order_id' => $order->id, 'user_id' => auth()->user()->id])->orderBy('id', 'desc')->get();
            $data['orderAction'] = new OrderAction();
            $data['customFee'] = $order->metadata->where('key', 'meta_custom_fee')->first();
            $data['customTax'] = $order->metadata->where('key', 'meta_custom_tax')->first();
            if ($this->requestUser == 'vendor') {
                $data['vendorId'] = session()->get('vendorId');
            }

            return response()->json(
                [
                    'status' => true,
                    'viewHtml' => $this->requestUser == 'vendor' ? view('vendor.orders.view_sections.calculation', $data)->render() : view('admin.orders.view_sections.calculation', $data)->render(),
                    'message' => is_null($msg) ? __('The :x has been successfully saved.', ['x' => __('Data')]) : $msg,
                ]
            );
        }
    }

    public function draftOrder()
    {
        $orderStatus = OrderStatus::where('slug', 'draft')->first();

        if (empty($orderStatus)) {
            $orderStatus = OrderStatus::where('slug', 'pending-payment')->first();
        }

        $data = [
            'id' => null,
            'user_id' => null,
            'reference' => Order::getOrderReference(preference('order_prefix', null)),
            'note' => auth()->user()->id,
            'order_date' => date('Y-m-d'),
            'currency_id' => preference('dflt_currency_id'),
            'leave_door' => null,
            'other_discount_amount' => null,
            'shipping_charge' => null,
            'tax_charge' => null,
            'shipping_title' => null,
            'total' => 0,
            'paid' => 0,
            'total_quantity' => 0,
            'amount_received' => null,
            'order_status_id' => $orderStatus->id ?? null,
        ];

        $orderId = (new Order())->store($data);

        $formatData[] = [
            'order_id' => $orderId,
            'type' => 'string',
            'key' => 'track_code',
            'value' => strtoupper(\Str::random(10)),
        ];

        OrderMeta::upsert($formatData, ['order_id', 'key']);

        return $orderId;

    }

    /**
     * total Custom Amount
     *
     * @return int|mixed
     */
    public static function totalCustomAmount($order, $vendorOnly = false)
    {
        $feeTotal = 0;
        $customTaxTotal = 0;
        $customFee = $order->metadata->where('key', 'meta_custom_fee')->first();
        $customTax = $order->updatedCustomTaxFee($order, true, $vendorOnly);
        if (! empty($customFee)) {
            $feeData = json_decode($customFee->value);
            foreach ($feeData as $feeKey => $fee) {
                $feeTotal += $fee->calculated_amount;
                $customTaxTotal += $fee->tax;
            }
        }

        return $feeTotal + $customTaxTotal + $customTax;
    }
}
