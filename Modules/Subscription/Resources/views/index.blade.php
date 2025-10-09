@extends('admin.layouts.app')
@section('page_title', __('Subscription'))

@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="subscription-list-container">
        @if (_d_f_e())
            @include('subscription::install.purchasecode')
        @endif
        
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Subscription') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Subscription\Http\Controllers\PackageSubscriptionController@create', $prms))
                        <x-backend.button.add-new href="{{ route('package.subscription.create') }}" />
                    @endif
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel class="mx-1">
                <div class="col-md-8">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-4">
                    <select class="select2-hide-search filter" name="billing_cycle">
                        <option value="">{{ __('All Billing Cycle') }}</option>
                        <option value="lifetime">{{ __('Lifetime') }}</option>
                        <option value="yearly">{{ __('Yearly') }}</option>
                        <option value="monthly">{{ __('Monthly') }}</option>
                        <option value="weekly">{{ __('Weekly') }}</option>
                        <option value="days">{{ __('Days') }}</option>
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="product-table product-table-export-button need-batch-operation"
                data-namespace="Modules\Subscription\Entities\PackageSubscription" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
            @include('admin.layouts.includes.delete-modal')

            <div id="mail_modal" class="modal fade display_none" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Manual Mail Send') }}</h4>
                            <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                        </div>
                        <form action="{{ route('package.subscription.notification') }}" method="post"
                            class="form-horizontal">
                            @csrf
                            <input id="subscription_id" type="hidden" name="id" value="">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label"
                                        for="last_email_sent">{{ __('Last Email Send') }}</label>
                                    <div class="col-sm-7 mt-2" id="last_sent_mail">
                                        {{-- Data will be load here --}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 control-label"
                                        for="last_email_sent">{{ __('Mail Type') }}</label>
                                    <input id="mail_type_input" type="hidden" name="mail_type" value="">
                                    <div class="col-sm-7 mt-2" id="mail_type">
                                        {{-- Data will be load here --}}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 control-label"
                                        for="last_email_sent">{{ __('Schedule Dates') }}</label>
                                    <div class="col-sm-7 mt-2" id="schedule_dates">
                                        {{-- Data will be load here --}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 control-label"
                                        for="edit_default">{{ __('Send Immediately') }}</label>
                                    <input type="hidden" name="immediate_mail" value="0">
                                    <div class="col-sm-0 switch switch-primary mt-1">
                                        <input class="switch switch-primary minimal" type="checkbox" id="immediate_mail"
                                            name="immediate_mail" value="1">
                                        <label for="immediate_mail" class="cr ml-3 swicth-pos"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer py-0">
                                <div class="form-group row">
                                    <label for="btn_save" class="col-sm-3 control-label"></label>
                                    <div class="col-sm-12">
                                        <button id="manual_mail_submit" type="submit"
                                            class="py-2 btn custom-btn-submit float-right">{{ __('Send') }}</button>
                                        <button type="button" class="py-2 custom-btn-cancel float-right me-2"
                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
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

@section('js')
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
