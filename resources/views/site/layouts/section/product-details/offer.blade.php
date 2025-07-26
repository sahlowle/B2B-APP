@if(!$product->isGroupedProduct() && !$product->isExternalProduct())
    <div id="countDown" class="display-none">
        <p class="text-sm mt-1.5 pt-1p dm-sans font-medium text-gray-12">{{ __('Offer end in') }}:</p>
        <div class="w-full flex roboto-medium mt-3">
            <div class="border border-dashed border-gray-12 rounded primary-bg-color">
                <p class="text-center px-2 text-sm text-black py-1" id="count_days">

                </p>
            </div>
            <div class="border border-dashed border-gray-12 rounded primary-bg-color ltr:ml-2.5 rtl:mr-2.5">
                <p class="text-center px-2 text-sm text-black py-1" id="count_others">

                </p>
            </div>
        </div>
    </div>
@endif
<div class="md:mt-3 mt-2">
    <p class="dm-bold font-700">
        @if(!$product->isGroupedProduct())
            @if($product->isVariableProduct())
                @php
                    $sale_price = $sale_price[0] ?? $sale_price;
                    $regular_price = $regular_price[0] ?? $regular_price;
                @endphp
                <span class="text-2.5xl text-gray-12" id="varMinMaxPrice">{{ multiCurrencyFormatNumber($filterVariation['min']) }} - {{ multiCurrencyFormatNumber($filterVariation['max']) }}</span>
            @endif
                <span class="text-2.5xl text-gray-12 {{ $product->isVariableProduct() ? "display-none" : '' }}" id="item_price">{{ $offerFlag ? multiCurrencyFormatNumber($product->priceWithTax($displayPrice, 'sale', false)) : multiCurrencyFormatNumber($product->priceWithTax($displayPrice, 'regular', false)) }}</span>
                <span class="text-28 text-gray-10 display-none">/</span>
            @if($offerFlag || $product->isVariableProduct())
                <span class="text-gray-10 line-through {{ $product->isVariableProduct() ? "display-none" : '' }}" id="item_offer_price">{{ multiCurrencyFormatNumber($product->priceWithTax($displayPrice, 'regular', false)) }}</span>
            @endif
        @elseif($product->isGroupedProduct())
            <span class="text-gray-12 text-28 leading-6">{{ multiCurrencyFormatNumber($groupProducts['min']) }} - {{ multiCurrencyFormatNumber($groupProducts['max']) }}</span> </br>
        @endif
    </p>
    <div class="product-view-summary text-gray-10 roboto-medium mt-2">
        <div class="main-summary">
            {{ $summary }}
        </div>
        <div class="variation display-none"></div>
    </div>
</div>
