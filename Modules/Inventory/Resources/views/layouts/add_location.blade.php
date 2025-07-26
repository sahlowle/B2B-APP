<div class="modal fade" id="addLocation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="theModalLabel">{{ __('Create Location') }}</h5>
                <a type="button" class="close h5" data-bs-dismiss="modal">×</a>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" class="form-horizontal col-sm-12" enctype="multipart/form-data" id="locationFrom">
                        @csrf
                        <div class="col-sm-12">
                            
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 control-label require">{{ __('Name') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Name') }}"
                                               class="form-control inputFieldDesign" id="name" name="name"
                                               value="{{ old('name') }}" required maxlength="80"
                                               oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                                <input type="hidden" name="api" value="1">
                                <input type="hidden" name="vendor_id" id="location_add_vendorId">
                                <div class="form-group row">
                                    <label for="slug" class="col-sm-3 control-label require">{{ __('Slug') }}
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="{{ __('Slug') }}"
                                               class="form-control inputFieldDesign" id="slug" name="slug"
                                               value="{{ old('slug') }}" required maxlength="80"
                                               oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
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
                                        <select class="form-control sl_common_bx select2" name="country" id="location_country">
                                            <option value="">{{ __('Select One') }}</option>
                                            @foreach($countries as $country) 
                                                <option value="{{ $country->code }}" data-country="{{ $country->code }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="state"
                                           class="col-sm-3 control-label">{{ __('State') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control sl_common_bx select2" name="state" id="location_state">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="city"
                                           class="col-sm-3 control-label">{{ __('City') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control sl_common_bx select2" name="city" id="location_city">

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

                                <div class="form-group row">
                                    <label for="Status"
                                           class="col-sm-3 control-label require">{{ __('Default') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2-hide-search inputFieldDesign"
                                                name="is_default" id="is_default">
                                            <option value="0"
                                                {{ old('is_default') == '0' ? 'selected' : '' }}>
                                                {{ __('No') }}</option>
                                            <option value="1"
                                                {{ old('is_default') == '1' ? 'selected' : '' }}>
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>
                                  
                              
                        </div>
               
                        <div class="form-group row">
                            <label for="btn_save" class="col-sm-3 control-label"></label>
                            <div class="col-sm-12">
                                <button type="submit" id="theLocationModalSubmitBtn"
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
