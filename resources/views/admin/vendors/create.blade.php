@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Vendor')]))

@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/intl-tel-input/intlTelInput.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="vendor-add-container">
        <div class="card">
            <div class="card-header">
                <h5> <a href="{{ route('vendors.index') }}">{{ __('Vendors') }} </a>
                    >>{{ __('Create :x', ['x' => __('Vendor')]) }}</h5>
            </div>
            <form action="{{ route('vendors.store') }}" method="post" id="vandorAdd"
                class="col-sm-12" enctype="multipart/form-data"
                onsubmit="return passwordValidation()">
                
                <div class="card-body">
                    @csrf
                    <div class="col-sm-9 mt-2">
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 control-label">{{ __('Assign User') }}
                            </label>
                            <div class="col-sm-9">
                                <select class="form-control select-user select2 sl_common_bx"
                                    id="user_id" name="user_id">
                                    {{-- User load by ajax --}}
                                </select>
                                <small class="form-text text-muted">{{ __("Select the user responsible for managing the vendor account. The selected user will be designated as the owner of the vendor, ensuring they have the necessary permissions.") }}</small>
                                <small class="form-text text-muted">{{ __("If you do not select a user, a new user will be created with the email account provided.") }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 control-label require">{{ __('Name') }}
                            </label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{ __('Name') }}"
                                    class="form-control inputFieldDesign" id="name" name="name"
                                    value="{{ old('name') }}" required maxlength="80"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                <small class="form-text text-muted">{{ __("This name will be used in all documents like pdf and communications. The name will be publicly visible. Example Minimal Lifestyle, Holistic Store.") }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                class="col-sm-3 control-label require">{{ __('Email') }}</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control inputFieldDesign bg-white"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="{{ __('Email') }}" readonly
                                    onfocus="this.removeAttribute('readonly');" required maxlength="100"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password"
                                class="col-sm-3 control-label require">{{ __('Password') }}</label>
                            <div class="col-sm-9 password-input">
                                <input type="password" placeholder="{{ __('Password') }}"
                                    class="form-control password-validation inputFieldDesign" id="password"
                                    name="password" required maxlength="190"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                <div class="password-validation-error mt-1"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone"
                                class="col-sm-3 control-label require">{{ __('Phone') }}</label>
                            <div class="col-sm-9">
                                <input type="text"
                                    class="form-control phone-number inputFieldDesign" id="phone"
                                    name="phone" value="{{ old('phone') }}" required maxlength="15"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role_id"
                                class="col-sm-3 control-label require">{{ __('Role') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2-hide-search inputFieldDesign"
                                    name="role_ids[]" id="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="formal_name"
                                class="col-sm-3 control-label">{{ __('Formal Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control inputFieldDesign"
                                    id="formal_name" name="formal_name"
                                    placeholder="{{ __('Formal Name') }}" maxlength="80"
                                    value="{{ old('formal_name') }}">
                                <small>{{ __("This name should be the official, legal name registered with relevant business authorities. Accuracy in providing the formal name is crucial for legal and administrative purposes.") }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alias"
                                class="col-sm-3 control-label require">{{ __('Alias') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control inputFieldDesign"
                                    id="alias" name="alias" placeholder="{{ __('Alias') }}"
                                    value="{{ old('alias') }}" required maxlength="45"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <small>{{ __("It will be used as the subdomain of the default shop.") }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address"
                                class="col-sm-3 control-label require">{{ __('Address') }}</label>
                            <div class="col-sm-9">
                                <textarea placeholder="{{ __('Address') }}" id="address" class="form-control" name="address" required
                                    minlength="5" data-min-length="{{ __('Address should be atleast 5 characters.') }}" maxlength="191"
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alias"
                                class="col-sm-3 control-label">{{ __('Website') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control inputFieldDesign"
                                    id="website" name="website" placeholder="{{ __('Website') }}"
                                    maxlength="255"
                                    pattern="(http[s]?:\/\/)?(www\.)?([\.]?[a-z]+[a-zA-Z0-9\-]{1,})?[\.]?[a-z]+[a-zA-Z0-9\-]+\.[a-zA-Z]{2,5}([\.]?[a-zA-Z]{2,5})?"
                                    data-pattern="{{ __('Enter a valid :x.', ['x' => __('URL')]) }}"
                                    value="{{ old('website') }}">
                            </div>
                        </div>
                        @if (!empty($commission) && $commission->is_active == 1)
                            <div class="form-group row">
                                <label for="sell_commissions"
                                    class="col-sm-3 control-label">{{ __('Commission') }}(%)</label>
                                <div class="col-sm-9">
                                    <input type="number"
                                        class="form-control positive-float-number inputFieldDesign"
                                        id="sell_commissions" name="sell_commissions"
                                        value="{{ old('sell_commissions') }}" max="100"
                                        data-max="{{ __('The value not more than be :x', ['x' => 100]) }}">
                                    <small class="form-text text-muted">{!! __("Enter the commission percentage agreed upon with the vendor. When customer purchase any product of the vendor, commission will be cut off according to the percentage. To know more about commission, please visit the :x page.", ['x' => '<a class="text-primary" href="https://docs.martvill.techvill.net/admin/commission" target="_blank">'.__("Commission").'</a>' ]) !!}</small>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="Status"
                                class="col-sm-3 control-label">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group row preview-parent">
                            <label class="col-sm-3 control-label">{{ __('Logo') }}</label>
                            <div class="col-sm-9">
                                <div class="custom-file position-relative media-manager-img" data-val="single"
                                    data-returntype="ids" id="image-status">
                                    <input class="custom-file-input is-image form-control inputFieldDesign"
                                        name="vendor_logo">
                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                </div>
                                <div class="preview-image" id="#">
                                    <!-- img will be shown here -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="divNote">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id='note_txt_1'>
                                <small class="form-text text-muted">
                                    {{ __("The logo should be a clear and high-quality image that represents the brand effectively. This logo will be publicly visible on the platform, so ensure it aligns with the brand's identity and standards.") }}

                                    <li>{{ __("Allowed File Extensions: :x", ['x' => 'jpg, png, gif, bmp']) }}</li>
                                    <li>{{ __("Maximum File Size: :x MB", ['x' => preference('file_size')]) }}</li>
                                    <li>{{ __("Recommended Size: :x or any square size", ['x' => '300x300']) }} </li>
                                </small>
                            </div>
                        </div>
                        <div class="form-group row preview-parent">
                            <label class="col-sm-3 control-label">{{ __('Cover Photo') }}</label>
                            <div class="col-sm-9">
                                <div class="custom-file position-relative media-manager-img" data-val="single"
                                    data-returntype="ids" id="image-status">
                                    <input class="custom-file-input is-image form-control"
                                        name="cover_photo">
                                    <label class="custom-file-label overflow_hidden d-flex align-items-center"
                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                </div>
                                <div class="preview-image" id="#">
                                    <!-- img will be shown here -->
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="divNote">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9" id='note_txt_1'>
                                <small class="form-text text-muted">
                                    {{ __("The cover photo should be visually appealing and represent the brand effectively. This image will be prominently displayed on the seller/vendor's profile page.") }}

                                    <li>{{ __("Allowed File Extensions: :x", ['x' => 'jpg, png, gif, bmp']) }}</li>
                                    <li>{{ __("Maximum File Size: :x MB", ['x' => preference('file_size')]) }}</li>
                                    <li>{{ __("Recommended Size: :x pixels or a similar aspect ratio", ['x' => '826x350']) }} </li>
                                </small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Status"
                                class="col-sm-3 control-label require">{{ __('Status') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control select2-hide-search inputFieldDesign"
                                    name="status" id="status">
                                    <option value="Pending"
                                        {{ old('status') == 'Pending' || preference('vendor_default_signup_status') == 'Pending' ? 'selected' : '' }}>
                                        {{ __('Pending') }}</option>
                                    <option value="Active"
                                        {{ old('status') == 'Active' || preference('vendor_default_signup_status') == 'Active' ? 'selected' : '' }}>
                                        {{ __('Active') }}</option>
                                    <option value="Inactive"
                                        {{ old('status') == 'Inactive' || preference('vendor_default_signup_status') == 'Inactive' ? 'selected' : '' }}>
                                        {{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-3 ltr:ms-1 rtl:me-1">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9 px-0">
                                <div class="checkbox checkbox-primary checkbox-fill d-inline">
                                    <input type="checkbox" class="form-control" name="send_mail"
                                        id="checkbox-p-fill-1">
                                    <label for="checkbox-p-fill-1"
                                        class="cr">{{ __('Send email to the user') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer form-footer">
                    <div class="col-sm-9 text-right">
                        <a href="{{ route('vendors.index') }}"
                            class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                        <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                            id="spinnerText">{{ __('Create') }}</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('mediamanager::image.modal_image')
@endsection
@php
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array('UPPERCASE', $conditions);
        $lowercase = in_array('LOWERCASE', $conditions);
        $number = in_array('NUMBERS', $conditions);
        $symbol = in_array('SYMBOLS', $conditions);
    }
@endphp
@section('js')
    <script>
        'use strict';
        var uppercase = "{!! $uppercase !!}";
        var lowercase = "{!! $lowercase !!}";
        var number = "{!! $number !!}";
        var symbol = "{!! $symbol !!}";
        var length = "{!! $length !!}";
        var currentUrl = "{!! url()->full() !!}";
        var loginNeeded = "{!! session('loginRequired') ? 1 : 0 !!}";
        const utilJs = "{{ asset('public/dist/js/intl-tel-input/utils.min.js') }}";
    </script>
    
    <script src="{{ asset('public/dist/js/intl-tel-input/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/set-dial-code.min.js') }}"></script>
    
    <script src="{{ asset('public/dist/js/custom/vendors.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
