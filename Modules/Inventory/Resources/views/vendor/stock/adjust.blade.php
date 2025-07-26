@extends('vendor.layouts.app')
@section('page_title', __('Adjust stock'))
@section('css')

@endsection

@section('content')

    <div class="col-sm-12" id="product-adjust-container">

        <form action="{{ route('vendor.inventory.adjust') }}" method="post">
            @csrf
            @php 
            $totalUnavailable = abs($stock->unAvailable()['total_unavailable']);
            @endphp
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Adjust stock') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Product') }}
                                    </label>
                                    <div class="col-md-8">
                                        <input class="form-control inputFieldDesign" value="{{ $product->name }}" type="text" readonly required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <input value="{{ $product->id }}" name="product_id" type="hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4">{{ __('Location') }}</label>
                                    <div class="col-md-8">
                                        <input class="form-control inputFieldDesign" value="{{ $location->name }}" type="text" readonly required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                        <input value="{{ $location->id }}" name="location_id" type="hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4" id="availabe_lbl">{{ __('Available stock') }}</label>
                                    <div class="col-md-8">
                                        <input class="form-control inputFieldDesign" value="{{ $stock->available }}" type="text" readonly id="available">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Adjust Type') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="adjust_type" id="adjust_type" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                            <option value="adjust">{{ __('Adjust')  }}</option>
                                            <option value="unavailable">{{ __('Move to unavailable')  }}</option>
                                            <option value="available">{{ __('Move unavailable to available')  }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require" id="reason_lbl">{{ __('Reason') }}</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2 sl_common_bx" name="reason" id="reason" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-4 require">{{ __('Quantity') }}</label>
                                    <div class="col-md-8">
                                        <input class="form-control inputFieldDesign inputQty" value="0" type="number" name="quantity" id="quantity" min="-{{ formatCurrencyAmount($stock->available) }}" required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-10 px-0 mt-3 mt-md-0">
                    <a href="{{ route('vendor.inventory.index') }}"
                       class="btn custom-btn-cancel all-cancel-btn">{{ __('Cancel') }}</a>
                    <button class="btn custom-btn-submit" type="submit" id="btnSubmit"><i
                            class="comment_spinner spinner fa fa-spinner fa-spin custom-btn-small display_none"></i><span
                            id="spinnerText">{{ __('Update') }}</span></button>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('js')
    <script src="{{ asset('/public/dist/js/custom/validation.min.js') }}"></script>
    <script>
        const totalUnavailable = '{{ $totalUnavailable }}';
    </script>
    <script src="{{ asset('Modules/Inventory/Resources/assets/js/adjust.min.js') }}"></script>
@endsection
