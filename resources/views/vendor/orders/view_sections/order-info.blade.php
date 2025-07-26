<div class="card-block">
    <div class="row invoive-info">
        <div class="col-md-4 col-sm-6">

            <div class="row">
                <div class="col-md-10">
                    <h6>{{ __('Order Date') }}:</h6>
                    <span>{{ $order->order_date }}</span>
                </div>
                <div class="col-md-10 mt-2">
                    <h6>{{ __('Status') }}:</h6>

                    @if($order->is_delivery == 1)
                        <span  class="font-bold">{{ __('Completed') }}</span>
                    @else
                        <span>{{ $order->orderStatus->name }}</span>
                    @endif
                </div>
                <div class="col-md-10 mt-2">
                    <h6>{{ __('Customers') }}:</h6>
                   <input type="hidden" id="user_id" value="{{ $order->user_id }}">
                   <span> {{ optional($order->user)->name ?? __('Guest') }}</span>
                </div>
            </div>

        </div>
        <div class="col-md-4 col-sm-6 invoice-client-info">
            <div class="row">
                <div class="col-md-10">
                    <h6 class="billing">{{ __('Billing Address') }}:</h6>
                    @if(preference('order_address_edit') == 1)
                        @if(!is_null($order->user_id) && $order->showBillingAddress())
                            <a href="javascript:void(0)" id="load_billing_address" class="display_none text-info">
                                <small>{{ __('Load Billing address') }}</small>
                            </a>
                        @endif
                    @endif
                </div>
                @if(preference('order_address_edit') == 1)
                <div class="col-md-2">
                    <a href="javascript:void(0)" id="billing_address_edit">
                        <i class="feather icon-edit-1"></i>
                    </a>
                </div>
                @endif
            </div>

            <div class="billing-information-container" id="billing_address">
                @if (preference('address_first_name_visible', 1) || preference('address_last_name_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Name') }}:
                        <span> 
                        @if(preference('address_first_name_visible', 1))
                                {{ $billingAddress->first_name }}
                            @endif
                            @if(preference('address_last_name_visible', 1))
                                {{ $billingAddress->last_name }}
                            @endif
                    </span>
                    </p>
                @endif
                @if (preference('address_email_address_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Email') }}: <span><a class="text-secondary" href="mailto:{{ $billingAddress->email }}" target="_top"> {{ $billingAddress->email }} </a></span> </p>
                @endif
                @if (preference('address_phone_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Phone') }}: <span> {{ $billingAddress->phone }} </span> </p>
                @endif
                @if(preference('address_street_address_1_visible', 1) || preference('address_street_address_2_visible', 1) || preference('address_city_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Address') }}: <span> 
                        @if(preference('address_street_address_1_visible', 1))
                                {{ $billingAddress->address_1 }}
                            @endif
                            @if(preference('address_street_address_2_visible', 1))
                                {{ !empty($billingAddress->address_2) ? ", " . $billingAddress->address_2 : '' }},
                            @endif
                            @if(preference('address_city_visible', 1))
                                {{ ucfirst($billingAddress->city) }}
                            @endif
                    </span>
                    </p>
                @endif
                @if(preference('address_zip_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Postcode') . "/" . __('ZIP') }}: <span> {{ $billingAddress->zip }} </span> </p>
                @endif
                @if(preference('address_state_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('State') }}: <span> {{ \Modules\GeoLocale\Entities\Division::getStateNameByCountryStateCode($billingAddress->country, $billingAddress->state) }} </span> </p>
                @endif
                @if(preference('address_country_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Country') }}: <span> {{ \Modules\GeoLocale\Entities\Country::getNameByCode($billingAddress->country) }} </span> </p>
                @endif
            </div>
            @if(preference('order_address_edit') == 1)
                <div class="address-form display_none" id="billing_address_edit_section">
                    <div id="addressForm">
                        <div class="row">
                            @if(preference('address_first_name_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_first_name_required', 1) ? 'require' : '' }}">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_first_name_required', 1) ? 'has_require' : '' }}" name="first_name" id="first_name" value="{{ $billingAddress->first_name }}">
                                </div>
                            @endif
                            @if(preference('address_last_name_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_last_name_required', 0) ? 'require' : '' }}">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_last_name_required', 0) ? 'has_require' : '' }}" name="last_name" id="last_name" value="{{ $billingAddress->last_name }}">
                                </div>
                            @endif
                            @if(preference('address_company_name_visible', 1))
                                <div class="col-md-12">
                                    <label class="control-label {{ preference('address_company_name_required', 0) ? 'require' : '' }}">{{ __('Company name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_company_name_required', 0) ? 'has_require' : '' }}" name="company_name" id="company_name" value="{{ $billingAddress->company_name }}">
                                </div>
                            @endif
                            @if(preference('address_phone_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_phone_required', 1) ? 'require' : '' }}">{{ __('Phone number') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_phone_required', 1) ? 'has_require' : '' }}" name="phone" id="phone" value="{{ $billingAddress->phone }}">
                                </div>
                            @endif
                            @if(preference('address_email_address_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_email_address_required', 0) ? 'require' : '' }}">{{ __('Email Address') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_email_address_required', 0) ? 'has_require' : '' }}" name="email" id="email" value="{{ $billingAddress->email }}">
                                </div>
                            @endif
                            @if(preference('address_street_address_1_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_street_address_1_required', 1) ? 'require' : '' }}">{{ __('Address') }}1</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_street_address_1_required', 1) ? 'has_require' : '' }}" name="address_1" id="address_1" value="{{ $billingAddress->address_1 }}">
                                </div>
                            @endif
                            @if(preference('address_street_address_2_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_street_address_2_required', 0) ? 'require' : '' }}">{{ __('Address') }}2</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_street_address_2_required', 0) ? 'has_require' : '' }}" name="address_2" id="address_2" value="{{ $billingAddress->address_2 }}">
                                </div>
                            @endif
                            @if(preference('address_country_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_country_required', 1) ? 'require' : '' }}">{{ __('Country') }}</label>
                                    <select name="country" id="country" class="form-control select2 addressSelect {{ preference('address_country_required', 1) ? 'has_require' : '' }}">
                                        <option value="">{{ __('Select One') }}</option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_state_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_state_required', 1) ? 'require' : '' }}">{{ __('State') }}</label>
                                    <select name="state" id="state" class="form-control select2 addressSelect {{ preference('address_state_required', 1) ? 'has_require' : '' }}">
                                        <option value="">{{ __('Select One') }}</option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_city_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_city_required', 1) ? 'require' : '' }}">{{ __('City') }}</label>
                                    <select name="city" id="city" class="form-control select2 addressSelect {{ preference('address_city_required', 1) ? 'has_require' : '' }}">
                                        <option value="{{ $billingAddress->city }}">
                                            {{ $billingAddress->city }}
                                        </option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_zip_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_zip_required', 1) ? 'require' : '' }}">{{ __('Post Code/Zip') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_zip_required', 1) ? 'has_require' : '' }}" name="zip" id="zip" value="{{ $billingAddress->zip }}">
                                </div>
                            @endif
                            @if(preference('address_type_of_place_visible', 1))
                                <label class="control-label {{ preference('address_type_of_place_required', 1) ? 'require' : '' }}">{{ __('Type Of Your Place') }}</label>
                                <div class="col-md-6">
                                    <div class="form-group d-inline">
                                        <div class="radio radio-warning radio-fill d-inline">
                                            <input type="radio" name="type_of_place" class="{{ preference('address_type_of_place_required', 1) ? 'checked_require' : '' }}" id="radio-w-infill-1" {{ $billingAddress->type_of_place == 'home' ? 'checked' : '' }} value="home">
                                            <label for="radio-w-infill-1" class="cr">{{ __('Home') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-inline">
                                        <div class="radio radio-warning radio-fill d-inline">
                                            <input type="radio" name="type_of_place" id="radio-w-infill-2" class="{{ preference('address_type_of_place_required', 1) ? 'checked_require' : '' }}" {{ $billingAddress->type_of_place == 'office' ? 'checked' : '' }} value="office">
                                            <label for="radio-w-infill-2" class="cr">{{ __('Office') }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="row">
                <div class="col-md-10">
                    <h6 class="shipping">{{ __('Shipping Address') }}:</h6>
                    @if(preference('order_address_edit') == 1 && $order->showBillingAddress())
                        <a href="javascript:void(0)" id="copy_billing_address" class="display_none text-info">
                            <small>{{ __('Copy billing address') }}</small>
                        </a>
                    @endif
                </div>
                @if(preference('order_address_edit') == 1)
                <div class="col-md-2">
                    <a href="javascript:void(0)" id="shipping_address_edit">
                        <i class="feather icon-edit-1"></i>
                    </a>
                </div>
                @endif
            </div>
            <div class="billing-information-container" id="shipping_address">
                @if (preference('address_first_name_visible', 1) || preference('address_last_name_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Name') }}:
                        <span> 
                        @if (preference('address_first_name_visible', 1))
                                {{ $shippingAddress->first_name }}
                            @endif
                            @if (preference('address_last_name_visible', 1))
                                {{ $shippingAddress->last_name }}
                            @endif
                    </span>
                    </p>
                @endif
                @if (preference('address_email_address_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Email') }}: <span><a class="text-secondary" href="mailto:{{ $shippingAddress->email }}" target="_top"> {{ $shippingAddress->email }} </a></span> </p>
                @endif
                @if (preference('address_email_address_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Phone') }}: <span> {{ $shippingAddress->phone }} </span> </p>
                @endif
                @if(preference('address_street_address_1_visible', 1) || preference('address_street_address_2_visible', 1) || preference('address_city_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Address') }}:
                        <span> 
                        @if(preference('address_street_address_1_visible', 1))
                                {{ $shippingAddress->address_1 }}
                            @endif
                            @if(preference('address_street_address_2_visible', 1))
                                {{ !empty($shippingAddress->address_2) ? ", " . $shippingAddress->address_2 : '' }},
                            @endif
                            @if(preference('address_city_visible', 1))
                                {{ ucfirst($shippingAddress->city) }}
                            @endif
                    </span>
                    </p>
                @endif
                @if(preference('address_zip_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Postcode') . "/" . __('ZIP') }}: <span> {{ $shippingAddress->zip }} </span> </p>
                @endif
                @if(preference('address_state_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('State') }}: <span> {{ \Modules\GeoLocale\Entities\Division::getStateNameByCountryStateCode($shippingAddress->country, $shippingAddress->state) }} </span> </p>
                @endif
                @if(preference('address_country_visible', 1))
                    <p class="m-0 m-t-10"> {{ __('Country') }}: <span> {{ \Modules\GeoLocale\Entities\Country::getNameByCode($shippingAddress->country) }} </span> </p>
                @endif
            </div>
            @if(preference('order_address_edit') == 1)
                <div class="shipping-address-form display_none" id="shipping_address_edit_section">
                    <div id="ShippingaddressForm">
                        <div class="row">
                            @if(preference('address_first_name_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_first_name_required', 1) ? 'require' : '' }}">{{ __('First Name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_first_name_required', 1) ? 'shipping_has_require' : '' }}" name="shipping_address_first_name" id="shipping_address_first_name" value="{{ $shippingAddress->first_name }}">
                                </div>
                            @endif
                            @if(preference('address_last_name_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_last_name_required', 0) ? 'require' : '' }}">{{ __('Last Name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_last_name_required', 0) ? 'shipping_has_require' : '' }}" name="shipping_address_last_name" id="shipping_address_last_name" value="{{ $shippingAddress->last_name }}">
                                </div>
                            @endif
                            @if(preference('address_company_name_visible', 1))
                                <div class="col-md-12">
                                    <label class="control-label {{ preference('address_company_name_required', 0) ? 'require' : '' }}">{{ __('Company name') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_company_name_required', 0) ? 'shipping_has_require' : '' }}" name="shipping_address_company_name" id="shipping_address_company_name" value="{{ $shippingAddress->company_name }}">
                                </div>
                            @endif
                            @if(preference('address_phone_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_phone_required', 1) ? 'require' : '' }}">{{ __('Phone number') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_phone_required', 1) ? 'shipping_has_require' : '' }}" name="shipping_address_phone" id="shipping_address_phone" value="{{ $shippingAddress->phone }}">
                                </div>
                            @endif
                            @if(preference('address_email_address_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_email_address_required', 0) ? 'require' : '' }}">{{ __('Email Address') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_email_address_required', 0) ? 'shipping_has_require' : '' }}" name="shipping_address_email" id="shipping_address_email" value="{{ $shippingAddress->email }}">
                                </div>
                            @endif
                            @if(preference('address_street_address_1_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_street_address_1_required', 1) ? 'require' : '' }}">{{ __('Address') }}1</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_street_address_1_required', 1) ? 'shipping_has_require' : '' }}" name="shipping_address_address_1" id="shipping_address_address_1" value="{{ $shippingAddress->address_1 }}">
                                </div>
                            @endif
                            @if(preference('address_street_address_2_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_street_address_2_required', 0) ? 'require' : '' }}">{{ __('Address') }}2</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_street_address_2_required', 0) ? 'shipping_has_require' : '' }}" name="shipping_address_address_2" id="shipping_address_address_2" value="{{ $shippingAddress->address_2 }}">
                                </div>
                            @endif
                            @if(preference('address_country_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_country_required', 1) ? 'require' : '' }}">{{ __('Country') }}</label>
                                    <select name="shipping_address_country" id="shipping_country" class="form-control select2 addressSelect {{ preference('address_country_required', 1) ? 'shipping_has_require' : '' }}">
                                        <option value="">{{ __('Select One') }}</option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_state_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_state_required', 1) ? 'require' : '' }}">{{ __('State') }}</label>
                                    <select name="shipping_address_state" id="shipping_state" class="form-control select2 addressSelect {{ preference('address_state_required', 1) ? 'shipping_has_require' : '' }}">
                                        <option value="">{{ __('Select One') }}</option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_city_visible', 1))
                                <div class="col-md-6 validSelect">
                                    <label class="control-label {{ preference('address_city_required', 1) ? 'require' : '' }}">{{ __('City') }}</label>
                                    <select name="shipping_address_city" id="shipping_city" class="form-control select2 addressSelect {{ preference('address_city_required', 1) ? 'shipping_has_require' : '' }}">
                                        <option value="">{{ __('Select One') }}</option>
                                    </select>
                                </div>
                            @endif
                            @if(preference('address_zip_visible', 1))
                                <div class="col-md-6">
                                    <label class="control-label {{ preference('address_zip_required', 1) ? 'require' : '' }}">{{ __('Post Code/Zip') }}</label>
                                    <input type="text" class="form-control inputFieldDesign {{ preference('address_zip_required', 1) ? 'shipping_has_require' : '' }}" name="shipping_address_zip" id="shipping_address_zip" value="{{ $shippingAddress->zip }}">
                                </div>
                            @endif
                            @if(preference('address_type_of_place_visible', 1))
                                <label class="control-label {{ preference('address_type_of_place_required', 1) ? 'require' : '' }}">{{ __('Type Of Your Place') }}</label>
                                <div class="col-md-6">
                                    <div class="form-group d-inline">
                                        <div class="radio radio-warning radio-fill d-inline">
                                            <input type="radio" class="{{ preference('address_type_of_place_required', 1) ? 'shipping_checked_require' : '' }}" name="shipping_address_type_of_place" id="shipping_radio-w-infill-1" value="home" {{ $shippingAddress->type_of_place == 'home' ? 'checked' : ''  }}>
                                            <label for="shipping_radio-w-infill-1" class="cr">{{ __('Home') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group d-inline">
                                        <div class="radio radio-warning radio-fill d-inline">
                                            <input type="radio" class="{{ preference('address_type_of_place_required', 1) ? 'shipping_checked_require' : '' }}" name="shipping_address_type_of_place" id="shipping_radio-w-infill-2" value="office" {{ $shippingAddress->type_of_place == 'office' ? 'checked' : ''  }}>
                                            <label for="shipping_radio-w-infill-2" class="cr">{{ __('Office') }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
