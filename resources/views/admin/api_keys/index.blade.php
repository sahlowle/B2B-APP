@extends('admin.layouts.app')
@section('page_title', __('API Keys'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
@endsection
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 list-container" id="api_key_container">
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
                                <h5>{{ __('API Keys') }}</h5>
                                <div class="card-header-right language-header">
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add_token"
                                        class="btn btn-sm btn-mv-primary mb-0 ltr:me-1 rtl:ms-1">
                                        <span class="fa fa-plus"> &nbsp;</span>{{ __('Add Token') }}</a>
                                </div>
                            </div>
                        </span>
                        
                        <div class="card-body px-2">
                            <div class="row p-l-15">
                                <div class="table-responsive">
                                    <table id="dataTableBuilder" class="table table-bordered dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Access Token') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Created') }}</th>
                                                <th class="w-10"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($apiKeys as $apiKey)
                                                <tr>
                                                    <td class="align-middle" title="{{ mb_strlen($apiKey->name) > 30 ? $apiKey->name : '' }}">{{ wrapIt($apiKey->name, 10, ['trimLength' => 30, 'cut' => false, 'trim' => true]) }}</td>
                                                    <td class="align-middle">**************{{ substr ($apiKey->access_token, -6) }}</td>
                                                    <td class="align-middle">{!! statusBadges(lcfirst($apiKey->status)) !!}</td>
                                                    <td class="align-middle">{!! timeZoneFormatDate($apiKey->created_at) . ' ' . timezoneGetTime($apiKey->created_at) !!}</td>
                                                    <td class="align-middle text-right">
                                                        <a title="{{ __('Edit Token') }}"
                                                            href="javascript:void(0)"
                                                            class="action-icon edit-token"
                                                            data-bs-toggle="modal" data-bs-target="#edit_token"
                                                            data-name="{{ $apiKey->name }}"
                                                            data-status="{{ $apiKey->status }}"
                                                            data-url="{{ route('api-keys.update', ['api_key' => $apiKey->id]) }}">
                                                            <span class="feather icon-edit-1"></span></a>
                                                                        
                                                        <x-backend.datatable.delete-button :route="route('api-keys.destroy', ['api_key' => $apiKey->id])" :id="$apiKey->id" :method="'DELETE'" />
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">{{ __('No Token Available') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.includes.delete-modal')
    
    <div id="add_token" class="modal fade display_none" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Add New') }}</h4>
                    <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                </div>
                <form action="{{ route('api-keys.store') }}" method="post" id="addLanguage"
                    class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label require" for="app_name">{{ __('App Name') }}</label>
                            <div class="col-sm-7">
                                <input type="text" id="app_name" name="name" class="form-control inputFieldDesign" 
                                required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                placeholder="{{ __('App Name') }}">
                            </div>
                        </div>
                        <div class="form-group row sl_status">
                            <label class="col-sm-4 control-label require" for="status">{{ __('Status') }}</label>
                            <div class="col-sm-7">
                                <select class="form-control select2-hide-search js-example-basic-single-2 sl_common_bx" id="status"
                                    name="status" required
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value="Active">{{ __('Active') }}</option>
                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="py-2 btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                                <button type="button"
                                    class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div id="edit_token" class="modal fade display_none" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Edit Token') }}</h4>
                    <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
                </div>
                <form action="" method="post" id="edit_token_Form" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 control-label require" for="app_name">{{ __('App Name') }}</label>
                            <div class="col-sm-7">
                                <input type="text" id="edit_app_name" name="name" class="form-control inputFieldDesign" 
                                required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                placeholder="{{ __('App Name') }}">
                            </div>
                        </div>
                        <div class="form-group row sl_status">
                            <label class="col-sm-4 control-label require" for="status">{{ __('Status') }}</label>
                            <div class="col-sm-7">
                                <select class="form-control js-example-basic-single-2 sl_common_bx" id="edit_status"
                                    name="status" required
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value="Active">{{ __('Active') }}</option>
                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-0">
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit"
                                    class="py-2 btn custom-btn-submit ltr:float-right rtl:float-left">{{ __('Create') }}</button>
                                <button type="button"
                                    class="py-2 custom-btn-cancel ltr:float-right ltr:me-2 rtl:float-left rtl:ms-2"
                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/settings.min.js?v=2.5') }}"></script>
@endsection
