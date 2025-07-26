@extends('vendor.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Staff')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/user-list.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="vendor-staff-add-container">
        <div class="card">
            <div class="card-body row ps-0">
                <div class="col-lg-3 col-12 z-index-10 pe-0">
                    @include('vendor.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ps-3 ps-lg-0 rtl:pe-0 pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom ps-3">
                            <div class="fw-bold text-dark">{{ __('Add New Staff') }}</div>
                        </div>
                        <div class="card-body table-border-style ltr:p-1 ltr:ps-md-3 rtl:pe-md-2 mb-3">
                            <form action="{{ route('vendor.staffs.store') }}" method="post" id="vendor-staff-store"
                                class="mt-1">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"
                                        class="col-sm-2 control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                    </label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Name') }}"
                                            class="form-control form-width inputFieldDesign" id="name"
                                            name="name" required minlength="3" value="{{ old('name') }}"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-sm-2 control-label require ltr:ps-3 rtl:pe-3">{{ __('Email') }}</label>
                                    <div class="col-sm-6">
                                        <input type="email"
                                            class="form-control form-width inputFieldDesign bg-white"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="{{ __('Email') }}" required
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}"
                                            readonly onfocus="this.removeAttribute('readonly');">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-sm-2 control-label require">{{ __('Password') }}</label>
                                    <div class="col-sm-6">
                                        <input type="password"
                                            class="form-control password-validation form-width inputFieldDesign"
                                            id="password" name="password" placeholder="{{ __('Password') }}"
                                            value="{{ old('password') }}" required minlength="5"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Password'), 'y' => 5]) }}">
                                        <span class="password-validation-error mt-1 d-block"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="role_id"
                                        class="col-sm-2 control-label require">{{ __('Role') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2-hide-search inputFieldDesign"
                                            name="role_ids[]" id="role_id" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Status"
                                        class="col-sm-2 control-label">{{ __('Status') }}</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2-hide-search inputFieldDesign"
                                            name="status" id="status">
                                            <option value="Pending"
                                                {{ old('status') == 'Pending' ? 'selected' : '' }}>
                                                {{ __('Pending') }}</option>
                                            <option value="Active"
                                                {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                {{ __('Active') }}</option>
                                            <option value="Inactive"
                                                {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                {{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="description"
                                        class="col-sm-2 control-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" placeholder="{{ __('Description') }}" class="form-control form-width" id="description"
                                            name="description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label
                                        class="col-sm-2 control-label">{{ __('Picture') }}</label>
                                    <div class="col-sm-6">
                                        <div class="custom-file position-relative" data-val="single"
                                            id="image-status">
                                            <input
                                                class="custom-file-input form-control d-none inputFieldDesign"
                                                name="attachments" id="validatedCustomFile" accept="image/*">
                                            <label
                                                class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                for="validatedCustomFile">{{ __('Upload image') }}</label>
                                        </div>
                                    </div>

                                    <div class="offset-sm-2 col-sm-6" id="img-container">
                                        <!-- img will be shown here -->
                                    </div>
                                </div>

                                <div class="col-sm-12 px-0 mt-3 mt-md-0">
                                    <a href="{{ route('vendor.staffs.index') }}"
                                        class="py-2 ltr:me-2 rtl:ms-2 custom-btn-cancel">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button class="btn py-2 custom-btn-submit" type="submit" id="submitBtn">
                                        <i
                                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i>
                                        <span id="spinnerText">
                                            {{ __('Create') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
    <script src="{{ asset('public/dist/js/custom/user.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
