<div class="modal fade" id="addSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="theModalLabel">{{ __('Create Supplier') }}</h5>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <div class="modal-body">
               <form action="#" method="post" class="form-horizontal col-sm-12" enctype="multipart/form-data" id="supplierFrom">
                        @csrf
                        <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 control-label require">{{ __('Name') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Name') }}"
                                               class="form-control inputFieldDesign" name="name"
                                               value="{{ old('name') }}" required maxlength="80"
                                               oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                                
                                <input type="hidden" name="api" value="1">
                                <input type="hidden" name="vendor_id" id="supplier_add_vendorId">
                                
                                <div class="form-group row">
                                    <label for="slug" class="col-sm-3 control-label">{{ __('Company Name') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Company Name') }}"
                                               class="form-control inputFieldDesign" id="company_name" name="company_name"
                                               value="{{ old('company_name') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="email"
                                           class="col-sm-3 control-label">{{ __('Email') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control inputFieldDesign bg-white"
                                               id="email" name="email" value="{{ old('email') }}"
                                               placeholder="{{ __('Email') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="phone"
                                           class="col-sm-3 control-label">{{ __('Phone') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Phone') }}"
                                               class="form-control phone-number inputFieldDesign" id="phone"
                                               name="phone" value="{{ old('phone') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address"
                                           class="col-sm-3 control-label">{{ __('Address') }}</label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="{{ __('Address') }}" id="address" class="form-control" name="address"
                                        >{{ old('address') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="country"
                                           class="col-sm-3 control-label">{{ __('Country') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control addressSelect sl_common_bx" name="country" id="country">
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="state"
                                           class="col-sm-3 control-label">{{ __('State') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control addressSelect sl_common_bx" name="state" id="state">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city"
                                           class="col-sm-3 control-label">{{ __('City') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control addressSelect sl_common_bx" name="city" id="city">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="zip"
                                           class="col-sm-3 control-label">{{ __('Zip') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Zip') }}"
                                               class="form-control inputFieldDesign" id="zip"
                                               name="zip" value="{{ old('zip') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="Status"
                                           class="col-sm-3 control-label require">{{ __('Status') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                name="status" id="status">
                                            <option value="Active"
                                                {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                {{ __('Active') }}</option>
                                            <option value="Inactive"
                                                {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                {{ __('Inactive') }}</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit" id="theModalSubmitBtn"
                                        class="btn py-2 custom-btn-submit {{ languageDirection() == 'ltr' ? 'float-right' : 'float-left' }}">{{ __('Submit') }}</button>
                                <button type="button"
                                        class="py-2 custom-btn-cancel {{ languageDirection() == 'ltr' ? 'float-right me-2' : 'float-left ms-2' }}"
                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
