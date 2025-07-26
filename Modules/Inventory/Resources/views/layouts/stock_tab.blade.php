<div class="tab-pane fade pb-28p pb-4" id="tabs-stock" role="tabpanel" aria-labelledby="tabs-6">
    <div class="mx-2 mx-9r-res">
        <div class="d-flex col-reverse align-unset justify-content-between align-items-center">
            <div class="d-flx d-flx-n mt-10-res">
                <div class="w-320p w-n">
                    <p id="stock_msg">{{ __('Vendor stock will show here for each location.') }}</p>
                </div>
            </div>

            <div class="mt-10-res">
                <p class="mb-0 f-12 font-italic">
                    <span class="cursor-pointer color-A9 collapse-expand">{{ __('Expand') }}</span> /
                    <span class="cursor-pointer color-9E collapse-collapse">{{ __('Close') }}</span> )
                </p>
            </div>
        </div>
    </div>


    <div class="attribute_sortable put-attrs drag_and_drop ui-sortable location_tab" id="location_tab">
        @include('inventory::layouts.pieces.location_stock')
    </div>


    <div class="mt-25p mx-7p px-6 border-t mx-25n px-32p {{ isset($product) ? 'display_none' : ''}}" id="save_stock_div">
        <a href="javascript:void(0)" class="w-175p btn-confirms mt-24p save_stock" id="save_stock">{{ __('Save Stock') }}</a>
    </div>


</div>

<script>
    var vendorLocationUrl = '{{ request()->route()->getName() == 'vendor.product.create' || request()->route()->getName() == 'vendor.product.edit'  ? route('vendor.vendorLocation.index') : route('vendorLocation.index') }}';
    var stockProductId = '{{ isset($product) ? $product->id : '' }}';
    var currentRouteName = '{{ request()->route()->getName() }}';
    var loginUserVendorId = '{{ auth()->user()?->vendor()?->vendor_id }}';
</script>
