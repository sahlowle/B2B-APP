@extends('site.myaccount.layouts.master')
@section('page_title', __('Order Details'))
@section('content')
    @php
        // $order get from controller
        $orderStatus = \App\Models\OrderStatus::getAll()->sortBy('order_by');
        $orderDetails = collect($order->orderDetails);
        $orderHistories = collect($order->orderHistories);
        $detailGroups = $orderDetails->groupBy('vendor_id');
        $orderAction = new \App\Services\Actions\OrderAction();
        $customTax = $order->updatedCustomTaxFee($order, true);
        $customFee = $order->metadata->where('key', 'meta_custom_fee')->first();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_order_view">
        <section>
            <div class="flex justify-between items-center gap-5">
                <p class="text-2xl text-black font-medium">{{ __("Order Details") }}</p>
                <a href="{{ route('site.order') }}" class="text-sm font-normal text-gray-400 flex justify-end items-center gap-1 mb-1" href="javaScript:voide(0)"><svg class="neg-transition-scale" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4688 3.52925C10.2085 3.2689 9.78634 3.2689 9.52599 3.52925L5.52599 7.52925C5.26564 7.7896 5.26564 8.21171 5.52599 8.47205L9.52599 12.4721C9.78634 12.7324 10.2085 12.7324 10.4688 12.4721C10.7291 12.2117 10.7291 11.7896 10.4688 11.5292L6.9402 8.00065L10.4688 4.47206C10.7291 4.21171 10.7291 3.7896 10.4688 3.52925Z" fill="#898989"></path>
                </svg>
                {{ __("Back") }}
                </a>
                
            </div>
            <div class="flex justify-start items-center md:gap-12 gap-5 mt-7 flex-wrap">
                <div class="flex flex-col gap-0.5">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("ID Number") }}:</span>
                    <div class="font-medium text-xl leading-7 text-black">{{ $order->reference }} 
                        <span>
                            <a {{ json_decode(preference('invoice'))?->general->pdf_view == 'new_tap' ? 'target="_blank"' : '' }} 
                                href="{{ route('site.invoice.print', ['id' => $order->id, 'type' => 'print']) }}" 
                                class="text-sm leading-5 px-3 py-1 border border-gray-400 rounded ltr:ml-2.5 rtl:mr-2.5">
                                {{ __("Invoice") }}</a>
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Status") }}:</span>
                    <span class="font-medium text-xl leading-7 text-black">{{ $order->orderStatus?->name }}</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Shipping Method") }}:</span>
                    <span class="font-medium text-xl leading-7 text-black">{{ $order->shipping_title }}</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Tracking Code") }}:</span>
                    <span class="font-medium text-xl leading-7 text-black">{{ $order->track_code }}</span>
                </div>
            </div>
        </section>
        <section>
            <div class="grid xl:grid-cols-3 md:grid-cols-2 grid-cols-1 justify-start items-start md:gap-6 gap-7 mt-10">
                <div class="flex flex-col gap-2">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Payment Information") }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words mt-1">{{ __("Status") }}:
                        <span class="{{ $order->payment_status == 'Paid' ? 'text-green-1' : 'text-reds-3' }}  ltr:ml-1 rtl:mr-1">{{$order->payment_status }}</span>
                    </span>
                    @if($order->paymentMethod?->status == 'pending' && $order->orderStatus?->slug != 'cancelled' && $order->paymentMethod?->gateway != 'CashOnDelivery' && $order->payment_status != 'Partial')
                        <div class="flex justify-start gap-2">
                        <a href="{{ route('site.order.payment.guest', ['reference' => $order->reference]) }}" class="text-sm leading-5 px-3 py-1 bg-yellow-400 rounded w-max">{{ __("Pay Now") }}</a>
                        <a href="javascript:void(0)" data-route="{{ route('site.order.custom.payment', ['reference' => techEncrypt($order->reference)]) }}" class="text-sm leading-5 px-3 py-1 bg-yellow-400 rounded w-max" id="payment-link">{{ __("Copy Link") }}</a>
                        </div>
                    @endif
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Paid Amount") }}: {{ formatNumber($order->paid, optional($order->currency)->symbol) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Amount to be paid") }}: {{ formatNumber($order->total - $order->paid, optional($order->currency)->symbol) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("TAX") }}: {{ formatNumber($order->tax_charge, optional($order->currency)->symbol) }}</span>
                    @if ($order->note)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Note") }}: {{ $order->note }}</span>
                    @endif
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Payment Method") }}: {{ !empty($order->paymentMethod?->gateway) ? paymentRenamed($order->paymentMethod?->gateway) : __('Unknown') }}</span>

                    @if ($order->meta_cash_amount)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Cash Amount") }}: {{ $order->meta_cash_amount }}</span>
                    @endif
                    @if ($order->meta_change_amount)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Change Amount") }}: {{ $order->meta_change_amount }}</span>
                    @endif
                    @if ($order->meta_card_number)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Card Number") }}: {{ $order->meta_card_number }}</span>
                    @endif
                    @if ($order->meta_card_holder_name)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Card Holder Name") }}: {{ $order->meta_card_holder_name }}</span>
                    @endif
                    @if ($order->meta_card_expire_date)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Card Expire Date") }}: {{ $order->meta_card_expire_date }}</span>
                    @endif
                    @if ($order->meta_cheque_number)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Cheque Number") }}: {{ $order->meta_cheque_number }}</span>
                    @endif
                    @if ($order->meta_bank_name)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Bank Name") }}: {{ $order->meta_bank_name  }}</span>
                    @endif
                    @if ($order->meta_bank_transfer_number)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Bank Transfer Number") }}: {{ $order->meta_bank_transfer_number }}</span>
                    @endif
                    @if ($order->meta_additional_note)
                        <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Additional Note") }}: {{ $order->meta_additional_note }}</span>
                    @endif
                </div>
                @php
                    $shippingAddress = $order->getShippingAddress();
                    $billingAddress = $order->getBillingAddress();
                    $feeTotal = 0;
                    $customTaxTotal = 0;
                @endphp
                <div class="flex flex-col gap-2">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Billing Address") }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words mt-1">{{ $billingAddress->phone }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ $billingAddress->email }}</span>
                    <span class="font-normal text-sm leading-6 text-black">{{ $billingAddress->address_1 }}
                        {{ !empty($billingAddress->address_2) ? ', ' . $billingAddress->address_2 . ',' : '' }}
                        {{ ucfirst($billingAddress->city) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Postcode") }}: {{ $billingAddress->zip }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("State") }}: {{ \Modules\GeoLocale\Entities\Division::getStateNameByCountryStateCode($billingAddress->country, $billingAddress->state) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Country") }}: {{ \Modules\GeoLocale\Entities\Country::getNameByCode($billingAddress->country) }}</span>
                </div>
                <div class="flex flex-col gap-2">
                    <span class="font-normal leading-5 test-base text-gray-400">{{ __("Shipping Address") }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words mt-1">{{ $shippingAddress->first_name . ' ' . $shippingAddress->last_name }}</span>
                    <span class="font-normal text-sm leading-6 text-black">{{ $shippingAddress->address_1 }}
                        {{ !empty($shippingAddress->address_2) ? ', ' . $shippingAddress->address_2 . ',' : '' }}
                        {{  ucfirst($shippingAddress->city) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Postcode") }}: {{ $shippingAddress->zip }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("State") }}: {{ \Modules\GeoLocale\Entities\Division::getStateNameByCountryStateCode($shippingAddress->country, $shippingAddress->state) }}</span>
                    <span class="font-normal text-sm leading-5 text-black break-words">{{ __("Country") }}: {{ \Modules\GeoLocale\Entities\Country::getNameByCode($shippingAddress->country)     }}</span>
                </div>
            </div>
        </section>
        <section class="mt-10">
            <div class="overflow-auto">
                <table class="w-full bg-white">
                    <thead>
                        <tr class="border-gray-400 border rounded">
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Image') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Product') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Cost') }}</th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Qty') }}</th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Amount') }}</th>
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Status') }}</th>
                            <th class="py-2 font-normal text-black px-3 rtl:text-left ltl:text-right whitespace-nowrap text-sm">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailGroups as $group)
                            @foreach ($group as $detail)
                                @if ($loop->iteration == 1)
                                    <tr class="!bg-white">
                                        <td colspan="6" class="pt-3 pb-2 text-sm font-normal text-black ltr:pl-3 rtl:pr-3 leading-5">{{ __('Seller') }}: {{ optional($detail->vendor)->name }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tbody>
                            @foreach ($group as $detail)
                                @php
                                    $opName = '';
                                    if ($detail->payloads != null) {
                                        $option = (array)json_decode($detail->payloads);
                                        $itemCount = count($option);
                                        $i = 0;
                                        foreach ($option as $key => $value) {
                                            $opName .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                                        }
                                    }

                                    $productInfo = $orderAction->getProductInfo($detail);
                                    $purchaseNote = $detail->productMeta->where('key', 'meta_purchase_note')->first();
                                @endphp
                                <tr class="order-table">
                                    <td class="p-3 ltr:text-left rtl:text-right">
                                        <span class="w-14 h-14 flex justify-center items-center">
                                            <img src="{{ $productInfo['image'] }}" alt="item"
                                                class="w-14 h-14 rounded">
                                        </span>
                                    </td>
                                    <td class="p-3 ltr:text-left rtl:text-right">
                                        <a href="{{ $productInfo['url'] }}" class="flex items-center justify-start">
                                            <div
                                                class="w-72 break-words h-11 flex items-center font-medium text-black text-sm">
                                                {{ trimWords($detail->product_name, 65) }}
                                            </div>
                                        </a>
                                        <div class="flex items-center font-medium text-gray-10 text-sm">
                                            {{ $opName }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <span class="font-medium text-sm text-black whitespace-nowrap">{{ formatNumber($detail->price, optional($order->currency)->symbol) }}</span>
                                    </td>
                                    <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                        <span class="ffont-medium text-sm text-black whitespace-nowrap">
                                            {{ formatCurrencyAmount($detail->quantity) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4">
                                        <span class="font-medium text-sm text-black whitespace-nowrap">{{ formatNumber($detail->quantity * $detail->price, optional($order->currency)->symbol) }}</span>
                                    </td>
                                    <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                        <span
                                            class="font-medium text-black px-3 py-1 rounded-full text-xs leading-5  whitespace-nowrap">{{ optional($detail->orderStatus)->name }}</span>
                                    </td>
                                    <td class="px-3 py-4 rtl:text-left ltl:text-right">
                                        @if ($detail->isRefundable() && preference('order_refund'))
                                            <a class="bg-black font-medium text-white px-3 py-1 rounded text-xs leading-5 whitespace-nowrap" href="{{ route('site.createRefundRequest', ['order_id' => $order->id, 'product_id' => $detail->product_id]) }}">{{ __('Refund') }}</a>
                                        @endif
                                        @if ($detail->isRefunded() && preference('order_refund'))
                                            <div class="roboto-medium font-medium text-gray-12 py-2 px-6 flex justify-left items-center">
                                                {{ __('Refunded') }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                        @if(!empty($customFee))
                            @php $feeData = json_decode($customFee->value) @endphp
                            @foreach($feeData as $feeKey => $fee)
                                <tr class="focus-within:bg-gray-200 overflow-hidden">
                                    <td colspan="2" class="dm-sans font-medium text-gray-12 px-3 py-2">
                                        <i class="fas fa-plus-circle mt-3"></i> &nbsp;{{ formatNumber($fee->amount, optional($order->currency)->symbol) }}{{ $fee->type == 'percent' ? '%' : '' }} {{ $fee->label }}
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td class="dm-sans font-medium text-gray-12 px-3 py-2">
                                        {{ formatNumber($fee->calculated_amount, optional($order->currency)->symbol) }}
                                    </td>
                                    @php
                                        $feeTotal += $fee->calculated_amount;
                                        $customTaxTotal += $fee->tax;
                                    @endphp
                                </tr>
                            @endforeach
                        @endif                        
                    </tbody>
                    <tfoot>
                        <tr class="">
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="3">
                            </td>
                            @php
                                $couponOffer = isset($order->couponRedeems) && $order->couponRedeems->sum('discount_amount') > 0 && isActive('Coupon') ? $order->couponRedeems->sum('discount_amount') : 0;
                            @endphp
                            <td class="px-3 py-4 ltr:text-left rtl:text-right" colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ __("Sub Total") }}</span>
                            </td>
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ formatNumber($order->total + $order->other_discount_amount + $couponOffer - ($order->shipping_charge + $order->tax_charge), optional($order->currency)->symbol) }}</span>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="px-3 py-4 rtl:text-left ltl:text-right"  colspan="3">
                            </td>
                            <td class="px-3 py-4 ltr:text-left rtl:text-right"  colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ __("Shipping") }} {{ !is_null($order->shipping_title) ? "( ". $order->shipping_title . " )" : null }}</span>
                            </td>
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ formatNumber($order->shipping_charge, optional($order->currency)->symbol) }}</span>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="px-3 py-4 rtl:text-left ltl:text-right"  colspan="3">
                            </td>
                            <td class="px-3 py-4 ltr:text-left rtl:text-right"  colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ __("Tax") }}</span>
                            </td>
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">
                                <span class="font-normal text-base text-black whitespace-nowrap">{{ formatNumber($order->tax_charge + $customTax + $customTaxTotal, optional($order->currency)->symbol) }}</span>
                            </td>
                        </tr>
                        @if ($couponOffer > 0)
                            <tr class="">
                                <td class="px-3 py-4 rtl:text-left ltl:text-right"  colspan="3">
                                </td>
                                <td class="px-3 py-4 ltr:text-left rtl:text-right"  colspan="2">
                                    <span class="font-normal text-base text-black whitespace-nowrap">{{ __("Coupon Offer") }}</span>
                                </td>
                                <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">-{{ formatNumber($couponOffer, optional($order->currency)->symbol) }}</td>
                            </tr>
                        @endif
                        @if ($order->other_discount_amount > 0)
                            <tr class="focus-within:bg-gray-200 overflow-hidden border border-gray-2">
                                <td class="px-3 py-4 rtl:text-left ltl:text-right"  colspan="3">
                                </td>
                                <td class="px-3 py-4 ltr:text-left rtl:text-right"  colspan="2">
                                    <span class="font-normal text-base text-black whitespace-nowrap">{{ __("Discount") }}</span>
                                </td>
                                <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">{{ formatNumber($order->other_discount_amount, optional($order->currency)->symbol) }}</td>
                            </tr>
                        @endif
                        @if ($feeTotal > 0)
                            <tr class="">
                                <td colspan="2" class="px-3 py-4 rtl:text-left ltl:text-right"></td>
                                @if (isActive('Shop'))
                                    <td class="px-3 py-4 rtl:text-left ltl:text-right"></td>
                                @endif
                                <td colspan="2" class="px-3 py-4 ltr:text-left rtl:text-right">
                                    <span class="font-normal text-base text-black whitespace-nowrap">{{ __('Fees') }}</span>
                                </td>
                                <td colspan="2" class="px-3 py-4 rtl:text-left ltl:text-right">{{ formatNumber($feeTotal, optional($order->currency)->symbol) }}</td>
                            </tr>
                        @endif
                        <tr class="">
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="3">
                            </td>
                            <td class="px-3 py-4 ltr:text-left rtl:text-right" colspan="2">
                                <span class="font-medium text-base text-black whitespace-nowrap">{{ __("Grand Total") }}</span>
                            </td>
                            <td class="px-3 py-4 rtl:text-left ltl:text-right" colspan="2">
                                <span class="font-medium text-base text-black whitespace-nowrap">{{ formatNumber($order->total + $customTax + $customTaxTotal + $feeTotal, optional($order->currency)->symbol) }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </main>
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/site/order.min.js') }}"></script>
@endsection
