@extends('admin.layouts.app')
@section('page_title', __('Plan'))

@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="package-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Plan') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @if (in_array('Modules\Subscription\Http\Controllers\PackageController@create', $prms))
                        <x-backend.button.add-new href="{{ route('package.create') }}" />
                    @endif

                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel class="mx-1">
                <div class="col-md-6">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="visibility">
                        <option value="">{{ __('All Visibility') }}</option>
                        <option value="0">{{ __('Yes') }}</option>
                        <option value="1">{{ __('No') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
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
                data-namespace="Modules\Subscription\Entities\Package" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
