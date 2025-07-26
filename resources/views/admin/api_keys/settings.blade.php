@extends('admin.layouts.app')
@section('page_title', __('API Settings'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="api_setting_container">
        <div class="card">
            <div class="card-body row">
                <div
                    class="col-lg-3 col-12 z-index-10  ltr:ps-md-3 ltr:pe-0 ltr:ps-0 rtl:pe-md-3 rtl:ps-0 rtl:pe-0">
                    @include('admin.layouts.includes.general_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ltr:ps-0 rtl:pe-0">
                    <div class="card card-info shadow-none mb-0">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <span id="smtp_head">
                            <div class="card-header p-t-20 border-bottom">
                                <h5>{{ __('API Settings') }}</h5>
                            </div>
                        </span>
                        
                        <form action="{{ route('api-settings') }}" method="POST">
                            @csrf
                            <div class="card-body px-2 ">
                                <div class="row p-l-15">
                                    <div class="form-group row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <label for="enable_api" class="control-label"><b>{{ __('API Access') }}</b></label>
                                            <span>{{ __('Enable or disable the API functionality. When enabled, the system can interact with external applications and services via the API.') }}</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center p-r-0 m-r-0">
                                            <div class="ltr:me-3 rtl:ms-3">
                                                <input type="hidden" name="enable_api"
                                                    value="0">
                                                <div class="switch switch-bg d-inline">
                                                    <input type="checkbox" name="enable_api"
                                                        class="checkActivity" id="enable_api"
                                                        value="1"
                                                        {{ preference('enable_api', 1   ) == 1 ? 'checked' : '' }}>
                                                    <label for="enable_api" class="cr"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <label for="access_token_required" class="control-label"><b>{{ __('Access Token Requirement') }}</b></label>
                                            <span>{{ __('Determine if a secret key is required for API access. Enabling this ensures that only authorized users with the correct token can access the API, enhancing security.') }}</span>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-end align-self-center p-r-0 m-r-0">
                                            <div class="ltr:me-3 rtl:ms-3">
                                                <input type="hidden" name="access_token_required"
                                                    value="0">
                                                <div class="switch switch-bg d-inline">
                                                    <input type="checkbox" name="access_token_required"
                                                        class="checkActivity" id="access_token_required"
                                                        value="1"
                                                        {{ preference('access_token_required', '') == 1 ? 'checked' : '' }}>
                                                    <label for="access_token_required" class="cr"></label>
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
                                        <button type="submit"
                                            class="btn form-submit custom-btn-submit ltr:float-right rtl:float-left save-button"
                                            id="footer-btn">
                                            <span
                                                class="d-none product-spinner spinner-border spinner-border-sm text-secondary"
                                                role="status"></span>
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
