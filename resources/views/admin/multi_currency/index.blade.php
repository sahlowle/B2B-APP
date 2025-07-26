@extends('admin.layouts.app')
@section('page_title', __('Currency Setting'))

@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/css/product.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="card admin-panel-product-setting" id="currency-setting-container">
            {{-- Notification --}}
            <div class="col-md-12 no-print notification-msg-bar smoothly-hide">
                <div class="noti-alert pad">
                    <div class="alert bg-dark text-light m-0 text-center">
                        <span class="notification-msg"></span>
                    </div>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0"
                     aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none">
                        <div class="card-header p-t-20 border-bottom mb-2">
                            <h5>{{ __('Currency Settings') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <li>
                                <a class="nav-link text-left tab-name {{ session()->has('sub_menu') && session('sub_menu') == 'currency' || !session()->has('sub_menu') ? 'active' : '' }}" id="v-pills-multi_currency-tab" data-bs-toggle="pill"
                                   href="#v-pills-multi_currency" role="tab" aria-controls="v-pills-multi_currency"
                                   aria-selected="true" data-type="currency" data-id="{{ __('Multi Currency') }}">{{ __('Multi Currency') }}
                                </a>
                            </li>

                            <li>
                                <a class="nav-link text-left tab-name {{ session()->has('sub_menu') && session('sub_menu') == 'exchange' ? 'active' : '' }}" id="v-pills-lead-source-tab" data-bs-toggle="pill"
                                   href="#v-pills-exchange" role="tab" aria-controls="v-pills-exchange"
                                   aria-selected="true" data-type="exchange" data-id="{{ __('API Setup') }}">{{ __('API Setup') }}
                                </a>
                            </li>

                            <li>
                                <a class="nav-link text-left tab-name {{ session()->has('sub_menu') && session('sub_menu') == 'option' ? 'active' : '' }}" id="v-pills-option-tab" data-bs-toggle="pill"
                                   href="#v-pills-option" role="tab" aria-controls="v-pills-option"
                                   aria-selected="true" data-type="option" data-id="{{ __('Option') }}">{{ __('Option') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            @if(session('sub_menu') == 'exchange')
                                <h5 id="header_title">{{ __('API Setup') }}</h5>
                            @elseif(session('sub_menu') == 'option')
                                <h5 id="header_title">{{ __('Option') }}</h5>
                            @else
                                <h5 id="header_title">{{ __('Multi Currency') }}</h5>
                            @endif
                            <div class="card-header-right">
                                <a href="javascript:void(0)"  id="add_currency" data-bs-toggle="modal" data-bs-target="#currency-modal" data-action="{{ route('settings.currency.store') }}" class="btn btn-outline-primary custom-btn-small {{ session()->has('sub_menu') && session('sub_menu') == 'currency' || !session()->has('sub_menu') ? '' : 'display-none' }}">
                                    <span class="fa fa-plus">&nbsp;</span>{{ __('Add :x', ['x' => __('Currency')]) }}
                                </a>
                                <a href="javascript:void(0)" id="update_exchange_all" data-action="{{ route('settings.currency.exchange-update') }}" class="btn btn-outline-primary custom-btn-small {{ session()->has('sub_menu') && session('sub_menu') == 'currency' || !session()->has('sub_menu') ? '' : 'display-none' }}">
                                    <span class="feather icon-download-cloud custom_loader">&nbsp;</span> {{ __('Update :x', ['x' => __('All Exchange Rate')]) }}
                                </a>
                            </div>

                        </div>
                        <div class="tab-content shadow-none" id="topNav-v-pills-tabContent">

                            <div class="tab-pane fade parent {{ session()->has('sub_menu') && session('sub_menu') == 'currency' || !session()->has('sub_menu') ? 'active show' : '' }}" id="v-pills-multi_currency" role="tabpanel" aria-labelledby="v-pills-multi_currency-tab">


                                <div class="col-lg-12 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                                    <div class="card-body shadow-none table-border-style p-0">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover table-main" id="currencyDataTable">
                                                    <thead>
                                                    <tr>
                                                        <th class="align-middle">{{ __('Currency') }}</th>
                                                        <th class="align-middle">{{ __('Exchange rate') }}</th>
                                                        <th class="align-middle">{{ __('Custom Symbol') }}</th>
                                                        <th class="align-middle">{{ __('Decimal number') }}</th>
                                                        <th class="align-middle">{{ __('Last update') }}</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($multiCurrencies as $currency)
                                                        <tr>
                                                            <td class="align-middle">{{ $currency->currency->name }}</td>
                                                            <td class="align-middle" id="exchnage-rate-{{ $currency->id }}">{{ round($currency->exchange_rate, !empty(preference('exchange_rate_decimal')) ? preference('exchange_rate_decimal') : 2 )}}</td>
                                                            <td class="align-middle">{{ $currency->custom_symbol }}</td>
                                                            <td class="align-middle">{{ $currency->allow_decimal_number }}</td>
                                                            <td class="align-middle">{{ formatDate($currency->updated_at) }}</td>
                                                            <td class="text-right align-middle">

                                                                <a title="{{ __('Update Exchange Rate') }}" href="javascript:void(0)" class="action-icon update_api update_exchange_single mr-10p" data-id="{{ $currency->id }}" data-action="{{ route('settings.currency.exchange-update') }}">
                                                                    <i class="feather icon-download-cloud custom_loader_{{ $currency->id }}"></i>
                                                                </a>
                                                                
                                                                <a title="{{ __('Edit') }}" href="javascript:void(0)" class="action-icon edit_currency" data-bs-toggle="modal" data-bs-target="#currency-modal" id="{{ $currency->id }}" data-url="{{ route('settings.currency.edit', $currency->id) }}" data-action="{{ route('settings.currency.update', $currency->id) }}">
                                                                    <i class="feather icon-edit-1"></i>
                                                                </a>
                                                                &nbsp;
                                                                <form method="POST" action="{{ route('settings.currency.destroy', $currency->id) }}" accept-charset="UTF-8" id="delete-currency-{{ $currency->id }}" class="display_inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a title="{{ __('Delete') }}" class="action-icon delete_currency" data-id="{{ $currency->id }}" type="button" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-label="Delete"><i class="feather icon-trash"></i></a>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="currency-modal" class="modal fade display_none" role="dialog">
                                    <div class="modal-dialog modal-lg">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('Currency') }} &nbsp; </h4>
                                                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                                            </div>
                                            <form method="post" id="currency_form" class="form-horizontal">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="_method" value="" id="currency_method">

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label require" for="inputEmail3">{{ __('Currency') }}</label>

                                                        <div class="col-sm-9">
                                                            <select class="js-example-basic-single-1 form-control select2 sl_common_bx" name="currency_id" id="currency_id" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                @foreach($currencies as $currency)
                                                                 <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label" for="inputEmail3">{{ __('Exchange Rate') }}</label>

                                                        <div class="col-sm-9">
                                                            <input type="text" value="{{ old('exchange_rate') }}" class="form-control name inputFieldDesign positive-float-number" name="exchange_rate" id="exchange_rate" step="any">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label" for="inputEmail3">{{ __('Allow Decimal Number') }}</label>

                                                        <div class="col-sm-9">
                                                            <input type="text" value="{{ old('allow_decimal_number') }}" class="form-control name inputFieldDesign positive-int-number" name="allow_decimal_number" id="allow_decimal_number">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-3 control-label" for="inputEmail3">{{ __('Custom Symbol') }}</label>

                                                        <div class="col-sm-9">
                                                            <input type="text" value="{{ old('custom_symbol') }}" class="form-control name inputFieldDesign" name="custom_symbol" id="custom_symbol">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-between bg-light-gray">
                                                    <a href="javascript:void(0)" class="py-2 ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2 text-c-red" data-bs-dismiss="modal">{{ __('Cancel') }}</a>
                                                    <button type="submit" class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left">{{ __('Save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="tab-pane fade parent {{ session()->has('sub_menu') && session('sub_menu') == 'exchange' ? 'active show' : '' }}" id="v-pills-exchange" role="tabpanel" aria-labelledby="v-pills-exchange-tab">

                                <div class="col-lg-12 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                                    <div class="card-body shadow-none table-border-style p-0">
                                        <div class="row">

                                            <form action="{{ route('settings.currency.index') }}" method="post" class="form-horizontal">
                                                @csrf
                                                <div class="col-sm-12 margin-top-neg-30">
                                                    <div class="card-body table-border-style p-0">
                                                        <div class="border-bottom table-border-style p-0">
                                                            <div class="form-tabs">
                                                                <div class="tab-content box-shadow-unset px-0 py-2">
                                                                    <div class="tab-pane fade show active" id="home"
                                                                         role="tabpanel" aria-labelledby="home-tab">

                                                                        <input type="hidden" name="type" value="exchange">
                                                                        <div class="form-group row">
                                                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                                                <label class="col-sm-4 control-label text-left" for="exchange_resource"><b>{{ __('Exchange API') }}</b></label>
                                                                                <span>{{ __('Select which api resource you want to use for update exchange rate') }} <span id="exchange_url"></span></span>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center">
                                                                                <select class="form-control" name="exchange_resource" id="exchange_resource">
                                                                                    <option value="">{{ __('Select One') }}</option>
                                                                                    <option value="exchangerate-api" @selected(preference('exchange_resource') == 'exchangerate-api')>{{ __('Exchange Rate-Api') }}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                                                <label class="col-sm-4 control-label text-left" for="exchange_rate_decimal"><b>{{ __('Rate Decimal') }}</b></label>
                                                                                <span>{{ __('How many decimal digit will count while update exchange rate through API') }}</span>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center">
                                                                                <input class="form-control inputFieldDesign positive-int-number" type="text" name="exchange_rate_decimal" id="exchange_rate_decimal" value="{{ !is_null(preference('exchange_rate_decimal')) ? preference('exchange_rate_decimal') : '' }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                                                <label class="col-sm-4 control-label text-left" for="exchange_api_key"><b>{{ __('API Key') }}</b></label>
                                                                                <span>{{ __('API key for exchange rate') }} </span>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center">
                                                                                <input class="form-control inputFieldDesign" type="text" name="exchange_api_key" id="exchange_api_key" value="{{ !is_null(preference('exchange_api_key')) ? preference('exchange_api_key') : '' }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer p-0">
                                                            <div class="form-group row">
                                                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                                                <div class="col-sm-12">
                                                                    <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button" id="footer-btn">
                                                                        <span class="d-none product-spinner spinner-border spinner-border-sm text-secondary" role="status"></span>
                                                                        {{ __('Save') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade parent {{ session()->has('sub_menu') && session('sub_menu') == 'option' ? 'active show' : '' }}" id="v-pills-option" role="tabpanel" aria-labelledby="v-pills-option-tab">

                                <div class="col-lg-12 ltr:ps-1 ltr:ps-lg-0 rtl:pe-1 rtl:pe-lg-0">
                                    <div class="card-body shadow-none table-border-style p-0">
                                        <div class="row">

                                            <form action="{{ route('settings.currency.index') }}" method="post" class="form-horizontal">
                                                @csrf
                                                <div class="col-sm-12 margin-top-neg-30">
                                                    <div class="card-body table-border-style p-0">
                                                        <div class="border-bottom table-border-style p-0">
                                                            <div class="form-tabs">
                                                                <div class="tab-content box-shadow-unset px-0 py-2">
                                                                    <div class="tab-pane fade show active" id="home"
                                                                         role="tabpanel" aria-labelledby="home-tab">

                                                                        <input type="hidden" name="type" value="option">

                                                                        <div class="form-group row">
                                                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                                                <label for="enable_offered_price" class="control-label"><b>{{ __('Enable Multi-Currency') }}</b></label>
                                                                                <span>{{ __('This option will indicate multi-currency active or not.') }}</span>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center p-r-0 m-r-0">
                                                                                <div class="ltr:me-3 rtl:ms-3">
                                                                                    <input type="hidden" name="enable_multicurrency" value="0">
                                                                                    <div class="switch switch-bg d-inline">
                                                                                        <input type="checkbox" name="enable_multicurrency" class="checkActivity" id="enable_multicurrency" value="1" {{ preference('enable_multicurrency') == '1' ? 'checked' : '' }}>
                                                                                        <label for="enable_multicurrency" class="cr"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                                                <label for="enable_offered_price" class="control-label"><b>{{ __('Auto detect currency') }}</b></label>
                                                                                <span>{{ __('This option will indicate auto detect user country currency') }}</span>
                                                                            </div>
                                                                            <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center p-r-0 m-r-0">
                                                                                <div class="ltr:me-3 rtl:ms-3">
                                                                                    <input type="hidden" name="auto_detect_currency" value="0">
                                                                                    <div class="switch switch-bg d-inline">
                                                                                        <input type="checkbox" name="auto_detect_currency" class="checkActivity" id="auto_detect_currency" value="1" {{ preference('auto_detect_currency') == '1' ? 'checked' : '' }}>
                                                                                        <label for="auto_detect_currency" class="cr"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer p-0">
                                                            <div class="form-group row">
                                                                <label for="btn_save" class="col-sm-3 control-label"></label>
                                                                <div class="col-sm-12">
                                                                    <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button" id="footer-btn">
                                                                        <span class="d-none product-spinner spinner-border spinner-border-sm text-secondary" role="status"></span>
                                                                        {{ __('Save') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.includes.delete-modal')
    </div>
@endsection
@section('js')
    <script>
        var redirectRoute = '{{ route('settings.currency.index') }}'
    </script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/multi_currency.min.js') }}"></script>
@endsection
