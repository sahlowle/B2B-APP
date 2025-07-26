@extends('vendor.layouts.app')
@section('page_title', __('Edit :x', ['x' => __('Role')]))
@section('css')

@endsection

@section('content')
    <div class="col-sm-12" id="vendor-role-edit-container">
        <div class="card">
            <div class="card-body row ps-0">
                <div class="col-lg-3 col-12 z-index-10 pe-0">
                    @include('vendor.layouts.includes.account_settings_menu')
                </div>
                <div class="col-lg-9 col-12 ps-3 ps-lg-0 rtl:pe-0 pe-0">
                    <div class="card card-info shadow-none mb-0">
                        <div class="card-header p-t-20 border-bottom ps-3">
                            <div class="fw-bold text-dark">{{ __('Edit Role') }} ({{ $role->name }})</div>
                        </div>
                        <div class="card-body table-border-style ltr:p-1 ltr:ps-md-3 rtl:pe-md-2 mb-3">
                            <form action="{{ route('vendor.roles.update', ['role' => $role->id]) }}" method="post"
                                id="roleEdit" class="mt-1">
                                @method('put')
                                @csrf
                                <input type="hidden" name="vendor_id" value="{{ auth()->user()?->vendor()?->vendor_id }}">
                                <input type="hidden" name="type" value="vendor">
                                <input type="hidden" name="id" value="{{ $role->id }}">
                                
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="name">{{ __('Name') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Name') }}"
                                            class="form-control inputFieldDesign" id="name" name="name"
                                            required pattern="^[a-zA-Z ]*$"
                                            value="{{ !empty(old('name')) ? old('name') : $role->name }}"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            oninput="this.setCustomValidity('')"
                                            data-pattern = "{{ __('Only alphabet and white space are allowed.') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label require"
                                        for="slug">{{ __('Slug') }}</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="{{ __('Slug') }}"
                                            class="form-control {{ in_array($role->slug, defaultRoles()) ? 'readonly' : '' }} inputFieldDesign"
                                            id="slug" name="slug"
                                            {{ in_array($role->slug, defaultRoles()) ? 'readonly' : '' }}
                                            value="{{ !empty(old('slug')) ? old('slug') : str_replace(auth()->user()?->vendor()?->vendor_id . '-', '', $role->slug) }}"
                                            required pattern="^[a-zA-Z\-]*$"
                                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                            data-pattern="{{ __('Only alphabet and white space are allowed.') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 control-label"
                                        for="description">{{ __('Description') }}</label>
                                    <div class="col-sm-6">
                                        <textarea type="text" placeholder="{{ __('Description') }}" class="form-control" id="description"
                                            name="description">{{ !empty(old('description')) ? old('description') : $role->description }}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 px-0 mt-3 mt-md-0">
                                    <a href="{{ route('vendor.roles.index') }}"
                                        class="py-2 ltr:me-2 rtl:ms-2 custom-btn-cancel">{{ __('Cancel') }}</a>
                                    <button class="btn py-2 custom-btn-submit" type="submit"
                                        id="submitBtn"><i
                                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                                            id="spinnerText">{{ __('Update') }}</span></button>
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
    <script src="{{ asset('public/dist/js/jquery.validate.min.js') }}"></script>
    {!! translateValidationMessages() !!}
    <script src="{{ asset('public/dist/js/custom/roles.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
@endsection
