@extends('vendor.layouts.app')
@section('page_title', __('Transaction'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Inventory/Resources/assets/css/datatable.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="stock-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5> {{ __('Type') }} </h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.filter />
                </div>
            </div>

            <x-backend.datatable.filter-panel>
                <div class="col-md-2">
                    <x-backend.datatable.input-search />
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="inventory-module-table inventory-module-table-export-button" data-namespace="\Modules\Inventory\Entities\Location" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
@section('js')

@endsection
