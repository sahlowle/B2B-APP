@extends('vendor.layouts.app')
@section('page_title', __('View :x', ['x' => __('Invoice')]))
@section('css')
    <!-- date range picker css -->
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <!-- select2 css -->
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/dist/css/invoice.min.css') }}">
@endsection
@section('content')

    <!-- Main content -->
    <!-- Main content -->
    <div class="col-md-12" id="vendor-order-view-container">
        {{-- Notification --}}
        <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
            <div class="noti-alert pad">
                <div class="alert bg-dark text-light m-0 text-center">
                    <span class="notification-msg"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <!-- [ Invoice ] start -->
                            <div class="container">
                                <div>
                                    @php
                                        $sections = (new \App\Services\Order\Section)->getSections();
                                        $shippingAddress = $order->getShippingAddress();
                                        $billingAddress = $order->getBillingAddress();
                                    @endphp
                                    <div class="card">
                                        @foreach ($sections as $key => $section)
                                            @if (
                                                ($section['visibility'] ?? '1') == '1' 
                                                && ($section['is_main'] ?? false)
                                                && $section['vendor_content'] ?? false)
                                                @if($key == 'downloadable')
                                                    @php $downloadContent = $section['vendor_content'] @endphp
                                                    @continue;
                                                @endif
                                                @if (is_callable($section['vendor_content']))
                                                    {!! $section['vendor_content']() !!}
                                                @else
                                                    @includeIf($section['vendor_content'])
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                    @if(isset($downloadContent) && is_callable($downloadContent))
                                        <div class="order-details-container">
                                            {!! $downloadContent() !!}
                                        </div>
                                    @elseif(isset($downloadContent))
                                        <div class="order-details-container">
                                            @includeIf($downloadContent)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="order-actions-container">
                    @foreach ($sections as $key => $section)
                        @if (
                            ($section['visibility'] ?? '1') == '1' 
                            && !($section['is_main'] ?? false)
                            && $section['vendor_content'] ?? false)
                            @if (is_callable($section['vendor_content']))
                                {!! $section['vendor_content']() !!}
                            @else
                                @includeIf($section['vendor_content'])
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div id="refund-store" class="modal fade display_none" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Refund') }} &nbsp; </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('site.orderRefund') }}" method="post" class="form-horizontal">
                            @csrf
                            <input type="hidden" name="quantity_sent" id="quantity_sent" value="1">
                            <input type="hidden" name="order_detail_id" id="order_detail_id">
                            <input type="hidden" name="type" value="admin">
                            <div class="form-group row mb-3">
                                <label class="col-3 control-label" for="inputEmail3">{{ __('Quantity') }}</label>
                                <div class="col-6 d-flex align-items-center">
                                    <a href="javascript:void(0)" class="text-center px-3 py-2 border" id="refundQtyDec"><span class="inline-block">-</span></a>
                                    <div class="px-3" id="refundQty">1</div>
                                    <a href="javascript:void(0)" class="text-center px-3 py-2 border" id="refundQtyInc"><span class="inline-block">+</span></a>
                                </div>
                            </div>
                            <div class="form-group row mt-3 mt-md-0">
                                <label class="col-3 control-label pe-0" for="inputEmail3">{{ __('Reason') }}</label>
                                <div class="col-8">
                                    <select class="form-control select2" name="refund_reason_id">
                                        @foreach ($refundReasons as $reason)
                                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label class="col-3 control-label pe-0" for="is_default"></label>
                                <div class="col-8">
                                    <textarea name="comment" class="form-control" placeholder="{{ __('Please let me know, why are you want to refund this item.') }}" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-3 mt-md-0">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn custom-btn-submit float-right">{{ __('Submit') }}</button>
                                    <button type="button" class="btn custom-btn-cancel all-cancel-btn float-right" data-dismiss="modal">{{ __('Close') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if($order->orderStatus->payment_scenario != 'paid')
            <div class="modal fade" id="product_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="add_custom_product_form" action="{{ route('vendor.order.customize') }}" method="post" data-type="add_products">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Product') }}</h5>
                                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <label class="col-form-label col-md-4 require" for="add_products">{{ __('Add Products') }}
                                    </label>
                                    <div class="col-md-8">
                                        <input id="search" class="form-control inputFieldDesign" type="text" name="search" placeholder="{{ __('Search for product by name') }}">
                                        <li id="no_div">
                                            <div>
                                                <label>{{__('No data found')}}</label>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div id="error_message" class="text-danger col-md-4"></div>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table display_none" id="custom-product-table">
                                            <thead>
                                            <tr>
                                                <th class="text-center w-10">
                                                    {{ __('Products') }}
                                                </th>
                                                <th class="text-center w-10">
                                                    {{ __('Quantity') }}
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" id="confirm_add_product" data-task="" class="btn custom-btn-submit">{{ __('Add') }}</button>
                                <span class="ajax-loading"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('vendor.order.customize') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Delete') }}</h5>
                                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure to delete this?') }}
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="delete_id" id="delete_id" value="">
                                <input type="hidden" name="type" id="action_type" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" data-task="" class="btn custom-btn-submit">{{ __('Yes, Confirm') }}</button>
                                <span class="ajax-loading"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="fee_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('vendor.order.customize') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Fee') }}</h5>
                                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">{{ __('Enter amount') }}</label>
                                        <input type="text" class="form-control inputFieldDesign positive-float-number" required name="amount">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">{{ __('Type') }}</label>
                                        <select class="form-control" name="fee_type">
                                            <option value="fixed">{{ __('Fixed') }}</option>
                                            <option value="percent">{{ __('Percentage') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">{{ __('Remarks') }}</label>
                                        <input type="text" class="form-control inputFieldDesign" name="remarks">
                                    </div>
                                    <div class="mt-12">
                                        <span class="badge badge-warning ltr:me-1 rtl:ms-1">{{ __('Note') }}!</span>
                                        <span>{{ __('Amount will apply based on grand total.') }}</span>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="add_fee">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" data-task="" class="btn custom-btn-submit">{{ __('Save') }}</button>
                                <span class="ajax-loading"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add_tax_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('vendor.order.customize') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Tax') }}</h5>
                                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure want to add tax?') }}
                                <input type="hidden" name="action" value="add_tax">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" data-task="" class="btn custom-btn-submit">{{ __('Yes, Confirm') }}</button>
                                <span class="ajax-loading"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="coupon_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('vendor.order.customize') }}" method="post">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteLabel">{{ __('Coupon') }}</h5>
                                <a type="button" aria-hidden="true" class="close h5" data-bs-dismiss="modal" aria-label="Close">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="control-label require">{{ __('Enter coupon') }}</label>
                                        <input type="text" class="form-control inputFieldDesign" required name="coupon">
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="add_coupon">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="py-2.5 custom-btn-cancel" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" data-task="" class="btn custom-btn-submit">{{ __('Save') }}</button>
                                <span class="ajax-loading"></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        
    </div>
@endsection

@section('js')
    <script>
        'use strict';
        var orderId = "{{ $order->id }}";
        var paymentStatus = "{{ $order->payment_status }}";
        var finalOrderStatus = "{{ $finalOrderStatus }}";
        var orderUrl = "{{ route('vendorOrder.update') }}";
        var vendorId = "{{ auth()->user()->vendor()->vendor_id }}";
        var orderView = "vendor";
        var customProviderImage = "{{ asset(defaultImage('default')) }}";
        var GLOBAL_URL = "{{URL::to('/')}}";
        var ADMIN_URL = SITE_URL;
        var SITE_URL = "{{ URL::to('/') }}";

        let oldCountry = "{!! $billingAddress->country ?? 'null' !!}";
        let oldState = "{!! $billingAddress->state ?? 'null' !!}";
        let oldCity = "{!! $billingAddress->city ?? 'null' !!}";

        let oldShipCountry = "{!! $shippingAddress->country ?? 'null' !!}";
        let oldShipState = "{!! $shippingAddress->state ?? 'null' !!}";
        let oldShipCity = "{!! $shippingAddress->city ?? 'null' !!}";
        let userAddressUrl = "{{ route('vendor.order.user.address') }}";
        var orderCustomizeUrl = "{{ route('vendor.order.customize') }}";
        var currentUrl = '{{ route('vendorOrder.view', $order->id) }}';
    </script>
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <!-- select2 JS -->
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/invoice.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/order.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/address.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('/public/dist/js/custom/site/invoice_edit.min.js') }}"></script>
@endsection
