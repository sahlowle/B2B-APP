@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Purchase')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Inventory/Resources/assets/css/purchase.min.css') }}">
@endsection

@section('content')

    <div class="col-sm-12" id="purchase-add-container">

        {{-- Notification --}}
        <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
            <div class="noti-alert pad">
                <div class="alert bg-dark text-light m-0 text-center">
                    <span class="notification-msg"></span>
                </div>
            </div>
        </div>
        
        <form action="{{ route('purchase.store') }}" method="post" id="purchase_form">
            @csrf
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('New Purchase') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Vendor') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="vendor_id" id="vendor_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select One')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Reference') }}</label>
                                    <div class="col-md-8">
                                        <input id="reference" class="form-control inputFieldDesign" value="{{ \Modules\Inventory\Entities\Purchase::getPurchaseReference() }}" type="text" readonly required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Supplier') }}
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="supplier_id" id="supplier_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select One')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label require">{{ __('Location') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="location_id" id="location_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="">{{ __('Select One')  }}</option>
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
                                            <option value="Cash On Delivery">{{ __('Cash On Delivery')  }}</option>
                                            <option value="Payment On receipt">{{ __('Payment On receipt')  }}</option>
                                            <option value="Payment In Advance">{{ __('Payment In Advance')  }}</option>
                                            <option value="Net 7">{{ __('Net 7')  }}</option>
                                            <option value="Net 15">{{ __('Net 15')  }}</option>
                                            <option value="Net 30">{{ __('Net 30')  }}</option>
                                            <option value="Net 45">{{ __('Net 45')  }}</option>
                                            <option value="Net 60">{{ __('Net 60')  }}</option>
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
                                                <option value="{{ $currency->id }}">{{ $currency->name  }}</option>
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
                                            <option value="4PX">{{ __('4PX')  }}</option>
                                            <option value="99 Minutos">{{ __('99 Minutos')  }}</option>
                                            <option value="Aeronet">{{ __('Aeronet')  }}</option>
                                            <option value="Ags">{{ __('Ags')  }}</option>
                                            <option value="Amazon Logistic UK">{{ __('Amazon Logistic UK')  }}</option>
                                            <option value="Amazon Logistic US">{{ __('Amazon Logistic US')  }}</option>
                                            <option value="DHL ecommerce">{{ __('DHL Ecommerce')  }}</option>
                                            <option value="DHL express">{{ __('DHL Express')  }}</option>
                                            <option value="DHL Ecommerce Asia">{{ __('DHL Ecommerce Asia')  }}</option>
                                            <option value="DHL Global Mail Asia">{{ __('DHL Global Mail Asia')  }}</option>
                                            <option value="DHL Sweden">{{ __('DHL Sweden')  }}</option>
                                            <option value="China Post">{{ __('China Post')  }}</option>
                                            <option value="Deliver It">{{ __('Deliver It')  }}</option>
                                            <option value="First Line">{{ __('First Line')  }}</option>
                                            <option value="Other">{{ __('Other')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Tracking number') }}
                                    </label>
                                    <div class="col-md-8">
                                        <input id="tracking_number" class="form-control inputFieldDesign" type="text" name="tracking_number" placeholder="{{ __('Tracking number') }}">
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
                        </div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table display_none" id="product-table">
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
                                        <input id="arrival_date" class="form-control inputFieldDesign" type="text" name="arrival_date">
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Note to Supplier') }}
                                    </label>
                                    <div class="col-md-8">
                                        <textarea placeholder="{{ __('Note') }}" rows="3" class="form-control" name="note" spellcheck="false"></textarea>
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
                                        <label class="col-form-label col-md-6" id="subTotalTax">0</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-6">{{ __('SubTotal') }}</label>
                                        <label class="col-form-label col-md-6" id="subTotalAmount">0</label>
                                    </div>
                                    <h4>{{ __('Cost Adjustment') }}</h4>
                                    <div class="form-group row">
                                        <label class="col-form-label col-md-6">{{ __('Shipping') }}</label>
                                        <label class="col-form-label col-md-6" id="cost_management_shipping">0</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-6">{{ __('Total') }}</label>
                                    <label class="col-form-label col-md-6" id="totalAmount">0</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 px-0 mt-3 mt-md-0">
                    <a href="{{ route('purchase.index') }}"
                       class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                    <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                            id="spinnerText">{{ __('Create') }}</span></button>
                </div>
            </div>
            @include('inventory::layouts.purchase_settings')
        </form>
    </div>

    @include('inventory::layouts.add_supplier')
    @include('inventory::layouts.add_location')
    
@endsection
@section('js')
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        var rowNo = 0;
        var totalAmount = 0;
        var addSupplierUrl = '{{ route('supplier.store') }}';
        var addLocation = '{{ route('location.store') }}'
        
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
        let url = "{{ URL::to('/') }}";
        var thousandSeparator = '{{ preference('thousand_separator') }}';
    </script>
     <script src="{{ asset('Modules/Inventory/Resources/assets/js/purchase.min.js?v=2.9') }}"></script>
    <script src="{{ asset('Modules/Inventory/Resources/assets/js/location.min.js') }}"></script>
@endsection
