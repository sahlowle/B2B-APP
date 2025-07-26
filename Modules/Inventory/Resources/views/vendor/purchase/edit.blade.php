@extends('vendor.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Purchase')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Inventory/Resources/assets/css/purchase.min.css') }}">
@endsection

@section('content')

    <div class="col-sm-12" id="purchase-edit-container">

        {{-- Notification --}}
        <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
            <div class="noti-alert pad">
                <div class="alert bg-dark text-light m-0 text-center">
                    <span class="notification-msg"></span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('vendor.purchase.update', $purchaseDetails->id) }}" method="post" id="purchase_form">
            @csrf
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Edit :x', ['x' => __('Purchase')]) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Reference') }}</label>
                                    <div class="col-md-8">
                                        <input id="reference" class="form-control inputFieldDesign" value="{{ $purchaseDetails->reference }}" readonly type="text" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="vendor_id" value="{{ $purchaseDetails->vendor_id }}">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Supplier') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control" readonly="true" name="supplier_id" id="supplier_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="{{ $purchaseDetails->supplier_id }}" selected>{{ $purchaseDetails->supplier->name  }}</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label require">{{ __('Location') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control" readonly="true" name="location_id" id="location_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="{{ $purchaseDetails->location_id }}" selected>{{ $purchaseDetails->location->name  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Payment Type') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="payment_type" id="payment_type">
                                            <option value="">{{ __('Select One')  }}</option>
                                            <option value="Cash On Delivery" @selected($purchaseDetails->payment_type == 'Cash On Delivery')>{{ __('Cash On Delivery')  }}</option>
                                            <option value="Payment On receipt" @selected($purchaseDetails->payment_type == 'Payment On receipt')>{{ __('Payment On receipt')  }}</option>
                                            <option value="Payment In Advance" @selected($purchaseDetails->payment_type == 'Payment In Advance')>{{ __('Payment In Advance')  }}</option>
                                            <option value="Net 7" @selected($purchaseDetails->payment_type == 'Net 7')>{{ __('Net 7')  }}</option>
                                            <option value="Net 15" @selected($purchaseDetails->payment_type == '"Net 15')>{{ __('Net 15')  }}</option>
                                            <option value="Net 30" @selected($purchaseDetails->payment_type == 'Net 30')>{{ __('Net 30')  }}</option>
                                            <option value="Net 45" @selected($purchaseDetails->payment_type == 'Net 45')>{{ __('Net 45')  }}</option>
                                            <option value="Net 60" @selected($purchaseDetails->payment_type == 'Net 60')>{{ __('Net 60')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Supplier Currency') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="currency_id" id="currency_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select One')  }}</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->id }}" @selected($purchaseDetails->currency_id == $currency->id)>{{ $currency->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Shipping Carrier') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" name="shipping_carrier" id="shipping_carrier">
                                            <option value="">{{ __('Select One')  }}</option>
                                            <option value="4PX" @selected($purchaseDetails->shipping_carrier == '4PX')>{{ __('4PX')  }}</option>
                                            <option value="99 Minutos" @selected($purchaseDetails->shipping_carrier == '99 Minutos')>{{ __('99 Minutos')  }}</option>
                                            <option value="Aeronet" @selected($purchaseDetails->shipping_carrier == 'Aeronet')>{{ __('Aeronet')  }}</option>
                                            <option value="Ags" @selected($purchaseDetails->shipping_carrier == 'Ags')>{{ __('Ags')  }}</option>
                                            <option value="Amazon Logistic UK" @selected($purchaseDetails->shipping_carrier == 'Amazon Logistic UK')>{{ __('Amazon Logistic UK')  }}</option>
                                            <option value="Amazon Logistic US" @selected($purchaseDetails->shipping_carrier == 'Amazon Logistic US')>{{ __('Amazon Logistic US')  }}</option>
                                            <option value="DHL Ecommerce" @selected($purchaseDetails->shipping_carrier == 'DHL Ecommerce')>{{ __('DHL Ecommerce')  }}</option>
                                            <option value="DHL Express" @selected($purchaseDetails->shipping_carrier == 'DHL Express')>{{ __('DHL Express')  }}</option>
                                            <option value="DHL Ecommerce Asia" @selected($purchaseDetails->shipping_carrier == 'DHL Ecommerce Asia')>{{ __('DHL Ecommerce Asia')  }}</option>
                                            <option value="DHL Global Mail Asia" @selected($purchaseDetails->shipping_carrier == 'DHL Global Mail Asia')>{{ __('DHL Global Mail Asia')  }}</option>
                                            <option value="DHL Sweden" @selected($purchaseDetails->shipping_carrier == 'DHL Sweden')>{{ __('DHL Sweden')  }}</option>
                                            <option value="China Post" @selected($purchaseDetails->shipping_carrier == 'China Post')>{{ __('China Post')  }}</option>
                                            <option value="Deliver It" @selected($purchaseDetails->shipping_carrier == 'Deliver It')>{{ __('Deliver It')  }}</option>
                                            <option value="First Line" @selected($purchaseDetails->shipping_carrier == 'First Line')>{{ __('First Line')  }}</option>
                                            <option value="Other" @selected($purchaseDetails->shipping_carrier == 'Other')>{{ __('Other')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Tracking number') }}
                                    </label>
                                    <div class="col-md-8">
                                        <input id="tracking_number" class="form-control inputFieldDesign" type="text" name="tracking_number" value="{{ $purchaseDetails->tracking_number }}" placeholder="{{ __('Tracking number') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Products') }}</h5>
                    </div>
                    <div class="card-body">
                        @if($purchaseDetails->status != 'Received')
                            <div class="row">
                                <label class="col-form-label col-md-4" for="add_products">{{ __('Add Products') }}
                                </label>
                                <div class="col-md-8">
                                    <input id="search" class="form-control inputFieldDesign" type="text" name="search" placeholder="{{ __('Search for product by name') }}" {{ $purchaseDetails->status == 'Received' ? 'readonly' : '' }}>
                                    <li id="no_div">
                                        <div>
                                            <label>{{__('No data found')}}</label>
                                        </div>
                                    </li>
                                </div>
                                <div class="col-md-4"></div>
                                <div id="error_message" class="text-danger col-md-4"></div>
                            </div>
                      <br>
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table" id="product-table">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Products') }}</th>
                                        <th class="text-center w-10">{{ __('Supplier SKU') }}</th>
                                        <th class="itemQty text-center w-10">
                                            {{ __('Quantity') }}
                                        </th>
                                        <th class="text-center w-10">
                                            {{ __('Cost') }}
                                        </th>
                                        <th class="text-center w-10">
                                            {{ __('Tax') }} %
                                        </th>
                                        <th class="text-center w-10">
                                            {{ __('Total') }}
                                        </th>
                                        <th class="w-5">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    @php 
                                    $rowNo = 0;
                                    @endphp
                                    @foreach($purchaseDetails->purchaseDetail as $key => $detail)
                                        @php $rowNo = $key; $stack[] =  $detail->product_id @endphp
                                    <tbody id="rowId-{{ $key }}" class="purchase_products">
                                    <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}">
                                    <tr class="itemRow rowNo-{{ $key }}" id="productId-{{ $detail->product_id }}"  data-row-no="{{ $key }}">
                                        <td class="pl-1">
                                           <input type="hidden" name="product_name[]" value="{{ $detail->product_name }}">
                                            {{ $detail->product_name }}
                                        </td>

                                        <td class="sup_sku">
                                            <input name="sup_sku[]" id="sup_sku_{{ $key }}" class="form-control text-center" type="text" value="{{ $detail->sku }}">
                                        </td>

                                        <td class="productQty">
                                            <input name="product_qty[]" id="product_qty_{{ $key }}" class="inputQty form-control text-center positive-float-number" type="text" value="{{ formatCurrencyAmount($detail->quantity) }}" data-rowId = {{ $key }}>
                                        </td>
                                        <td class="productCost">
                                            <input id="product_cost_{{ $key }}" name="product_cost[]" class="inputCost form-control text-center positive-float-number" type="text"  value="{{ formatCurrencyAmount($detail->amount) }}">
                                        </td>

                                        <td class="productTax">
                                            <input  id="product_tax_{{ $key }}" type="text" class="inputTax form-control text-center positive-float-number" name="product_tax[]" value="{{ formatCurrencyAmount($detail->tax_charge) }}">
                                        </td>
                                        @php
                                            $tax = (($detail->quantity * $detail->amount) * $detail->tax_charge)/100;
                                        @endphp
                                        <td class="productAmount">
                                            <span class="form-control text-center" id="product_amount_{{ $key }}">{{ formatCurrencyAmount(($detail->amount * $detail->quantity) + $tax) }}</span>
                                        </td>
                                        @if($purchaseDetails->status == 'Ordered')
                                        <td class="text-center padding_top_15px">
                                            <a href="javascript:void(0)" class="closeRow" data-row-id="{{ $key }}" data-id="{{ $detail->product_id }}"><i class="feather icon-trash"></i></a>
                                        </td>
                                        @endif
                                    </tr>

                                    </tbody>
                                    @endforeach
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Additional Details') }}</h5>
                            </div>
                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">{{ __('Estimate Arrival Date') }}</label>
                                    <div class="col-md-8">
                                        <input id="arrival_date" class="form-control inputFieldDesign" type="text" name="arrival_date" value="{{ $purchaseDetails->arrival_date }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Note to Supplier') }}
                                    </label>
                                    <div class="col-md-8">
                                        <textarea placeholder="{{ __('Note') }}" rows="3" class="form-control" name="note" spellcheck="false">{{ $purchaseDetails->note }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Cost Summary') }}</h5>
                                <a href="javascript:void(0)" class="float-right" data-toggle="modal" data-target="#myModal" id="settings_modal">{{ __('Manage') }}</a>
                            </div>
                            <div class="card-body">
                                <div id="cost_management">
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-6">{{ __('Taxes (Included)') }}</label>
                                        <label class="col-form-label col-md-6" id="subTotalTax">{{ formatCurrencyAmount($purchaseDetails->tax_charge) }}</label>
                                    </div>
                                    
                                    @php 
                                    $subTotal = $purchaseDetails->total_amount;
                                    
                                    if ($purchaseDetails->shipping_charge > 0) {
                                        $subTotal -= $purchaseDetails->shipping_charge;
                                    }
                   
                                    $adjustments = !empty($purchaseDetails->adjustment) ? json_decode($purchaseDetails->adjustment, true) : '';
                                
                                    if (isset($adjustments['name'])) {
                                        foreach ($adjustments['name'] as $key => $adjust) {
                                            $subTotal -= $adjustments['amount'][$key];
                                        }
                                    }
                                    
                                    @endphp
                                    
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-6">{{ __('SubTotal') }}</label>
                                        <label class="col-form-label col-md-6" id="subTotalAmount">{{ formatCurrencyAmount($subTotal) }}</label>
                                    </div>
                                    <h4>{{ __('Cost Adjustment') }}</h4>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-6">{{ __('Shipping') }}</label>
                                        <label class="col-form-label col-md-6" id="cost_management_shipping">{{ formatCurrencyAmount($purchaseDetails->shipping_charge) }}</label>
                                    </div>
                                    @if (isset($adjustments['name']))
                                        @foreach($adjustments['name'] as $key => $adjust)
                                            <div class="form-group row customHtml">
                                                <label class="col-form-label col-md-6 cost_management_lbl">{{ $adjust }}</label>
                                                <label class="col-form-label col-md-6 cost_management_val">{{ $adjustments['amount'][$key] }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-6">{{ __('Total') }}</label>
                                    <label class="col-form-label col-md-6" id="totalAmount">{{ formatCurrencyAmount($purchaseDetails->total_amount) }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 px-0 mt-3 mt-md-0">
                    <a href="{{ route('vendor.purchase.index') }}"
                       class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                    <button class="btn custom-btn-submit" type="submit" id="btnSubmit" {{ $purchaseDetails->status == 'Received' ? 'disabled' : '' }}><i
                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                            id="spinnerText">{{ __('Update') }}</span></button>
                </div>
            </div>
            @include('inventory::layouts.purchase_settings')
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        var rowNo = '{{ $rowNo+1 }}';
        var totalAmount = '{{ $purchaseDetails->total_amount }}';
        var editStack = '{{ json_encode($stack) }}'
        var thousandSeparator = '{{ preference('thousand_separator') }}';
    </script>
    <script src="{{ asset('Modules/Inventory/Resources/assets/js/purchase.min.js?v=2.9') }}"></script>
@endsection
