
{{-- List provider --}}
<div class="row px-4 mt-14">
    <div class="col-sm-12 p-0">
        <x-backend.datatable.filter-panel>
            <div class="col-md-6">
                <x-backend.datatable.input-search />
            </div>
            <div class="col-md-6">
                <select class="select2 filter" name="country">
                    <option value="">{{ __('All Country') }}</option>
                    @foreach($countryList as $country)
                    <option value="{{__($country->id)}}">{{__($country->name)}}</option>
                    @endforeach
                </select>
            </div>
        </x-backend.datatable.filter-panel>
        <x-backend.datatable.table-wrapper class="shipping-provider-list">
            @include('admin.layouts.includes.yajra-data-table')
        </x-backend.datatable.table-wrapper>
    </div>
</div>

{{-- Add provider --}}
<div id="add-provider" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Add :x', ['x' => __('New')]) }} &nbsp;</h4>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <form action="{{route('shipping.storeProvider')}}" method="post" id="addProvider"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
            <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require" for="name">{{ __('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control inputFieldDesign"  placeholder="{{ __('Name') }}" name="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="country">{{ __('Country') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx shipping_country" name="country_id" required>
                                @foreach($countryList as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require" for="tracking_base_url">{{ __('Tracking Url') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control inputFieldDesign"  placeholder="{{ __('Tracking URL') }}" name="tracking_base_url" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="tracking_url_method">{{ __('URL Method') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx" name="tracking_url_method" required>
                                <option value="Get">{{ __('Get') }}</option>
                                <option value="Post">{{ __('Post') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label">{{ __('Logo') }}</label>
                        <div class="col-sm-9">
                            <div class="custom-file position-relative has-thumbnail" data-val="single" id="image-status" data-type="{{ implode(',', getFileExtensions(2)) }}">
                                <input class="custom-file-input form-control d-none inputFieldDesign" name="attachments" id="validatedCustomFile" accept="image/*">
                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center" for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                            </div>
                            <div class="d-flex" id="provider-image">
                                <!-- img will be shown here -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="status">{{ __('Status') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx" name="status" required>
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
                            class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left save-provider">{{ __('Create') }}</button>
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

{{-- Edit provider --}}
<div id="edit-provider" class="modal fade display_none" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Edit :x', ['x' => __('Provider')]) }} &nbsp;</h4>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <form action="{{route('shipping.updateProvider')}}" method="post" id="editProvider"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
            <div class="modal-body">
                    <input type="hidden" name="provider_id" id="provider_id">
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require" for="name">{{ __('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control inputFieldDesign"  placeholder="{{ __('Name') }}" name="name" id="name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="country">{{ __('Country') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx shipping_country" name="country_id" id="country_id" required>
                                @foreach($countryList as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require" for="tracking_base_url">{{ __('Tracking Url') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control inputFieldDesign"  placeholder="{{ __('Tracking URL') }}" name="tracking_base_url" id="tracking_base_url" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="tracking_url_method">{{ __('URL Method') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx" id="tracking_url_method" name="tracking_url_method" required>
                                <option value="Get">{{ __('Get') }}</option>
                                <option value="Post">{{ __('Post') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require">{{ __('Logo') }}</label>
                        <div class="col-sm-9">
                            <div class="custom-file has-media-manager position-relative has-thumbnail" data-val="single" id="image-status"  data-type="{{ implode(',', getFileExtensions(2)) }}">
                                <input class="custom-file-input form-control d-none inputFieldDesign"
                                    name="attachments" id="validatedCustomFile" accept="image/*">
                                <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                                    for="validatedCustomFile">{{ __('Upload Logo') }}</label>
                            </div>
                            <div id="img-container">
                                <div class="d-flex flex-wrap mt-2">
                                    <div class="position-relative border boder-1 p-1 rtl:me-2 rounded mt-2">
                                        <input type="hidden" id="file_id" name="file_id[]" value="">
                                        <div
                                            class="position-absolute rounded-circle text-center img-remove-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <img class="upl-img provider-logo p-1" src="#" alt="{{ __('Image') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label require pr-0" for="status">{{ __('Status') }}</label>
                        <div class="col-sm-9">
                            <select class="js-example-basic-single-1 form-control select2-hide-search sl_common_bx" name="status" id="status" required>
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
                            class="btn py-2 custom-btn-submit ltr:float-right rtl:float-left update-provider">{{ __('Update') }}</button>
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

{{-- Delete provider --}}
<div class="modal modal-blur fade" id="delete-provider" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="#" method="post" id="deleteProvider" class="form-horizontal">
            @csrf
            @method('delete')
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger" style="width: 3.5rem;height: 3.5rem;" width="30" height="30" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                <h3 class="fs-6 lh-1_5 fw-600">{{ __('Are you sure?') }}</h3>
                <div class="text-secondary text-muted">{{ __('Once performed, this action cannot be undone.') }}</div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-danger delete-provider">{{ __('Yes, Confirm') }}</button>
                <span class="ajax-loading"></span>
            </div>
        </form>
      </div>
    </div>
</div>
