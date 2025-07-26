@if (isset($product) && isset($product->attributes) && is_array($product->attributes))
    @foreach ($product->attributes as $key => $productAttr)
        <div class="attribute-dlt" data-serial="{{ $loop->index }}">
            <div class="d-flex justify-content-between align-items-center border-t h-40p mx-25n px-32p bg-F5 col-attr collapse-header"
                data-bs-toggle="collapse" href="#{{ $unid = 'col_' . uniqid() }}">
                <p class="label-title m-0 ml-16n-res font-weight-600 attribute-box-title">{{ $productAttr['name'] }}</p>
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
                    <div class="col-md-12 p-0 mt-3">
                        @if(isset($productAttr['type']) && $productAttr['type'] == 'color')
                            <div class="col-md-6 p-0">
                                <div class="form-group mb-2 mr-2">
                                    <label class="control-label gray-89">{{ __('Shape') }}</label>
                                    <select name="attribute_shape[{{ $loop->index }}]" class="form-control select2">
                                        <option {{ isset($productAttr['attribute_shape']) && $productAttr['attribute_shape'] == 'circle' ? 'selected' : '' }}  value="circle">{{ __("Circle") }}</option>
                                        <option {{ isset($productAttr['attribute_shape']) && $productAttr['attribute_shape'] == 'square' ? 'selected' : '' }} value="square">{{ __("Square") }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            
                            <div class="col-md-9 mt-5 pt-2">
                                <div class="color-custom-attributes">
                                    <div class="table-responsive">
                                        <table class="options table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>{{ __('Value') }}</th>
                                                <th>{{ __('Color Code') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $parentKey = $loop->index;
                                                @endphp
                                                @foreach($productAttr['value'] as $ckey=>$colorValue)
                                                    <tr>
                                                        @if ($productAttr['attribute_id'])
                                                            @php
                                                                $attrValue = App\Models\AttributeValue::where('id', $colorValue)->first();
                                                                
                                                                if (!$attrValue) {
                                                                    continue;
                                                                }
                                                            @endphp
                                                            <td width="60%">
                                                                <div class="form-group">
                                                                    <input type="text" value="{{  $attrValue->value }}" class="form-control inputFieldDesign" disabled required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" value="{{ isset($productAttr['additional_value'][$loop->index]) && trim($productAttr['additional_value'][$loop->index]) != NULL ? $productAttr['additional_value'][$loop->index] : $attrValue->additional_values }}" name="additional_color_values[{{$parentKey}}][{{$loop->index}}]" class="form-control demo inputFieldDesign">
                                                                </div>
                                                        </td>
                                                        @else
                                                            <td width="60%">
                                                                <div class="form-group">
                                                                    <input type="text" value="{{ $productAttr['value'][$loop->index] }}" class="form-control inputFieldDesign" disabled required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"> 
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" value="{{ isset($productAttr['additional_value'][$loop->index]) ? $productAttr['additional_value'][$loop->index] : "" }}" name="additional_color_values[{{$parentKey}}][{{$loop->index}}]" class="form-control demo inputFieldDesign">
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-disable">{{ __("No option found for this attribute.") }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

