@php
    $variationStocks = $variation->getInventoryStock();
    $isEmptyVendor = null;
@endphp
<div class="form-group row mt-20p">
    
    <div class="col-md-12">
        <div>
            <div class="table-responsive">
                @if(isset($variation) && count($variationStocks['stocks']) == 0 && count($variationStocks['locations']) == 0)
                    @php
                        $variationStocks = \Modules\Inventory\Entities\StockManagement::getVendorLocationStock($variation->id, $variation->parentDetail?->vendor_id);
                        $isEmptyVendor = $variation->parentDetail->vendor_id;
                    @endphp
                @elseif(count($variationStocks['stocks']) > 0 || count($variationStocks['locations']) > 0)
                    @php $isEmptyVendor = $variation->parentDetail->vendor_id @endphp
                @endif
                <table class="options table table-bordered t-table">
                    <thead class="t-heads">
                    <tr>
                        <th  class="label">{{ __('Location') }}</th>
                        <th>{{ __('Available') }}</th>
                        @if(count($variationStocks['stocks']) > 0)
                        <th>{{ __('Adjust by') }}</th>
                        <th>{{ __('New') }}</th>
                        <th>{{ __('Reason') }}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody id="variation_stock_data_{{ $variation->id }}" class="drag_and_drop ui-sortable variation_stock_data">
                    @if(is_null($isEmptyVendor))
                        <tr draggable="false" class="ui-sortable-handle empty_vendor">
                            <td colspan="3">{{ __('Please select & save vendor before save variations.') }}</td>
                        </tr>
                    @elseif(count($variationStocks['stocks']) == 0 && count($variationStocks['locations']) == 0 && !is_null($isEmptyVendor))
                        <tr draggable="false" class="ui-sortable-handle stock_msg">
                            <td colspan="3">{{ __('Location not found! Please create location for this vendor.') }}</td>
                        </tr>
                    @endif
                   
                   @foreach($variationStocks['stocks'] as $stKey => $stock)
                       @php  $unidVar = 'var_' . uniqid(); @endphp
                       <tr draggable="false"
                           class="ui-sortable-handle variation_stock">
                           <td class="label">
                               <div class="d-flex align-items-center rtl:gap-2">
                                   <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <rect width="16" height="1" fill="#898989">
                                       </rect>
                                       <rect y="5" width="16" height="1" fill="#898989">
                                       </rect>
                                       <rect y="10" width="16" height="1" fill="#898989">
                                       </rect>
                                   </svg>
                                   <input type="hidden" name="adjust[{{$idx}}][{{ $stock->id }}][product_id]" value="{{ $variation->id }}">
                                   <input type="hidden" name="adjust[{{$idx}}][{{ $stock->id }}][location_id]" value="{{ $stock->location_id }}">
                                   
                                   <label class="control-label">{{ $stock->location->name }}</label>
                               </div>
                           </td>
                           <td>
                               <label class="control-label" id="available_stock_{{$unidVar}}">{{ intval($stock->available) }}</label>
                           </td>
                           <td>
                               <input type="number" placeholder="0" class="form-control inputFieldDesign adjust_by" maxlength="8" id="adjust_by_{{$unidVar}}" data-rowId="{{$unidVar}}" name="adjust[{{$idx}}][{{ $stock->id }}][adjust_by]" value="0">
                           </td>
                           <td>
                               <input type="number" placeholder="0" class="form-control inputFieldDesign new_stock" maxlength="8" id="new_stock_{{$unidVar}}" data-rowId="{{$unidVar}}" name="adjust[{{$idx}}][{{ $stock->id }}][new]" value="{{ intval($stock->available) }}">
                           </td>
                           <td>
                               <select class="form-control select2 sl_common_bx" name="adjust[{{$idx}}][{{ $stock->id }}][reason]" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                   <option value="Correction">{{ __('Correction') }}</option>
                                   <option value="Count">{{ __('Count') }}</option>
                                   <option value="Received">{{ __('Received') }}</option>
                                   <option value="Return_restock">{{ __('Return restock') }}</option>
                                   <option value="Damaged">{{ __('Damaged') }}</option>
                                   <option value="Theft_or_loss">{{ __('Theft or loss') }}</option>
                                   <option value="Promotion_or_donation">{{ __('Promotion or donation') }}</option>
                               </select>
                           </td>
                       </tr>
                   @endforeach
                   @foreach($variationStocks['locations'] as $location)
                    <tr draggable="false"
                        class="ui-sortable-handle downloadable-row variation_stock">
                        <td class="label">
                            <div class="d-flex align-items-center rtl:gap-2">
                                <svg class="me-2" width="16" height="11" viewBox="0 0 16 11"
                                     fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="5" width="16" height="1" fill="#898989">
                                    </rect>
                                    <rect y="10" width="16" height="1" fill="#898989">
                                    </rect>
                                </svg>
                                <label class="control-label">{{ $location->name }}</label>
                                <input type="hidden" name="location[{{$idx}}][{{ $location->id }}][id]" value="{{ $location->id }}">
                            </div>
                        </td>
                        <td>
                            <input type="number" placeholder="0" class="form-control inputFieldDesign adjust_by" maxlength="8" name="location[{{$idx}}][{{ $location->id }}][qty]" value="0">
                        </td>
                    </tr>
                   @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


