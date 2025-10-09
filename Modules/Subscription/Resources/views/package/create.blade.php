@extends('admin.layouts.app')
@section('page_title', __('Create :x', ['x' => __('Plan')]))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="package-add-container">
        <div class="card">
            <div class="card-body row" id="package-container">
                <div class="col-lg-3 col-12 z-index-10 pe-0 ps-0 ps-md-3" aria-labelledby="navbarDropdown">
                    <div class="card card-info shadow-none" id="nav">
                        <div class="card-header pt-4 border-bottom text-nowrap">
                            <h5 id="general-settings">{{ __('Plan Create') }}</h5>
                        </div>
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <li><a class="nav-link text-left tab-name active" id="v-pills-general-tab" data-bs-toggle="pill"
                                    href="#v-pills-general" role="tab" aria-controls="v-pills-general"
                                    aria-selected="true" data-id="{{ __('General') }}">{{ __('General') }}</a></li>
                            <li class="featuers mt-2 font-bold text-dark ms-3">{{ __('Features') }}</li>
                            @foreach ($features as $key => $value)
                                <li class="ms-3"><a class="nav-link text-left tab-name" id="v-pills-{{ $key }}-tab" data-bs-toggle="pill"
                                        href="#v-pills-{{ $key }}" role="tab" aria-controls="v-pills-{{ $key }}"
                                        aria-selected="true"
                                        data-id="{{ ucwords(str_replace('-', ' ', $key)) }}">{{ str_replace('-', ' ', $key) }}</a></li>
                            @endforeach
                            <li class="add-feature-nav" data-count="1">+ {{ __('Add Feature') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-12 ps-0">
                    <div class="card card-info shadow-none">
                        <div class="card-header pt-4 border-bottom">
                            <h5><span id="theme-title">{{ __('General') }}</span></h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('package.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                <div class="tab-content p-0 box-shadow-unset" id="topNav-v-pills-tabContent">
                                    {{-- General --}}
                                    <div class="tab-pane fade active show" id="v-pills-general" role="tabpanel"
                                        aria-labelledby="v-pills-general-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="name" class="control-label require">{{ __('Name') }}</label>
                                                        <input type="text" placeholder="{{ __('Name') }}"
                                                            class="form-control form-width inputFieldDesign" id="name"
                                                            name="name" required minlength="3" value="{{ old('name') }}"
                                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                            data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Name'), 'y' => 3]) }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="code" class="control-label require">{{ __('Code') }}</label>
                                                        <input type="text" placeholder="{{ __('Code') }}"
                                                            class="form-control form-width inputFieldDesign" id="code"
                                                            name="code" required minlength="3" value="{{ old('code') }}"
                                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                                            data-min-length="{{ __(':x should contain at least :y characters.', ['x' => __('Code'), 'y' => 3]) }}">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="short_description" value="">

                                                <div class="row">
                                                    <div class="col-2">
                                                        <label for="billing_cycle" class="control-label">{{ __('Billing Cycle') }}</label>
                                                    </div>
                                                    <div class="col-5">
                                                        <label for="sale_price" class="control-label">{{ __('Sale Price') }}</label>
                                                    </div>
                                                    <div class="col-5">
                                                        <label for="discount_price" class="control-label">{{ __('Discount Price') }}</label>
                                                    </div>
                                                </div>

                                                {{-- Billing and Price --}}
                                                @foreach(['lifetime' => __('Lifetime'), 'yearly' => __('Yearly'), 'monthly' => __('Monthly'), 'weekly' => __('Weekly'), 'days' => __('Days')] as $key => $value)
                                                    <div class="form-group row billing-parent">
                                                        <div class="col-2">
                                                            <div class="checkbox checkbox-warning checkbox-fill d-block">
                                                                <input type="hidden" name="billing_cycle[{{ $key }}]" value="0">
                                                                <input type="checkbox" class="billing-checkbox" name="billing_cycle[{{ $key }}]" id="billing_cycle[{{ $key }}]" value="1" {{ old("billing_cycle.$key", 1) == 1 ? 'checked' : '' }}>
                                                                <label class="cr" for="billing_cycle[{{ $key }}]">{{ $value }}</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <input type="text" placeholder="{{ __('Sale Price') }}" @readonly(old("billing_cycle.$key", 1) == 0)
                                                                class="form-control form-width inputFieldDesign positive-float-number"
                                                                name="sale_price[{{ $key }}]" value="{{ old("sale_price.$key") }}">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="text" placeholder="{{ __('Discount Price') }}" @readonly(old("billing_cycle.$key", 1) == 0)
                                                                class="form-control form-width inputFieldDesign positive-float-number"
                                                                name="discount_price[{{ $key }}]" value="{{ old("discount_price.$key") }}">
                                                        </div>

                                                        @if ($key == 'days')
                                                            <div class="col-md-5 offset-2 mt-2" id="duration_days">
                                                                <div class="input-group" style="background-color: white;">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text rounded-0 rounded-start">{{ __('Duration') }}</span>
                                                                    </div>
                                                                    <input type="text" placeholder="15" @readonly(old("billing_cycle.$key", 1) == 0)
                                                                    class="form-control form-width positive-int-number" id="duration"
                                                                    name="meta[0][duration]" value="">
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                @endforeach

                                                <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <label for="sort_order" class="control-label">{{ __('Sort') }}</label>
                                                        <input type="text" placeholder="{{ __('Sort') }}"
                                                            class="form-control form-width inputFieldDesign positive-int-number" id="sort_order"
                                                            name="sort_order" value="{{ old('sort_order') }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="trial_day" class="control-label">{{ __('Trial Day') }}</label>
                                                        <input type="text" placeholder="{{ __('Trial Day') }}"
                                                            class="form-control form-width inputFieldDesign positive-int-number" id="trial_day"
                                                            name="trial_day" value="{{ old('trial_day') }}">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-sm-4">
                                                        <label for="is_private" class="control-label">{{ __('Is Visible?') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="is_private" id="is_private">
                                                            <option value="0"
                                                                {{ old('is_private') == '0' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                                            <option value="1"
                                                                {{ old('is_private') == '1' ? 'selected' : '' }}>{{ __('No') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="renewable" class="control-label">{{ __('Renewable') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="renewable" id="renewable">
                                                            <option value="0" @selected(old('renewable') == '0')>{{ __('No') }}</option>
                                                            <option value="1" @selected(old('renewable', '1') == '1')>{{ __('Yes') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="status" class="control-label">{{ __('Status') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="status" id="status">
                                                            <option value="Active"
                                                                {{ old('status') == 'Active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                                            <option value="Inactive"
                                                                {{ old('status') == 'Inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                                            <option value="Pending"
                                                                {{ old('status') == 'Pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Features --}}
                                    @foreach ($features as $key => $feature)
                                        <input type="hidden" name="meta[{{ $key }}][type]" value="{{ $feature->type }}">
                                        <input type="hidden" name="meta[{{ $key }}][is_value_fixed]" value="{{ $feature->is_value_fixed }}">

                                        <div class="tab-pane fade" id="v-pills-{{ $key }}" role="tabpanel"
                                            aria-labelledby="v-pills-{{ $key }}-tab">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="title" class="control-label">{{ __('Title') }}</label>
                                                    <input type="text" placeholder="{{ __('Title') }}" maxlength="191"
                                                        class="form-control form-width inputFieldDesign" id="title"
                                                        name="meta[{{ $key }}][title]" value="{{ $feature->title }}">
                                                </div>
                                                @if ($feature->type == 'number')
                                                    <div class="col-sm-6">
                                                        <label for="title_position" class="control-label">{{ __('Position') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="meta[{{ $key }}][title_position]" id="title_position">
                                                            <option value="before"
                                                                {{ old('title_position', $feature->title_position) == 'before' ? 'selected' : '' }}>{{ __('Before the value') }}</option>
                                                            <option value="after"
                                                                {{ old('title_position', $feature->title_position) == 'after' ? 'selected' : '' }}>{{ __('After the value') }}</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <label for="value" class="control-label">{{ __('Value') }}</label>
                                                        <input type="text" placeholder="{{ __('Value') }}"
                                                            class="form-control form-width inputFieldDesign int-number package-limit" id="value" maxlength="16"
                                                            name="meta[{{ $key }}][value]" value="{{ old('value', $feature->value) }}">
                                                        <label class="mt-1"><span class="badge badge-warning me-2">{{ __('Note') }}</span>{{ __('-1 for unlimited') }}</label>
                                                    </div>
                                                @elseif ($feature->type == 'bool')
                                                    <div class="col-sm-6">
                                                        <label for="value" class="control-label">{{ __('Value') }}</label>
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="meta[{{ $key }}][value]" id="{{ $key }}value">
                                                            <option value="1"
                                                                {{ old('value', $feature->value ?? '') == '1' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                                            <option value="0"
                                                                {{ old('value', $feature->value ?? '') == '0' ? 'selected' : '' }}>{{ __('No') }}</option>
                                                        </select>
                                                    </div>
                                                @elseif (in_array($feature->type, ['select', 'multi-select']))
                                                    <div class="col-sm-6">
                                                        <label for="value" class="control-label">{{ __('Value') }}</label>
                                                        <input type="hidden" name="meta[{{ $key }}][value][]" value="{{ current($feature->value->toArray()) }}">
                                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                            name="meta[{{ $key }}][value][]" id="{{ $key }}value" {{ $feature->type == 'multi-select' ? 'multiple' : '' }}>
                                                            @foreach($feature->value as $k => $v)
                                                                <option {{ $feature->type == 'multi-select' ? 'selected' : ''}} value="{{ $k }}">{{ $v }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="col-sm-6">
                                                    <label for="is_visible" class="control-label">{{ __('Is Visible') }}</label>
                                                    <select class="form-control select2-hide-search inputFieldDesign"
                                                        name="meta[{{ $key }}][is_visible]" id="{{ $key }}is_visible">
                                                        <option value="1" selected>{{ __('Yes') }}</option>
                                                        <option value="0">{{ __('No') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="footer py-0">
                                    <div class="form-group row">
                                        <label for="btn_save" class="col-sm-3 control-label"></label>
                                        <div class="m-auto">
                                            <button type="submit"
                                                class="btn form-submit custom-btn-submit float-right package-submit-button"
                                                id="footer-btn">{{ __('Save') }}</button>
                                            <a href="{{ route('package.index') }}"
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
    @include('subscription::package.add-feature')
@endsection

@section('js')
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
