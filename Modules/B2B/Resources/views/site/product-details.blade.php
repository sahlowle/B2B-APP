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
