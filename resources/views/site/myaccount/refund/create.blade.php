@extends('site.myaccount.layouts.master')
@section('page_title', __('Create Refund'))
@section('content')
    @php
        $orders = Modules\Refund\Entities\Refund::getOrders();
        $reasons = Modules\Refund\Entities\RefundReason::getAll();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_refund_create">
        <p class="text-2xl text-black font-medium">{{ __("Refund Request") }}</p>
        <p class="text-sm text-gray-400 font-medium mt-1.5">{{ __("Please fill in accurate details for the refund of the product.") }}
        </p>
        <div class="flex">
        </div>
        <div class="items-center sm:w-4/5 lg:w-3/5 mt-5">
            <form class="w-full" action="{{ route('site.orderRefund') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_detail_id">
                <div class="bg-neutral-100 p-5">
                    <div class="w-full gender-container mb-6">
                        <label class="text-sm font-normal capitalize text-black require-profile">
                            {{ __('Select Order Number') }} </label>
                        <select name="order_reference" class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 ltr:pl-5 rtl:pr-5 mt-1.5 refund-select"
                            oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select one') }}</option>
                            @foreach ($orders as $key => $value)
                                <option {{ isset(request()->order_id) && request()->order_id == $key ? 'selected' : '' }}
                                    value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full gender-container mb-6">
                        <label class="text-sm font-normal capitalize text-black require-profile">
                            {{ __('Select Product') }} </label>
                        <select id="order_items" name="order_items"
                            class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 ltr:pl-5 rtl:pr-5 mt-1.5 refund-select"
                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option class="bg-red-100 text-red-300 " value="">{{ __('Select one') }}</option>
                        </select>
                    </div>
                    <div class="w-full gender-container mb-6">
                        <label class="text-sm font-normal capitalize text-black require-profile">
                            {{ __('Select Quantity') }} </label>
                        <select id="item_quantity" name="quantity_sent"
                            class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 ltr:pl-5 rtl:pr-5 mt-1.5 refund-select"
                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select one') }}</option>
                        </select>
                    </div>
                    <div class="w-full gender-container mb-6">
                        <label class="text-sm font-normal capitalize text-black require-profile">
                            {{ __('Select Refund Reason') }} </label>
                        <select name="refund_reason_id"
                            class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 ltr:pl-5 rtl:pr-5 mt-1.5 refund-select"
                            required oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            <option value="">{{ __('Select one') }}</option>
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full gender-container">
                        <label class="text-sm font-normal capitalize text-black">
                            {{ __('Upload Product Images') }} </label>
                        <div
                            class="drop-zone border border-dashed border-gray-400 rounded-xl bg-white mt-1.5 cursor-pointer">
                            <div class="text-sm leading-5 font-normal  text-black wrap-anywhere text-center py-9 px-4">
                                <div class="justify-center items-center flex gap-2 text-gray-400">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.0013 12.834C7.32347 12.834 7.58464 12.5728 7.58464 12.2507V5.49227L10.0888 7.99646C10.3166 8.22427 10.686 8.22427 10.9138 7.99646C11.1416 7.76866 11.1416 7.39931 10.9138 7.1715L7.41378 3.6715C7.18598 3.4437 6.81663 3.4437 6.58882 3.6715L3.08882 7.1715C2.86102 7.39931 2.86102 7.76866 3.08882 7.99646C3.31663 8.22427 3.68598 8.22427 3.91378 7.99646L6.41797 5.49227V12.2507C6.41797 12.5728 6.67914 12.834 7.0013 12.834ZM1.16797 1.75065C1.16797 2.07282 1.42914 2.33398 1.7513 2.33398H12.2513C12.5735 2.33398 12.8346 2.07282 12.8346 1.75065C12.8346 1.42848 12.5735 1.16732 12.2513 1.16732H1.7513C1.42914 1.16732 1.16797 1.42848 1.16797 1.75065Z"
                                            fill="#898989" />
                                    </svg>
                                    <span>{{ __('Click or drag images to upload') }}</span>
                                </div>
                            </div>
                            <input type="file" id="refundImg" name="file[]" class="drop-zone-input hidden" multiple>
                        </div>
                        <div id="error-message" class="error-message hidden text-xs text-red-500 font-medium mt-1">
                            {{ __('invalid files') }}</div>
                        <div id="file-container" class="flex items-center gap-x-4 gap-y-1 flex-wrap mt-1"></div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" id="btnSubmit"
                        class="items-center cursor-pointer py-2.5 px-6 font-medium text-sm whitespace-nowrap text-black hover:text-white bg-yellow-400 hover:bg-black rounded">{{ __('Send Request') }}</button>
                    <a href="{{ route('site.refundRequest') }}"
                        class="text-center rounded py-2.5 px-6 cursor-pointer font-medium text-sm text-gray-12 bg-white border border-gray-2 hover:border-gray-12">{{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('js')
    <script>
        var product_id = "{{ request()->product_id }}";
    </script>
@endsection
