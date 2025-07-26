@extends('admin.layouts.app')
@section('page_title', __('Custom Fields'))
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="custom-field-list-container">
        <div class="card">
            <div class="card-header bb-none pb-0">
                <h5>{{ __('Custom Fields') }}</h5>
                <x-backend.group-filters :groups="$groups" :column="'status'" />
                <div class="card-header-right my-2 mx-md-0 mx-sm-4">
                    <x-backend.button.batch-delete />
                    @hasPermission('App\Http\Controllers\CustomFieldController@create')
                        <x-backend.button.add-new href="{{ route('custom_fields.create') }}" />
                    @endhasPermission
                    <x-backend.button.filter />
                </div>
            </div>
            
            <x-backend.datatable.filter-panel>
                <div class="col-md-6">
                    <x-backend.datatable.input-search />
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="field_belongs">
                        <option value="">{{ __('All Belongs') }}</option>
                        @foreach ($fieldBelongs as $key => $value)
                            <option value="{{ $key }}">{{ ucfirst($key) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="select2-hide-search filter" name="types">
                        <option value="">{{ __('All Type') }}</option>
                        @foreach ($inputTypes as $key => $value)
                            <option value="{{ $key }}">{{ ucfirst($key) }}</option>
                        @endforeach
                    </select>
                </div>
            </x-backend.datatable.filter-panel>

            <x-backend.datatable.table-wrapper class="product-table need-batch-operation" data-namespace="\App\Models\CustomField" data-column="id">
                @include('admin.layouts.includes.yajra-data-table')
            </x-backend.datatable.table-wrapper>

            @include('admin.layouts.includes.delete-modal')
        </div>
    </div>
@endsection
