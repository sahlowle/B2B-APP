<div class="card blockable">
    <div class="order-sec-head cursor-pointer d-flex justify-content-between align-items-center border-bottom px-3 head-click" data-bs-toggle="collapse" href="#additional_info">
        <span class="add-title text-lg">{{ __('Additional Info') }}</span>
        <span class="toggle-btn mt-0 icon-collapse">
            <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                    fill="#2C2C2C"></path>
            </svg>
        </span>
    </div>

    <div id="additional_info" class="mini-form-holder form-group row px-7 mb-0 collapse show">
        <div class="col-md-12">
            <div class="mx-8p">
                <label for="brand" class="sp-title mt-20p">{{ __('Brand') }}</label>
                <select class="form-control select2clearable" name="brand_id">
                    <option value="">{{ __('Select Brand') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($isAdmin)
        <div class="col-md-12">
            <div class="mx-8p">
                <label for="vendor" class="sp-title mt-16p">{{ __('Vendor') }}</label>
                <select class="form-control select2clearable sl_common_bx" name="vendor_id" id="vendor_id">
                    <option value="">{{ __('Select Vendor') }}</option>
                    @if(isActive('Disablemultivendor') && preference('is_active_single_vendor') == 1 && isset(auth()->user()->vendor()->vendor_id))
                        <option value="{{ isset($product) && !is_null($product->vendor_id) ? $product->vendor_id : auth()->user()->vendor()->vendor_id }}" selected>
                            {{ auth()->user()->vendor()->vendor->name }}
                        </option>
                    @else
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}"
                                {{ isset($product) && $product->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}</option>
                        @endforeach
                    @endif
                </select>
                @if(isActive('Disablemultivendor') && preference('is_active_single_vendor') == 1 && !isset(auth()->user()->vendor()->vendor_id))
                    <div class="noti-alert pad no-print mt-5">
                        <div class="alert alert-danger fade show d-flex justify-content-between align-items-center">
                            <strong>{{ __('Switch Multi-vendor & Please create a vendor & assign to admin, otherwise stock/inventory will not working. Once created you can switch single vendor again.') }}
                                <a href="{{ route('disable.multivendor.config') }}" target="_blank">{{ __('Enable/Disable Multi-vendor') }}</a><br>
                                <a href="{{ route('vendors.create') }}" target="_blank">{{ __('Create Vendor') }}</a><br>
                                <a href="{{ route('location.create') }}" target="_blank">{{ __('Create Location') }}</a>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    
                @endif
            </div>
        </div>
        @endif

        <div class="d-flx ltr:ms-2 rtl:me-2 align-items-center b-res t-25-res pb-25p">
            <a class="btn-confirms save-brand-info">{{ __('Save') }}</a>
        </div>
    </div>


</div>
