@extends('admin.layouts.app')
@section('page_title', __('Address Settings'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="address-settings-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-lg-3 col-12 z-index-10 ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5>{{ __('Address') }}</h5>
                        </div>
                        <div class="card-block table-border-style pb-0">
                            <form action="{{ route('address.setting.index') }}" method="post" class="form-horizontal"
                                id="address_setting_form">
                                @csrf
                                <div class="card-body p-0">
                                    @php
                                        $fields = [
                                            __('First Name') => [
                                                'visible' => 'address_first_name_visible',
                                                'required' => 'address_first_name_required',
                                                'default_required_value' => 1
                                            ],
                                            __('Last Name') => [
                                                'visible' => 'address_last_name_visible',
                                                'required' => 'address_last_name_required',
                                                'default_required_value' => 0
                                            ],
                                            __('Company Name') => [
                                                'visible' => 'address_company_name_visible',
                                                'required' => 'address_company_name_required',
                                                'default_required_value' => 0
                                            ],
                                            __('Phone Number') => [
                                                'visible' => 'address_phone_visible',
                                                'required' => 'address_phone_required',
                                                'default_required_value' => 1
                                            ],
                                            __('Email Address') => [
                                                'visible' => 'address_email_address_visible',
                                                'required' => 'address_email_address_required',
                                                'default_required_value' => 0
                                            ],
                                            __('Street Address 1') => [
                                                'visible' => 'address_street_address_1_visible',
                                                'required' => 'address_street_address_1_required',
                                                'default_required_value' => 1
                                            ],
                                            __('Street Address 2') => [
                                                'visible' => 'address_street_address_2_visible',
                                                'required' => 'address_street_address_2_required',
                                                'default_required_value' => 0
                                            ],
                                            __('Country') => [
                                                'visible' => 'address_country_visible',
                                                'required' => 'address_country_required',
                                                'default_required_value' => 1
                                            ],
                                            __('State') => [
                                                'visible' => 'address_state_visible',
                                                'required' => 'address_state_required',
                                                'default_required_value' => 1
                                            ],
                                            __('City') => [
                                                'visible' => 'address_city_visible',
                                                'required' => 'address_city_required',
                                                'default_required_value' => 1
                                            ],
                                            __('Zip Code') => [
                                                'visible' => 'address_zip_visible',
                                                'required' => 'address_zip_required',
                                                'default_required_value' => 0
                                            ],
                                            __('Type of place') => [
                                                'visible' => 'address_type_of_place_visible',
                                                'required' => 'address_type_of_place_required',
                                                'default_required_value' => 1
                                            ]
                                        ];
                                    @endphp
                                    
                                    @foreach($fields as $key => $value)
                                        <div class="form-group row mb-1">
                                            <label class="col-4 control-label"
                                                for="{{ $value['visible'] }}">{{ $key }}</label>
                                            <div class="col-6">
                                                <div class="d-flex field-parent">
                                                    <input type="hidden" name="{{ $value['visible'] }}" value="0">
                                                    <div class="switch switch-bg d-inline">
                                                        <input type="checkbox" class="visible"
                                                            value="1" name="{{ $value['visible'] }}"
                                                            id="{{ $value['visible'] }}" {{ preference($value['visible'], 1) ? 'checked' : '' }}>
                                                        <label for="{{ $value['visible'] }}" class="cr"></label>
                                                    </div>
                                                    <div class="mt-2 me-5">
                                                        <small>{{ __('Visible') }}</small>
                                                    </div>
                                                    
                                                    <input type="hidden" name="{{ $value['required'] }}" value="0">
                                                    <div class="switch switch-bg d-inline">
                                                        <input type="checkbox" class="required"
                                                            value="1" name="{{ $value['required'] }}"
                                                            id="{{ $value['required'] }}"
                                                                {{ preference($value['required'], $value['default_required_value']) ? 'checked' : '' }}
                                                                {{ preference($value['visible'], 1) ? '' : 'disabled' }}>
                                                        <label for="{{ $value['required'] }}" class="cr"></label>
                                                    </div>
                                                    <div class="mt-2">
                                                        <small>{{ __('Required') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="card-footer p-0">
                                        <div class="form-group row mb-0">
                                            <label for="btn_save" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left"
                                                    id="footer-btn">
                                                    {{ __('Save') }}
                                                </button>
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
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/address-setting.min.js') }}"></script>
@endsection
