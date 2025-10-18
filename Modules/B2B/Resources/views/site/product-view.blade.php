@if(!empty($product->regular_price))
    @if(!$product->isVariableProduct() && $product->isEnableB2B())
        <table class="text-left w-full border-collapse border text-sm md:text-13 mt-10p">
            <tbody class="text-gray-10 roboto-medium">
            <th class="py-4 px-6 border">{{ __('Min Qty') }}</th>
            <th class="py-4 px-6 border">{{ __('Max Qty') }}</th>
            <th class="py-4 px-6 border">{{ __('B2B prices') }}</th>
            @foreach($product->getB2BData() as $b2b)
                @if(!empty($b2b['min_qty']) && !empty($b2b['max_qty']) && !empty($b2b['price']))
                    <tr class="py-4 px-6 border">
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
