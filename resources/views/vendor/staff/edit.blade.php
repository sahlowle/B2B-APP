@extends('vendor.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Staff')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/lightbox/css/lightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/MediaManager/Resources/assets/css/media-manager.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/user-list.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12" id="user-edit-container">
        <div class="card">
            <div class="card-body row ps-0">
                <div class="col-lg-3 col-12 z-index-10 pe-0">
                    @include('vendor.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ps-3 ps-lg-0 rtl:pe-0 pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom ps-3">
                            <div class="fw-bold text-dark">{{ __('Edit Staff') }} ({{ $staff->name }})</div>
                        </div>
                        <div class="card-body table-border-style ltr:p-1 ltr:ps-md-3 rtl:pe-md-2 mb-3">
                            <form action='{{ route('vendor.staffs.update', ['staff' => $staff->id]) }}' method="post"
                                class="mt-1" id="userEdit" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-sm-8 form-container order-2 order-md-1">
                                        <div class="form-group row">
                                            <label for="name"
                                                class="col-sm-3 control-label require ltr:ps-3 rtl:pe-3">{{ __('Name') }}
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" placeholder="{{ __('Name') }}"
                                                    class="form-control form-width inputFieldDesign" id="name"
                                                    name="name" required minlength="3"
                                                    value="{{ !empty(old('name')) ? old('name') : $staff->name }}"
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email"
                                                class="col-sm-3 control-label require ltr:ps-3 rtl:pe-3">{{ __('Email') }}</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control form-width inputFieldDesign"
                                                    id="email" name="email"
                                                    value="{{ !empty(old('email')) ? old('email') : $staff->email }}"
                                                    placeholder="{{ __('Email') }}" required
                                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                    data-type-mismatch="{{ __('Enter a valid :x.', ['x' => strtolower(__('Email'))]) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role_id"
                                                class="col-sm-3 control-label require ltr:ps-3 rtl:pe-3">{{ __('Role') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    {{ auth()->user()->id == $staff->id ? 'disabled' : '' }}
                                                    name="role_ids[]" id="role_id">
                                                    @foreach ($roles as $key => $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ in_array($role->id, $roleIds) ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="status"
                                                class="col-sm-3 control-label require ltr:ps-3 rtl:pe-3">{{ __('Status') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2-hide-search inputFieldDesign"
                                                    {{ auth()->user()->id == $staff->id ? 'disabled' : '' }} name="status"
                                                    id="status">
                                                    <option value="Pending"
                                                        {{ old('status', $staff->status) == 'Pending' ? 'selected' : '' }}>
                                                        {{ __('Pending') }}</option>
                                                    <option value="Active"
                                                        {{ old('status', $staff->status) == 'Active' ? 'selected' : '' }}>
                                                        {{ __('Active') }}</option>
                                                    <option value="Inactive"
                                                        {{ old('status', $staff->status) == 'Inactive' ? 'selected' : '' }}>
                                                        {{ __('Inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="description"
                                                class="col-sm-3 control-label ltr:ps-3 rtl:pe-3">{{ __('Description') }}</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" placeholder="{{ __('Description') }}" class="form-control form-width" id="description"
                                                    name="description">{{ $staff->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label ltr:ps-3 rtl:pe-3">{{ __('Picture') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file position-relative" data-val="single"
                                                    id="image-status">
                                                    <input class="form-control up-images attachment d-none"
                                                        name="attachment" id="validatedCustomFile" accept="image/*">
                                                    <label
                                                        class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                                        for="validatedCustomFile">{{ __('Upload image') }}</label>
                                                </div>
                                                <div id="img-container">
                                                    <div class="d-flex flex-wrap mt-2">
                                                        <div
                                                            class="position-relative border boder-1 p-1  ltr:me-2 rtl:ms-2 rounded mt-2">
                                                            <div
                                                                class="position-absolute rounded-circle text-center img-remove-icon">
                                                                <i class="fa fa-times"></i>
                                                            </div>
                                                            <img class="upl-img object-fit-contain p-1" src="{{ $staff->fileUrl() }}"
                                                                alt="{{ __('Image') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-2 px-3 order-1 order-md-2 offset-2 offset-md-0">
                                        <div class="form-group">
                                            <div class="col-md-9 px-3">
                                                <div class="fixSize user-img-con">
                                                    <a class="cursor_pointer" href='{{ $staff->fileUrl() }}'
                                                        data-lightbox="image-1"> <img
                                                            class="profile-user-img img-responsive fixSize rounded-circle"
                                                            src='{{ $staff->fileUrl() }}' alt="{{ __('Image') }}"
                                                            class="img-thumbnail attachment-styles"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id", value="{{ $staff->id }}">
                                <div class="row px-0">
                                    <div class="col-sm-9 btn-con">
                                        <a href="{{ route('vendor.staffs.index') }}"
                                            class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                                        <button class="btn custom-btn-submit" type="submit"
                                            id="btnSubmit">{{ __('Update') }}</button>
                                    </div>
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
    $passwordStrength = env('PASSWORD_STRENGTH');
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if ($passwordStrength) {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array('UPPERCASE', $conditions);
        $lowercase = in_array('LOWERCASE', $conditions);
        $number = in_array('NUMBERS', $conditions);
        $symbol = in_array('SYMBOLS', $conditions);
    }
@endphp
@section('js')
    <script src="{{ asset('public/dist/plugins/lightbox/js/lightbox.min.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var user_id = '{{ $staff->id }}';
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
