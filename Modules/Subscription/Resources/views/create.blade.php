@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Subscription')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="subscription-add-container">
        <div class="card">
            <div class="card-body row" id="subscription-container">
                <div class="col-lg-3 col-12 z-index-10 pe-0 ps-0 ps-md-3" aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none" id="nav">
                        <div class="card-header pt-4 border-bottom text-nowrap">
                            <h5 id="general-settings">{{ __('Subscription Create') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link text-left tab-name active" id="v-pills-general-tab" data-bs-toggle="pill"
                                    href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                    aria-selected="true" data-id="{{ __('General') }}">{{ __('General') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-transaction-tab" data-bs-toggle="pill"
                                    href="#v-pills-transaction" role="tab" aria-controls="v-pills-transaction"
                                    aria-selected="true" data-id="{{ __('Transaction') }}">{{ __('Transaction') }}</a></li>
                            <li><a class="nav-link text-left tab-name" id="v-pills-status-tab" data-bs-toggle="pill"
                                    href="#v-pills-status" role="tab" aria-controls="v-pills-status"
                                    aria-selected="true" data-id="{{ __('Status') }}">{{ __('Status') }}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-12 ps-0">
                    <div class="card card-info shadow-none">
                        <div class="card-header pt-4 border-bottom">
                            <h5><span id="theme-title">{{ __('General') }}</span></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('package.subscription.store') }}" method="post">
                                @csrf

                                <div class="tab-content p-0 box-shadow-unset" id="topNav-v-pills-tabContent">
                                    {{-- General --}}
                                    <div class="tab-pane fade active show" id="v-pills-general" role="tabpanel"
                                        aria-labelledby="v-pills-general-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="package_id" class="control-label">{{ __('Plan') }}</label>
                                                        <select class="form-control select2 inputFieldDesign"
                                                            name="package_id" id="package_id">
                                                            @foreach ($packages as $package)
                                                                <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>{{ $package->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if(!count($packages))
                                                            <span class="text-danger">{{ __("Please create a packge") }}
                                                                <a class="ms-1" href="{{ route('package.create') }}" target="_blank">{{ __('Click Here') }}</a>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="user_id" class="control-label">{{ __('User') }}</label>
                                                        <select class="form-control select2 inputFieldDesign"
                                                            name="user_id" id="user_id">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="billing_cycle" class="control-label">{{ __('Billing Cycle') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="billing_cycle" id="billing_cycle">
                                                            <option value="days" @selected(old('billing_cycle') == 'days')>{{ __('Days') }}</option>
                                                            <option value="weekly" @selected(old('billing_cycle') == 'weekly')>{{ __('Weekly') }}</option>
                                                            <option value="monthly" @selected(old('billing_cycle', 'monthly') == 'monthly')>{{ __('Monthly') }}</option>
                                                            <option value="yearly" @selected(old('billing_cycle') == 'yearly')>{{ __('Yearly') }}</option>
                                                            <option value="lifetime" @selected(old('billing_cycle') == 'lifetime')>{{ __('Lifetime') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mt-2 {{ old('billing_cycle') == 'days' ? '' : 'd-none' }}" id="duration_days">
                                                        <label for="duration" class="control-label">{{ __('Duration') }}</label>
                                                        <input type="text" placeholder="{{ __('Days') }}"
                                                            class="form-control form-width inputFieldDesign positive-int-number" id="duration"
                                                            name="meta[0][duration]" value="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="billing_price" class="control-label">{{ __('Billing Price') }}</label>
                                                        <input type="text" placeholder="{{ __('Billing Price') }}" readonly
                                                            class="form-control form-width inputFieldDesign positive-float-number" id="billing_price"
                                                            name="billing_price" value="{{ old('billing_price', 0) }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <label for="activation_date" class="control-label">{{ __('Activation Date') }}</label>
                                                        <div class="d-flex date">
                                                            <div class="input-group-prepend">
                                                                <i class="fas border-end-0 fa-calendar-alt input-group-text bg-white rounded-0 rounded-start h-40"></i>
                                                            </div>
                                                            <input type="text" placeholder="{{ __('Activation Date') }}"
                                                                class="form-control form-width inputFieldDesign positive-int-number" id="activation_date"
                                                                name="activation_date" value="{{ old('activation_date') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="billing_date" class="control-label">{{ __('Billing Date') }}</label>
                                                        <div class="d-flex date">
                                                            <div class="input-group-prepend">
                                                                <i class="fas border-end-0 fa-calendar-alt input-group-text bg-white rounded-0 rounded-start h-40"></i>
                                                            </div>
                                                            <input type="text" placeholder="{{ __('Billing Date') }}"
                                                                class="form-control form-width inputFieldDesign positive-int-number" id="billing_date"
                                                                name="billing_date" value="{{ old('billing_date') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="next_billing_date" class="control-label">{{ __('Next Billing Date') }}</label>
                                                         <div class="d-flex date">
                                                            <div class="input-group-prepend">
                                                                <i class="fas border-end-0 fa-calendar-alt input-group-text bg-white rounded-0 rounded-start h-40"></i>
                                                            </div>
                                                            <input type="text" placeholder="{{ __('Next Billing Date') }}"
                                                                class="form-control form-width inputFieldDesign positive-int-number" id="next_billing_date"
                                                                name="next_billing_date" value="{{ old('next_billing_date') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Transaction --}}
                                    <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel"
                                        aria-labelledby="v-pills-transaction-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="amount_billed" class="control-label">{{ __('Amound Billed') }}</label>
                                                        <input type="text" placeholder="{{ __('Amound Billed') }}" readonly
                                                            class="form-control form-width inputFieldDesign positive-float-number" id="amount_billed"
                                                            name="amount_billed" value="{{ old('amount_billed', 0) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="amount_received" class="control-label">{{ __('Amound Received') }}</label>
                                                        <input type="text" placeholder="{{ __('Amound Received') }}" readonly
                                                            class="form-control form-width inputFieldDesign positive-float-number" id="amount_received"
                                                            name="amount_received" value="{{ old('amount_received', 0) }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="amount_due" class="control-label">{{ __('Amound Due') }}</label>
                                                        <input type="text" placeholder="{{ __('Amound Due') }}" readonly
                                                            class="form-control form-width inputFieldDesign positive-float-number" id="amount_due"
                                                            name="amount_due" value="{{ old('amount_due', 0) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="is_customized" value="0">
                                    <input type="hidden" name="renewable" id="renewable" value="0">
                                    {{-- Status --}}
                                    <div class="tab-pane fade" id="v-pills-status" role="tabpanel"
                                        aria-labelledby="v-pills-status-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="payment_status" class="control-label">{{ __('Payment Status') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="payment_status" id="payment_status">
                                                            <option value="Paid" @selected(old('payment_status') == 'Paid')>{{ __('Paid') }}</option>
                                                            <option value="Unpaid" @selected(old('payment_status') == 'Unpaid')>{{ __('Unpaid') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="status" class="control-label">{{ __('Status') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="status" id="status">
                                                            @foreach (subscription('getStatuses') as $status)
                                                                <option value="{{ $status }}" @selected(old('status') == $status)>{{ $status }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer py-0">
                                    <div class="form-group row">
                                        <label for="btn_save" class="col-sm-3 control-label"></label>
                                        <div class="m-auto">
                                            <button type="submit"
                                                class="btn form-submit custom-btn-submit float-right package-submit-button"
                                                id="footer-btn">{{ __('Save') }}</button>
                                            <a href="{{ route('package.subscription.index') }}"
                                                class="py-2 me-2 form-submit custom-btn-cancel float-right submit-button all-cancel-btn">{{ __('Cancel') }}</a>
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
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js?v=3.0') }}"></script>
@endsection
