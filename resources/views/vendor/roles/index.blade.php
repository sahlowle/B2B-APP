@extends('vendor.layouts.app')
@section('page_title', __('Roles'))
@section('content')

    <!-- Main content -->
    <div class="col-sm-12 list-container" id="vendor-role-list-container">
        <div class="card">
            <div class="card-body row ps-0">
                <div
                    class="col-lg-3 col-12 z-index-10 pe-0">
                    @include('vendor.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ps-3 ps-lg-0 rtl:pe-0 pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header pt-xs-0 p-t-20 border-bottom mb-2">
                            <div class="mt-xs-0 mt-21p"></div>
                            <div class="card-header-right d-inline-block ltr:ps-3 rtl:pe-3 mt-2 ms-4">
                                @if (in_array('App\Http\Controllers\Vendor\RoleController@create', $prms))
                                    <x-backend.button.add-new href="{{ route('vendor.roles.create') }}" />
                                    @endif
                            </div>
                        </div>
                        <x-backend.datatable.table-wrapper class="order-list-table">
                            @include('vendor.layouts.includes.yajra-data-table')
                        </x-backend.datatable.table-wrapper>
                        @include('vendor.layouts.includes.delete-modal')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/js/custom/roles.min.js') }}"></script>
@endsection
