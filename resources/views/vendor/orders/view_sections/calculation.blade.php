@php
    $feeTotal = 0;
    $customTaxTotal = 0;
    $customTax = !empty($customTax) ? json_decode($customTax->value) : null;
    
    $subTotal = 0;
    $shippingCharge = 0;
    $tax = 0;
    $discountAmount = $order->vendorCouponDiscount();
    $productEdit = preference('order_product_edit');

@endphp
<div class="card-block calculations_div" id="calculations_div">
    <div class="row">
        <div class="col-sm-12">

            <div class="table-responsive">
                <table class="table invoice-detail-table">
                    <thead>
                    <tr class="thead-default">
                        <th class="w-5"></th>
                        <th>{{ __('Products') }}</th>
                        <th class="align-center">{{ __('Status') }}</th>
                        <th class="align-center">{{ __('Cost') }}</th>
                        <th class="align-center">{{ __('Qty') }}</th>
                        <th class="align-center">{{ __('Total') }}</th>
                        <th class="align-center">{{ __('Tax') }}</th>
                        @if(isset($customTax))
                            @foreach($customTax->product as $customKey => $cut)
                                <th class="align-center">{{ __('Tax') }} 
                                    @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1) 
                                    <a href="javascript:void(0)" class="delete_custom_tax" data-key="{{ $customKey }}" data-label="Delete" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="feather icon-trash"></i></a>
                                    @endif
                                </th>
                            @endforeach
                        @endif
                        @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1)
                            <th></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->vendorOrderProduct($vendorId, $order->id) as $dtkey => $detail)
                        @php
                            if (isActive('Refund')) {
                                $orderDeliverId = \App\Models\Order::getFinalOrderStatus();
                            }

                            $opName = '';
                            if ($detail->payloads != null) {
                                $option = (array)json_decode($detail->payloads);
                                $itemCount = count($option);
                                $i = 0;
                                foreach ($option as $key => $value) {
                                    $opName .= $key . ': ' . $value . (++$i == $itemCount ? '' : ', ');
                                }
                            }

                            $totalRefund = $detail->refunds()->where('status','Accepted')->sum('quantity_sent');
                            $subTotal += $detail->price * $detail->quantity;
                            $shippingCharge += $detail->shipping_charge;
                            $tax += $detail->tax_charge;
                            $productInfo = $orderAction->getProductInfo($detail);
                        @endphp
                        <tr>   
                            <td class="text-right align-middle">
                                <img class="rounded" src="{{ $productInfo['image'] }}" alt="image" width="45" height="45">
                            </td>
                            <td class="text-left align-middle">

                                <h6>
                                    <a href="{{ $productInfo['url'] }}" title="{{ $detail->product_name }}">
                                        {{ trimWords($detail->product_name, 50) }}
                                    </a>
                                </h6>
                                <p class="p-0 mb-0">
                                    {{ !is_null($detail->vendor->name) ? __('Vendor')." : ". $detail->vendor->name . " | " : '' }}
                                    {{ __('SKU') }} : {{ optional($detail->product)->sku }} {{ !empty($opName) ? " | " . $opName : '' }}
                                </p>
                            </td>

                            <td class="pb-1">
                                @if ($totalRefund != $detail->quantity)
                                    @if($detail->is_delivery == 1)
                                        <p class="align-center mt-3">{{ __('Completed') }}</p>
                                    @else
                                        <select class="form-control align-center mt-1 status order-status {{ $detail->is_delivery == 1 ? 'delivery' : '' }}" name="status[{{ $detail->id }}]" data-id = "{{ $detail->id }}" {{ $detail->is_delivery == 1 ? 'disabled' : '' }}>
                                            @foreach ($orderStatus as $status)
                                                @if (strtolower(optional($detail->orderStatus)->payment_scenario) == 'unpaid' && $status->payment_scenario == 'unpaid')
                                                    <option value="{{ $status->id }}" {{ $status->id == $detail->order_status_id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                @endif
                                                @if ($status->payment_scenario == 'paid')
                                                    <option value="{{ $status->id }}" {{ $detail->order_status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                @else
                                    <p class="align-center mt-3">{{ __('Refunded') }}</p>
                                @endif
                            </td>
                            <td class="pb-1" id="product_price_td_{{ $detail->product_id }}">
                                <p class="align-center mt-3 product_price back_action" id="product_price_{{ $detail->product_id }}">{{ formatCurrencyAmount($detail->price) }}</p>
                            </td>
                            <td class="pb-1" id="product_qty_td_{{ $detail->product_id }}">
                                <p class="align-center mt-3 product_qty back_action" id="product_qty_{{ $detail->product_id }}">{{ formatCurrencyAmount($detail->quantity) }}</p>
                            </td>
                            <td class="pb-1"><p class="align-center mt-3">{{ formatNumber($detail->price * $detail->quantity, optional($order->currency)->symbol) }}</p></td>
                            <td class="pb-1" id="product_tax_td_{{ $detail->product_id }}">
                                <p class="align-center mt-3 back_action" id="product_tax_{{ $detail->product_id }}">{{ formatNumber($detail->tax_charge, optional($order->currency)->symbol) }}</p>
                            </td>
                            @if(isset($customTax))
                                @foreach($customTax->product as $key12 => $cut)
                                    @foreach($cut as $customTaxProduct)
                                        @if($customTaxProduct->product_id == $detail->product_id)
                                            <td class="pb-1" data-key="{{ $key12 }}" data-amount="{{ $customTaxProduct->tax }}">
                                                <p class="align-center mt-3 back_action custom_tax_{{ $detail->product_id }} ">{{ formatNumber($customTaxProduct->tax, optional($order->currency)->symbol) }}</p>
                                            </td>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                            @if(preference('product_label_wise_shipment_track') && preference('vendor_assign_shipping_provider') && preference('shipping_provider'))
                                <td class="pb-1 text-right align-middle">
                                    <a href="javascript:void(0)" type="button" data-bs-toggle="modal" data-bs-target="#track-shipping" title="{{__(':x Track',['x' => __('Shipping')])}}" class="shipping-track-info mt-3" 
                                        data-order_id="{{$detail->order_id}}"
                                        data-product_id="{{$detail->product_id}}"
                                        data-shipping_provider_id="{{optional($detail->shippingTrack)->shipping_provider_id}}"
                                        @if(optional($detail->shippingTrack)->shipping_provider_id != 0)
                                            data-shipping_provider_logo="{{optional(optional($detail->shippingTrack)->shippingProvider)->fileUrl()}}"
                                        @else
                                            data-shipping_provider_logo="{{asset(defaultImage('default'))}}"
                                        @endif
                                        data-provider_name="{{optional($detail->shippingTrack)->provider_name}}"
                                        data-tracking_link="{{optional($detail->shippingTrack)->tracking_link}}"
                                        data-tracking_no="{{optional($detail->shippingTrack)->tracking_no}}"
                                        data-order_shipped_date="{{optional($detail->shippingTrack)->order_shipped_date}}"
                                        data-track_type="product"
                                    >
                                    <i class="fa fa-shipping-fast"></i></a>
                                </td>
                            @endif
                            @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1)
                                <td class="pb-1 text-right align-middle">
                                    <a href="javascript:void(0)" title="{{ __('Edit') }}" class="edit_product back_action" data-productId="{{ $detail->product_id }}" data-price = "{{ $detail->price }}" data-qty = "{{ $detail->quantity }}" data-tax = "{{ $detail->tax_charge }}"><i class="feather icon-edit-1"></i></a>
                                    <a href="javascript:void(0)" title="{{ __('Delete') }}" class="delete_product" data-productId="{{ $detail->product_id }}" data-label="Delete" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="feather icon-trash"></i></a>
                                </td>
                            @endif
                        </tr>
                    @endforeach

                    @if(!empty($customFee))
                        @php $feeData = json_decode($customFee->value) @endphp
                        @foreach($feeData as $feeKey => $fee)
                            <tr>
                                <td class="pb-1">
                                    <i class="fas fa-plus-circle mt-3"></i>
                                </td>
                                <td class="pb-1">
                                    <p class="align-center mt-3">{{ $fee->type != 'percent' ? formatNumber($fee->amount, optional($order->currency)->symbol) : formatCurrencyAmount($fee->amount) }}{{ $fee->type == 'percent' ? '%' : '' }} <span class="back_action" id="order_fee_lbl_{{ $fee->key }}">{{ $fee->label }}</span></p>
                                </td>
                                <td id="order_fee_lbl_td_{{ $fee->key }}"></td>
                                <td></td>
                                <td></td>
                                @php
                                    $feeTotal += $fee->calculated_amount;
                                    $customTaxTotal += $fee->tax;
                                @endphp
                                <td class="pb-1" id="order_fee_td_{{ $fee->key }}"><p class="align-center mt-3 back_action" id="order_fee_{{ $fee->key }}">{{ formatNumber($fee->calculated_amount, optional($order->currency)->symbol) }}</p></td>
                                <td id="order_fee_tax_td_{{ $fee->key }}"><p class="align-center mt-3 back_action" id="order_fee_tax_{{ $fee->key }}">{{ formatNumber($fee->tax, optional($order->currency)->symbol) }}</p></td>
                                @if(isset($customTax))

                                    @foreach($customTax->fee as $key2345 => $cut)
                                        @foreach($cut as $customTaxFee)
                                            @if($customTaxFee->key == $fee->key)
                                                <td class="pb-1" data-key="{{ $fee->key }}" data-index="{{ $key2345 }}" data-amount="{{ $customTaxFee->tax }}">
                                                    <p class="align-center mt-3 back_action custom_fee_{{ $fee->key }}">{{ formatNumber($customTaxFee->tax, optional($order->currency)->symbol) }}</p>
                                                </td>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1)
                                    <td class="pb-1 text-right align-middle">
                                        <a href="javascript:void(0)" title="{{ __('Edit') }}" class="edit_fee back_action" data-key="{{ $fee->key }}" data-amount = "{{ $fee->calculated_amount }}" data-lbl="{{ $fee->label }}" data-tax="{{ $fee->tax }}"><i class="feather icon-edit-1"></i></a>
                                        <a href="javascript:void(0)" title="{{ __('Delete') }}" class="delete_fee" data-key="{{ $fee->key }}" data-label="Delete" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="feather icon-trash"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif

                    @foreach($order->couponRedeems as $redeem)
                        @if($redeem->coupon->vendor_id == auth()->user()->vendor()->vendor_id)
                            <tr>
                                <td class="pb-1">
                                    <i class="fas fa-bullhorn mt-3"></i>
                                </td>
                                <td class="pb-1">
                                    <p class="align-center mt-3">{{ $redeem->coupon_code }} ({{ __('Coupon') }})</p>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><p class="align-center mt-3">-{{ formatNumber($redeem->discount_amount, optional($order->currency)->symbol) }}</p></td>
                                <td></td>
                                @if(isset($customTax))
                                    @foreach($customTax->product as $customKey => $cut)
                                        <td></td>
                                    @endforeach
                                @endif
                                @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1)
                                <td class="pb-1 text-right align-middle">
                                    <a href="javascript:void(0)" title="{{ __('Delete') }}" class="delete_coupon" data-key="{{ $redeem->id }}" data-label="Delete" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="feather icon-trash"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
            @if(preference('product_label_wise_shipment_track') && preference('vendor_assign_shipping_provider') && preference('shipping_provider'))
                {{-- Shipping track modal --}}
                <div id="track-shipping" class="modal fade display_none" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('Track :x', ['x' => __('Shipping')]) }} &nbsp;</h4>
                                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="order-shipment-tracking-container">
                                    <div class="update-shipment-track-container">
                                        <div class="form-group row">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <input type="hidden" name="order_id" id="order_id">
                                            <input type="hidden" name="track_type" value="product" id="track_type">
                                            <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Choose Provider') }}
                                            </label>
                                            <div class="col-sm-12">
                                                <select class="form-control select-provider select2 sl_common_bx" id="shipping_provider_id" name="shipping_provider_id">
                                                    {{-- Provider load by ajax --}}
                                                </select>
                                                <small class="form-text text-muted">{{ __("Select the provider responsible for shipment.") }}</small>
                                            </div>
                                        </div>
                                        <div class="form-group row d-none" id="custom_provider_name">
                                            <label for="provider_name" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Provider Name') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control inputFieldDesign" value="" name="provider_name" id="provider_name" placeholder="{{ __('Provider Name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tracking_number" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Tracking Number') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control inputFieldDesign" name="tracking_number" id="tracking_number" placeholder="{{ __('Tracking No') }}">
                                                <input type="hidden" id="tracking_base_url">
                                                <p class="ml-5p m-change mt-2 mb-0" id="generate_track_link">{{ __('Update Tracking Link') }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tracking_link" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Tracking Link') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control inputFieldDesign" name="tracking_link" id="tracking_link" placeholder="{{ __('Tracking Link') }}">
                                                <a class="m-change mt-5 mb-0"  href="#" target="_blank" id="preview_link">{{ __('Preview Link') }}</a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="order_shipped_date" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Date Shipped') }}</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control inputFieldDesign" id="order_shipped_date" name="order_shipped_date" placeholder="{{ __('Date') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer py-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left" id="updateOrderTrack">{{ __('Save Tracking') }}</button>
                                        <button type="button"
                                            class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- Shipping track modal --}}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-responsive invoice-table invoice-total">
                <tbody class="mt-3 mb-3">
                <tr>
                    <th>{{ __('Sub Total') }} :</th>
                    <td>{{ formatNumber(($subTotal), optional($order->currency)->symbol) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Fees') }} :</th>
                    <td>{{ formatNumber(($feeTotal), optional($order->currency)->symbol) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Shipping') }} {{ !is_null($order->shipping_title) ? "( ". $order->shipping_title . " )" : null }} :</th>
                    <td>{{ formatNumber($shippingCharge, optional($order->currency)->symbol) }}</td>
                </tr>
                @php
                    $totalCustomTax =  $order->updatedCustomTaxFee($order, true, true);
                @endphp
                <tr>
                    <th>{{ __('Tax') }} :</th>
                    <td>{{ formatNumber($tax + $customTaxTotal + $totalCustomTax, optional($order->currency)->symbol) }}</td>
                </tr>
                @if($discountAmount > 0)
                    <tr>
                        <th>{{ __('Coupon offer') }} :</th>
                        <td>-{{ formatNumber($discountAmount, optional($order->currency)->symbol) }}</td>
                    </tr>
                @endif

                @if($order->other_discount_amount > 0)
                    <tr>
                        <th>{{ __('Discount') }} :</th>
                        <td>{{ formatNumber($order->other_discount_amount, optional($order->currency)->symbol) }}</td>
                    </tr>
                @endif

                <tr class="text-info">
                    <td>
                        <hr />
                        <h5 class="text-primary m-r-10">{{ __('Grand Total') }} :</h5>
                    </td>
                    <td>
                        <hr />
                        <h5 class="text-primary">{{ formatNumber($subTotal + $shippingCharge + $tax - $discountAmount + $customTaxTotal + $totalCustomTax + $feeTotal, optional($order->currency)->symbol) }}</h5>
                    </td>
                </tr>
                </tbody>
            </table>
            @if($order->orderStatus->payment_scenario != 'paid' && $productEdit == 1)
                <div class="float-left" id="custom_item_btn">
                    <div class="row">
                        <div class="col-md-4">
                            <a class="add-files-button" id="add_item">{{ __('Add item') }}</a>
                        </div>
                        <div class="col-md-4">
                            <a class="add-files-button" id="apply_coupon" data-label="Coupon" data-bs-toggle="modal" data-bs-target="#coupon_modal">{{ __('Apply Coupon') }}</a>
                        </div>
                    </div>
                </div>
                <div class="float-right display_none" id="custom_item_list">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="javascript:void(0)" id="add_product" class="add-files-button" data-label="Delete" data-bs-toggle="modal" data-bs-target="#product_modal">{{ __('Product') }}</a>
                        </div>
                        <div class="col-md-3">
                            <a href="javascript:void(0)" id="add_fee" class="add-files-button" data-label="Fee" data-bs-toggle="modal" data-bs-target="#fee_modal">{{ __('Fee/shipping') }}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" id="add_tax" class="add-files-button" data-label="Fee" data-bs-toggle="modal" data-bs-target="#add_tax_modal" class="add-files-button">{{ __('Add Tax') }}</a>
                        </div>
                        <div class="col-md-2">
                            <a class="add-files-button" id="cancel_btn">{{ __('Cancel') }}</a>
                        </div>
                        <div class="col-md-2">
                            <a href="javascript:void(0)" id="save_custom" class="add-files-button">{{ __('Save') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
