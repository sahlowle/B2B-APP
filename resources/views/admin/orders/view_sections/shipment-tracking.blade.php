@if(!preference('product_label_wise_shipment_track') && preference('shipping_provider'))
<div class="card">
    <div class="order-sections-header accordion cursor_pointer">
        <span>{{ __('Shipment Tracking') }}</span>
        <span class="order-icon drop-down-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                <path d="M3.33579 4.92324L0.159846 1.11968C-0.211416 0.675046 0.105388 -4.81444e-07 0.685319 -5.06793e-07L6.31468 -7.52861e-07C6.89461 -7.7821e-07 7.21142 0.675045 6.84015 1.11968L3.66421 4.92324C3.57875 5.02559 3.42125 5.02559 3.33579 4.92324Z" fill="#2C2C2C"/>
            </svg>
        </span>
    </div>
    @php
        $orderShippingTrack = $shippingTracks->where('track_type','order')->first();
    @endphp
    
    <div class="order-sections-body order-shipment-tracking-container">
        <div class="add-shipment_track-container">
                <div class="form-group row">
                    <label for="name" class="control-label require ltr:ps-3 rtl:pe-3">{{ __('Choose Provider') }}
                    </label>
                    <div class="col-sm-12">
                        <select class="form-control select-provider select2 sl_common_bx" id="shipping_provider_id" name="shipping_provider_id">
                            @if(isset(optional($orderShippingTrack)->shipping_provider_id))

                                @if (optional($orderShippingTrack)->shipping_provider_id != 0)
                                    <option data-image="{{ optional(optional($orderShippingTrack)->shippingProvider)->fileUrl() }}" value="{{ optional($orderShippingTrack)->shipping_provider_id }}">
                                        {{ optional($orderShippingTrack)->provider_name }}
                                    </option>
                                @endif
                                
                                @if (optional($orderShippingTrack)->shipping_provider_id == 0)
                                    <option data-image="{{asset(defaultImage('default'))}}" value="0">
                                        {{ optional($orderShippingTrack)->provider_name  }}
                                    </option>
                                @endif
                                
                            @endif
                            {{-- Provider load by ajax --}}
                        </select>
                        <small class="form-text text-muted">{{ __("Select the provider responsible for shipment.") }}</small>
                    </div>
                </div>

                <div class="form-group row {{optional($orderShippingTrack)->shipping_provider_id != 0 ? 'd-none': '' }}" id="custom_provider_name">
                    <label for="provider_name" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Provider Name') }}</label>
                    <div class="col-sm-12">
                        <input type="hidden" name="track_type" value="order" id="track_type">
                        <input type="text" class="form-control inputFieldDesign" value="{{optional($orderShippingTrack)->provider_name}}" name="provider_name" id="provider_name" placeholder="{{ __('Provider Name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tracking_number" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Tracking Number') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{optional($orderShippingTrack)->tracking_no}}" name="tracking_number" id="tracking_number" placeholder="{{ __('Tracking No') }}">
                        <input type="hidden" id="tracking_base_url" value="{{optional(optional($orderShippingTrack)->shippingProvider)->tracking_base_url}}">
                        <p class="ml-5p m-change mt-2 mb-0 {{ optional(optional($orderShippingTrack)->shippingProvider)->tracking_url_method == 'Post' || optional($orderShippingTrack)->shipping_provider_id == 0 ? 'd-none' : '' }}" id="generate_track_link">{{ __("Update Tracking Link") }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tracking_link" class="control-label ltr:ps-3 rtl:pe-3 require">{{ __('Tracking Link') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control inputFieldDesign" value="{{optional($orderShippingTrack)->tracking_link}}" name="tracking_link" id="tracking_link" placeholder="{{ __('Tracking Link') }}">
                        <a class="m-change mt-5 mb-0"  href="{{optional($orderShippingTrack)->tracking_link}}" target="_blank" id="preview_link">{{ __('Preview Link') }}</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="order_shipped_date" class="control-label ltr:ps-3 rtl:pe-3">{{ __('Date Shipped') }}</label>
                    <div class="col-sm-12">
                        <input type="hidden" name="track_type" id="track_type" value="order">
                        <input type="hidden" name="product_id" id="product_id">
                        <input type="text" class="form-control inputFieldDesign" id="order_shipped_date" value="{{ optional($orderShippingTrack)->order_shipped_date }}" name="order_shipped_date" placeholder="{{ __('Date') }}">
                    </div>
                </div>
                <div class="add-note-text-field">
                    <div class="trash-update">
                        <button class="w-100" id="updateOrderTrack">{{ __('Save Tracking') }}</button>
                    </div>
                </div>
        </div>
    </div>
</div>
@endif
