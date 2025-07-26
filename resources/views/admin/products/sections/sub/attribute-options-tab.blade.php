<div class="tab-pane fade pb-28p pb-4" id="tabs-i" role="tabpanel" aria-labelledby="tabs-9">
    <div class="mt-3 mx-2 mx-9r-res pb-3">
        <div class="text-right">
            <div class="mt-10-res">
                <p class="mb-0 f-12 font-italic">
                    <span class="attribute-count pe-2">{{ isset($product) && isset($product->attributes) ? count($product->attributes) : 0 }}</span>{{ __('attributes') }} (
                    <span class="cursor-pointer color-A9 collapse-expand">{{ __('Expand') }}</span> /
                    <span class="cursor-pointer color-9E collapse-collapse">{{ __('Close') }}</span> )
                </p>
            </div>
        </div>
    </div>

    <div class="attribute_sortable put-attrs attribute-parent-box attribute-option-item-lists drag_and_drop ui-sortable">
        @include('admin.products.pieces.attribute-options')
    </div>

    <div class="mt-25p mx-7p px-6 border-t mx-25n px-32p">
        <a href="javascript:void(0)" class="w-175p btn-confirms mt-24p save_attributes">{{ __('Save') }}</a>
    </div>
</div>
