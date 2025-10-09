@extends('admin.layouts.app')
@section('page_title', __('Subscription Setting'))

@section('content')
    <!-- Main content -->
    <div class="col-sm-12" id="account-settings-container">
        <div class="card">
            <div class="card-body row">
                <div class="col-12 ps-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom">
                            <h5>{{ __('Subscription Settings') }}</h5>
                        </div>
                        <div class="card-block table-border-style">
                            <form action="{{ route('package.subscription.setting') }}" method="post" class="form-horizontal">
                                @csrf
                                <div class="card-body p-0">
                                    <div class="form-group row">
                                        <label class="col-4 control-label" for="subscription_downgrade">{{ __('Downgrade') }}</label>
                                        <div class="col-6">
                                            <input type="hidden" value="0" name="subscription_downgrade">
                                            <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                <input class="" type="checkbox" @checked(old('subscription_downgrade', preference('subscription_downgrade'))) value="1" name="subscription_downgrade" id="subscription_downgrade">
                                                <label for="subscription_downgrade" class="cr"></label>
                                            </div>
                                            <label class="mt-1">{{ __('Allow subscription downgrade') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 control-label" for="subscription_change_plan">{{ __('Change Plan') }}</label>
                                        <div class="col-6">
                                            <input type="hidden" value="0" name="subscription_change_plan">
                                            <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                <input class="" type="checkbox" @checked(old('subscription_change_plan', preference('subscription_change_plan'))) value="1" name="subscription_change_plan" id="subscription_change_plan">
                                                <label for="subscription_change_plan" class="cr"></label>
                                            </div>
                                            <label class="mt-1">{{ __('Allow change plan one to another') }}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row d-none">
                                        <label class="col-4 control-label">{{ __('Type of restriction') }}</label>
                                        <div class="col-6">
                                            <input class="form-control" type="text" value="{{ old('subscription_restriction_message', preference('subscription_restriction_message')) }}" name="subscription_restriction_message" id="subscription_restriction_message" placeholder="{{ __('Message') }}">
                                        </div>
                                        <div class="offset-4 col-6 mt-2">
                                            <input class="form-control" type="text" value="{{ old('subscription_restriction_url', preference('subscription_restriction_url')) }}" name="subscription_restriction_url" id="subscription_restriction_url" placeholder="URL">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-4 control-label" for="customer_default_signup_status">{{ __('Subscription Renewal') }}</label>
                                        <div class="col-6">
                                            <select name="subscription_renewal" class="form-control select2-hide-search" >
                                                <option @selected(old('subscription_renewal', preference('subscription_renewal')) == 'automate') value="automate">{{ __('Automate') }}</option>
                                                <option @selected(old('subscription_renewal', preference('subscription_renewal')) == 'manual') value="manual">{{ __('Manual') }}</option>
                                                <option @selected(old('subscription_renewal', preference('subscription_renewal')) == 'customer_choice') value="customer_choice">{{ __('Customer Choice') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-4 control-label" for="email_automation">{{ __('Email Automation') }}</label>
                                        <div class="col-6">
                                            <input type="hidden" value="0" name="email_automation">
                                            <div class="switch switch-bg d-inline m-r-10 edit-is_default">
                                                <input class="" type="checkbox" @checked(old('email_automation', preference('email_automation'))) value="1" name="email_automation" id="email_automation">
                                                <label for="email_automation" class="cr"></label>
                                            </div>
                                            <label class="mt-1">{{ __('Automatically send email to members') }}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="subscription_remaining_days"
                                            class="col-sm-4 control-label">{{ __('Subscription Remaining') }}</label>
                                        <div class="col-6">
                                            <div class="pl-0">
                                                <input type="text"
                                                    class="form-control form-height"
                                                    name="subscription_remaining_days" id="subscription_remaining_days"
                                                    placeholder="3, 7"
                                                    value="{{ preference('subscription_remaining_days', 7) }}">
                                            </div>
                                            <div class="mt-12">
                                                <span class="badge badge-warning me-1">{{ __('Note') }}!</span>
                                                <span>{{ __('The remaining days will be separated by commas, such as 3, 7.') }}</span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="d-block">{{ __("Mail will be sent X number of days before seller subscription expires for the remaining duration.") }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="subscription_expire_days"
                                            class="col-sm-4 control-label">{{ __('Subscription Expire') }}</label>
                                        <div class="col-6">
                                            <div class="pl-0">
                                                <input type="text"
                                                    class="form-control form-height"
                                                    name="subscription_expire_days" id="subscription_expire_days"
                                                    placeholder="3, 7"
                                                    value="{{ preference('subscription_expire_days', 7) }}">
                                            </div>
                                            <div class="mt-12">
                                                <span class="badge badge-warning me-1">{{ __('Note') }}!</span>
                                                <span>{{ __('The expire days will be separated by commas, such as 3, 7.') }}</span>
                                            </div>
                                            <div class="mt-2">
                                                <span class="d-block">{{ __("Mail will be sent X number of days after seller subscription expires for the expire duration.") }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="subscription_remove_product_day"
                                            class="col-sm-4 control-label">{{ __('Remove (products)') }}</label>
                                        <div class="col-6">
                                            <div class="pl-0">
                                                <input type="number"
                                                    class="form-control form-height"
                                                    name="subscription_remove_product_day" id="subscription_remove_product_day"
                                                    min="0"
                                                    value="{{ preference('subscription_remove_product_day', 7) }}">
                                            </div>
                                            <div class="mt-2">
                                                <span class="d-block">{{ __("If a seller's subscription is not active, their products will be removed after x number of days. Additionally, when a seller downgrades to a lower plan and the limit of their new plan is exceeded, old products that exceed the limit will be deleted after x number of days.") }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer p-0">
                                        <div class="form-group row">
                                            <label for="btn_save" class="col-sm-3 control-label"></label>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn form-submit custom-btn-submit float-right" id="footer-btn">
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
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
