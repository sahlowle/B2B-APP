@if(isset($product))
    @php
        $stocks = $product->getInventoryStock();
    @endphp
    @if(count($stocks['stocks']) > 0 || count($stocks['locations']) > 0)
        @foreach($stocks['stocks'] as $key => $stock)
            <div class="location-dlt" data-serial="{{ $loop->index }}" id="adjust_stock_div_{{$loop->index}}">
                <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
                     data-bs-toggle="collapse" href="#{{ $unid = 'col_' . uniqid() }}">
                    <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">{{ $stock->location->name }}</p>
                    <div class="d-flex align-items-center">
                        <svg class="cursor-move mt-0" width="16" height="11" viewBox="0 0 16 11" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="1" fill="#898989" />
                            <rect y="5" width="16" height="1" fill="#898989" />
                            <rect y="10" width="16" height="1" fill="#898989" />
                        </svg>
                        <span
                            class="toggle-btn ml-10p mt-0 d-flex h-20 w-20 align-items-center justify-content-center inactive-sec collapsed"
                            data-bs-toggle="collapse" href="#{{ $unid }}">
                            <svg width="8" height="6" viewBox="0 0 8 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.18767 5.90789L7.81732 1.34361C8.24162 0.810056 7.87956 -1.43628e-09 7.21678 -9.33983e-09L0.783223 -8.60592e-08C0.120445 -9.39628e-08 -0.241618 0.810055 0.182683 1.34361L3.81233 5.90789C3.91 6.0307 4.09 6.0307 4.18767 5.90789Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </span>
                        
                    </div>
                </div>
                <div class="collapse" id="{{ $unid }}">
                    <div class="row m-0 px-7 pb-30p">
                            
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="location_id" value="{{ $stock->location_id }}">
                        <input type="hidden" name="row_id" value="{{ $loop->index }}">

                        <div class="form-group row">
                            <label class="col-sm-6 control-label" for="inputEmail3">{{ __('Available') }}</label>

                            <label class="col-sm-6 control-label" for="inputEmail3" id="available_stock_{{$unid}}">{{ intval($stock->available) }}</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require" for="inputEmail3">{{ __('Adjust By') }}</label>

                            <div class="col-sm-6">
                                <input type="number" placeholder="{{ __('Adjust By') }}" value="0" class="form-control adjust_by inputFieldDesign adjust_by" name="adjust_by" id="adjust_by_{{$unid}}" data-rowId="{{$unid}}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require" for="inputEmail3">{{ __('New') }}</label>

                            <div class="col-sm-6">
                                <input type="number" placeholder="{{ __('New') }}" value="{{ intval($stock->available) }}" class="form-control new inputFieldDesign new_stock" name="new" id="new_stock_{{$unid}}" data-rowId="{{$unid}}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-6 control-label require pr-0 "
                                   for="inputEmail3">{{ __('Reason') }}</label>
                            <div class="col-sm-6">
                                <select class="form-control select2 sl_common_bx" name="reason" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value="Correction">{{ __('Correction') }}</option>
                                    <option value="Count">{{ __('Count') }}</option>
                                    <option value="Received">{{ __('Received') }}</option>
                                    <option value="Return_restock">{{ __('Return restock') }}</option>
                                    <option value="Damaged">{{ __('Damaged') }}</option>
                                    <option value="Theft_or_loss">{{ __('Theft or loss') }}</option>
                                    <option value="Promotion_or_donation">{{ __('Promotion or donation') }}</option>
                                </select>
                            </div>
                        </div>


                        <div class="mt-25p mx-7p px-6 border-t mx-25n px-32p">
                            <a href="javascript:void(0)" class="w-175p btn-confirms mt-24p update_adjust" data-rowId="{{ $loop->index }}">{{ __('Update') }}</a>
                        </div>
          
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($stocks['locations'] as $key => $location)
            <div class="location-dlt initial_stock_div" data-serial="{{ $loop->index }}">
                <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
                     data-bs-toggle="collapse" href="#{{ $unid = 'col_' . uniqid() }}">
                    <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">{{ $location->name }}</p>
                    <div class="d-flex align-items-center">
                        <svg class="cursor-move mt-0" width="16" height="11" viewBox="0 0 16 11" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="1" fill="#898989" />
                            <rect y="5" width="16" height="1" fill="#898989" />
                            <rect y="10" width="16" height="1" fill="#898989" />
                        </svg>
                        <span
                            class="toggle-btn ml-10p mt-0 d-flex h-20 w-20 align-items-center justify-content-center inactive-sec collapsed"
                            data-bs-toggle="collapse" href="#{{ $unid }}">
                            <svg width="8" height="6" viewBox="0 0 8 6" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.18767 5.90789L7.81732 1.34361C8.24162 0.810056 7.87956 -1.43628e-09 7.21678 -9.33983e-09L0.783223 -8.60592e-08C0.120445 -9.39628e-08 -0.241618 0.810055 0.182683 1.34361L3.81233 5.90789C3.91 6.0307 4.09 6.0307 4.18767 5.90789Z"
                                    fill="#2C2C2C" />
                            </svg>
                        </span>

                    </div>
                </div>
                <div class="collapse" id="{{ $unid }}">
                    <div class="row m-0 px-7 pb-30p">
                      

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="location_id" value="{{ $location->id }}">

                            <div class="form-group row mt-3">
                                <label class="col-sm-6 control-label" for="inputEmail3">{{ __('Available') }}</label>
                                <input type="hidden" value="{{ $location->id }}" name="location[{{$location->id}}][id]">
                                <div class="col-sm-6">
                                <input type="number" placeholder="{{ __('Available') }}" value="0" class="form-control adjust_by inputFieldDesign" name="location[{{$location->id}}][qty]" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endif
