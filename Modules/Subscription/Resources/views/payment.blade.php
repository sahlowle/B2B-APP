@extends('admin.layouts.app')
@section('page_title', __('Payment'))

@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="payment-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Payments') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.filter />
                </div>
            </div>
            <x-backend.datatable.filter-panel class="mx-1">
                <div class="col-md-12">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="product-table">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
