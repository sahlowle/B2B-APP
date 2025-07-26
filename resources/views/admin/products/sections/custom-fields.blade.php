@if (App\Models\CustomField::active()->where(['field_to' => 'products'])->count())
    <div class="show-custom-fields-main-section card-border mini-form-holder mt-2 card section pb-20-res transition-none option-value-rowid ui-sortable-handle common_c">
        <div class="card-header cursor-pointer d-flex align-items-center justify-content-between head-click" data-bs-toggle="collapse" href="#custom_fields">
            <p class="mb-0 add-title">{{ __('Custom Fields') }}</p>
            <div class="d-flex justify-content-end align-items-center">
                <span class="cursor-move mt-0">
                    <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="16" height="1" fill="#898989"></rect>
                        <rect y="5" width="16" height="1" fill="#898989"></rect>
                        <rect y="10" width="16" height="1" fill="#898989"></rect>
                    </svg>
                </span>
                <span class="toggle-btn mt-0 icon-collapse ltr:ms-3 rtl:me-3">
                    <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.18767 0.0921111L7.81732 4.65639C8.24162 5.18994 7.87956 6 7.21678 6L0.783223 6C0.120445 6 -0.241618 5.18994 0.182683 4.65639L3.81233 0.092111C3.91 -0.0307037 4.09 -0.0307036 4.18767 0.0921111Z"
                            fill="#2C2C2C"></path>
                    </svg>
                </span>
            </div>
        </div>

        <div id="custom_fields" class="collapse show pb-11p txt-enable blockable">
            <div class="card-body mt-20p px-3-res px-32p">
                <div class="row pb-20p">
                    <div class="col-sm-12">
                        @include('admin.custom_fields.includes.form', ['fieldTo' => 'products', 'labelColumn' => 2, 'visibility' => isset($product) ? 'edit_form' : 'create_form', 'relId' => isset($product) ? $product->id : null])
                        
                        <div class="form-group row">
                            <div class="col-sm-4 offset-sm-2 mt-2">
                                <a class="btn-confirms custom-fields-update" type="submit">{{ __('Save') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
