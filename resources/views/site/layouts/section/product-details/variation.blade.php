@php $stockDisplayFormat = preference('stock_display_format'); $lowStockThreshold = $product->getStockThreshold() @endphp
@if($product->isVariableProduct() && is_array($filterVariation) && count($filterVariation) > 0)
    @php $count = 0 ; $position = 1; @endphp
    @foreach ($filterVariation['attrbuteIdsWithKey'] as $key => $attrbuteIdWithKey)
    
    <div class="flex mt-4 md:mt-3 option-select items-center">
        <h4 class="text-gray-12 text-sm font-medium roboto-medium ltr:mr-2 rtl:ml-2 w-1/5"> {{ $attributes[$key]['name'] }}</h4>
        @if(isset($attributes[$key]['type']) && $attributes[$key]['type'] == 'color')
        <span class="color-options">
            @if($attributes[$key]['additional_value'])
                @foreach($attributes[$key]['additional_value'] as $cdk=>$value)
                    @php
                        $backValue = $attributes[$key]['value'][$cdk];
                    @endphp
                    <input type="radio" name="option[{{$key}}]" value="{{ $attributes[$key]['value'][$cdk] }}" {{isset($default_attributes[$key]) && $default_attributes[$key] == $backValue ? 'checked' : ''}}  class="custombox-selected cursor-pointer item-variations {{ $attributes[$key]['attribute_shape'] == 'square' ? 'square' : ''}}" data-id="{{ $attributes[$key]['value'][$cdk] }}" data-position="{{ $position }}" style="background: {{ $value }}">
                @endforeach
            @elseif($attributes[$key]['attribute_id'])
                @foreach($attributes[$key]['value'] as $dck=>$value)
                @php
                    if(isset($attribute_values[$key])){
                        $details = $attribute_values[$key]->where('id', $value)->first();
                        $backValue = isset($details) ? $details->id : $value;
                    }else{
                        $details = null;
                    }
                @endphp
                <input type="radio" name="option[{{$key}}]" value="{{ $details->value }}" data-id="{{ $details->id }}" data-position="{{ $position }}"  {{isset($default_attributes[$key]) && $default_attributes[$key] == $backValue ? 'checked' : ''}}  class="custombox-selected cursor-pointer item-variations {{$attributes[$key]['attribute_shape'] == 'square' ?? 'square'}}" style="background: {{ $details->additional_values }}">
            @endforeach       
            @endif
        </span>
        @else
        <select name="option[]" class="required-option custombox-selected outline-none rounded border border-gray-2 block whitespace-no-wrap text-gray-10 text-sm font-medium roboto-medium bg-white w-36 z-0 cursor-pointer item-variations">
            <option class="border-none item-variation-option" data-position ="{{ $position }}" value="">{{ __('Select One') }}</option>
            @foreach ($attrbuteIdWithKey as $value)
                @if($value != '')
                        @php
                            if (isset($attribute_values[$key])) {
                                $details = $attribute_values[$key]->where('id', $value)->first();
                            } else {
                                $details = null;
                            }
                            $backValue = isset($details) ? $details->id : $value;
                        @endphp
                    <option class="border-none" value="{{ isset($details) ? $details->value : $value }}" data-id="{{ isset($details) ? $details->id : $value }}" {{ isset($default_attributes[$key]) && $default_attributes[$key] == $backValue ? 'selected' : '' }} data-position = "{{ $position }}">{{ isset($details) ? $details->value : $value }}</option>
                @endif
            @endforeach
        </select>
        @endif
    </div>
    @php $position++; @endphp

    @endforeach

    <label class="error display-none" id="availability">{{ __('Not Available') }}</label>
   <div class="flex justify-between items-center mt-22p ltr:mr-10 rtl:ml-10">
        <div class="flex justify-start items-center">
            <span class=" text-gray-12 text-sm roboto-medium leading-4 font-medium" id="{{ $stock_status == 'Out Of Stock' ? '' : 'stock_qty' }}">
                <span class="text-reds-3 leading-4 bg-pinks-2 px-4 py-2 text-sm roboto-medium font-medium rounded capitalize">{{ __('Out Of Stock') }}</span>
            </span>
        </div>
        <a href="javascript:void(0)" class="flex justify-start items-center display-none" id="clear-variation">
            <span class="text-gray-10 text-sm roboto-medium leading-4 font-medium ltr:mr-1 rtl:ml-1">{{ __('Clear') }}</span>
        <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.8617 9.52856L9.80451 10.4714L7.60925 12.6666L9.80451 14.8619L8.8617 15.8047L5.72363 12.6666L8.8617 9.52856Z" fill="#898989"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7078 5.08931C11.3889 5.2734 11.2797 5.68113 11.4638 5.99999C11.8148 6.60807 11.9997 7.29784 11.9997 7.99999C11.9997 8.70214 11.8148 9.39191 11.4638 9.99999C11.1127 10.6081 10.6078 11.113 9.99967 11.4641C9.3916 11.8152 8.70182 12 7.99967 12C7.63149 12 7.33301 12.2985 7.33301 12.6667C7.33301 13.0348 7.63149 13.3333 7.99967 13.3333C8.93587 13.3333 9.85557 13.0869 10.6663 12.6188C11.4771 12.1507 12.1504 11.4774 12.6185 10.6667C13.0866 9.85589 13.333 8.93619 13.333 7.99999C13.333 7.06379 13.0866 6.14409 12.6185 5.33332C12.4344 5.01446 12.0267 4.90521 11.7078 5.08931Z" fill="#898989"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.1383 6.47144L6.19549 5.52863L8.39075 3.33336L6.19549 1.1381L7.1383 0.195293L10.2764 3.33336L7.1383 6.47144Z" fill="#898989"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.29221 10.9107C4.61107 10.7266 4.72032 10.3189 4.53622 10C4.18515 9.39193 4.00033 8.70216 4.00033 8.00001C4.00033 7.29786 4.18515 6.60809 4.53622 6.00001C4.8873 5.39193 5.39225 4.88698 6.00033 4.53591C6.6084 4.18484 7.29818 4.00001 8.00033 4.00001C8.36851 4.00001 8.66699 3.70153 8.66699 3.33334C8.66699 2.96515 8.36851 2.66668 8.00033 2.66668C7.06413 2.66668 6.14443 2.91311 5.33366 3.38121C4.52289 3.84931 3.84962 4.52257 3.38152 5.33334C2.91343 6.14411 2.66699 7.06381 2.66699 8.00001C2.66699 8.93621 2.91343 9.85591 3.38152 10.6667C3.56562 10.9855 3.97335 11.0948 4.29221 10.9107Z" fill="#898989"/>
            </svg></span>
        </a>
   </div>
@elseif ($is_show_stock_status)
    @if ($stock_status == 'In Stock')
        <div class="mt-22p">
            <span class="text-gray-12 text-sm roboto-medium leading-4 font-medium ltr:ml-1 rtl:mr-1" id="stock_qtyV"> <span class="text-green-1 leading-4 bg-green-2 px-4 py-2 text-sm roboto-medium font-medium rounded ltr:mr-2.5 rtl:ml-2.5">{{ __('In Stock') }}</span></span>
            @if ($is_show_stock_quantity)
                <span class="ml-1">{{ __(':x items remaining', ['x' => $stock_quantity]) }}</span>
            @endif
        </div>
    @else
        <div Class="mt-22p">
            <span class="text-reds-3 mr-1 leading-4 bg-pinks-2 px-4 py-2 text-sm roboto-medium font-medium rounded" id="stock_qty">{{ __('Out Of Stock') }}</span>
        </div>
    @endif
@endif


@if(!empty($product->regular_price))
    @php
        $getB2BData = $product->getB2BData()
    @endphp
    @if(is_array($getB2BData) && count($getB2BData) > 0 && !$product->isVariableProduct() && $product->isEnableB2B())
        <table class="text-left w-full border-collapse border text-sm md:text-13 mt-10p" id="b2b-table">
            <tbody class="text-gray-10 roboto-medium">
            <th class="py-4 px-6 border">{{ __('Min Qty') }}</th>
            <th class="py-4 px-6 border">{{ __('Max Qty') }}</th>
            <th class="py-4 px-6 border">{{ count($getB2BData) == 1 ? __('B2B price') : __('B2B prices') }}</th>
            @foreach($getB2BData as $b2b)
                @if(!empty($b2b['min_qty']) && !empty($b2b['max_qty']) && !empty($b2b['price']))
                    <tr class="py-4 px-6 border b2b_table">
                        <td class="py-4 px-6 border">{{ $b2b['min_qty'] }}</td>
                        <td class="py-4 px-6 border">{{ $b2b['max_qty'] }}</td>
                        <td class="py-4 px-6 border">{{ $b2b['price'] }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif
@endif



