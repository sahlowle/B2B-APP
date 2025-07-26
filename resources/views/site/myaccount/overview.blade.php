@extends('site.myaccount.layouts.master')
@section('page_title', __('Overview'))
@section('content')
    @php
        $order = App\Models\Order::where('user_id', auth()->user()->id)->orderByDesc('id')->filter()->first();
        $address = App\Models\Address::where(['user_id' => auth()->user()->id, 'is_default' => 1])->first();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_overview">
        <section class="flex jusitfy-start items-start md:items-center sm:gap-4 gap-1">
            <img class="rounded-full w-16 h-16 object-contain" src="{{ auth()->user()->fileUrl() }}"
                alt="">
            <div>
                <p class="text-medium text-sm leading-7 text-neutral-500">{{ __("Welcome") }}</p>
                <div class="flex flex-wrap jusfti-start items-center gap-3">
                    <p class="text-medium text-2xl leading-7 text-black">{{ auth()->user()->name }}</p>
                    <a href="{{ route('site.userProfile') }}"
                        class="flex jusitfy-start items-center gap-1 rounded-3xl px-3 py-1 bg-yellow-400">
                        <svg  width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_20535_2352)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.14646 1.1466C8.89401 0.39905 10.106 0.399051 10.8536 1.1466C11.6011 1.89415 11.6011 3.10616 10.8536 3.85371L4.25042 10.4568C4.24204 10.4652 4.23373 10.4735 4.22549 10.4818C4.10305 10.6044 3.99503 10.7126 3.8667 10.7972C3.75387 10.8717 3.6315 10.9305 3.50292 10.9721C3.35667 11.0194 3.20471 11.0362 3.03244 11.0552C3.02086 11.0565 3.00918 11.0578 2.9974 11.0591L1.30522 11.2471C1.15426 11.2639 1.00385 11.2111 0.89645 11.1037C0.789046 10.9963 0.736288 10.8459 0.753061 10.6949L0.941082 9.00275C0.942391 8.99097 0.943679 8.97929 0.944958 8.9677C0.963959 8.79544 0.98072 8.64349 1.02807 8.49723C1.06969 8.36865 1.1285 8.24628 1.20291 8.13345C1.28754 8.00512 1.39572 7.89711 1.51836 7.77466C1.52662 7.76642 1.53493 7.75811 1.54331 7.74973L8.14646 1.1466ZM10.1465 1.8537C9.78944 1.49668 9.21059 1.49668 8.85357 1.8537L2.25042 8.45684C2.08917 8.61809 2.05923 8.65137 2.03774 8.68396C2.01293 8.72157 1.99333 8.76236 1.97945 8.80522C1.96743 8.84237 1.96015 8.88653 1.93497 9.11318L1.81596 10.1842L2.88697 10.0652C3.11362 10.04 3.15778 10.0327 3.19493 10.0207C3.23779 10.0068 3.27858 9.98722 3.31619 9.96242C3.34879 9.94092 3.38206 9.91099 3.54331 9.74974L10.1465 3.1466C10.5035 2.78958 10.5035 2.21073 10.1465 1.8537Z"
                                    fill="#2C2C2C" />
                            </g>
                            <defs>
                                <clipPath id="clip0_20535_2352">
                                    <rect width="12" height="12" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <p class="font-medium text-xs leading-4 text-black">{{ __("Edit Profile") }}</p>
                    </a>
                </div>
            </div>
        </section>
        <section>
            <p class="font-medium leading-5 text-neutral-500 mt-9">{{ __("A quick overview of your account.") }}</p>
            <div class="grid lg:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-3 w-full mt-3">
                <a href="{{ route('site.cart') }}"
                    class="cursor-pointer border-gray-300 bg-gray-100 border rounded sm:px-5 px-4 min-h-20 flex justify-between items-center sm:gap-4 gap-1">
                    <p class="text-black text-lg x:text-sm font-medium">{{ __("Cart") }}</p>
                    <p class="text-black text-3xl x:text-base font-semibold">{{ Cart::cartCollection()->count() }}</p>
                </a>
                <a href="{{ route('site.wishlist') }}"
                    class="cursor-pointer border-gray-300 bg-gray-100 border rounded sm:px-5 px-4 min-h-20 flex justify-between items-center sm:gap-4 gap-1">
                    <p class="text-black text-lg x:text-sm font-medium">{{ __("Wishlist") }}</p>
                    <p class="text-black text-3xl x:text-base font-semibold">{{ auth()->user()->totalWishlist() }}</p>
                </a>
                <a href="{{ route('site.review') }}"
                    class="cursor-pointer border-gray-400 bg-white border rounded sm:px-5 px-4 min-h-20 flex justify-between items-center sm:gap-4 gap-1">
                    <p class="text-black text-lg x:text-sm font-medium">{{ __("Reviews") }}</p>
                    <p class="text-black text-3xl x:text-base font-semibold">{{ auth()->user()->totalReview() }}</p>
                </a>
                <a href="{{ route('site.order') }}"
                    class="cursor-pointer border-gray-400 bg-white border rounded sm:px-5 px-4 min-h-20 flex justify-between items-center sm:gap-4 gap-1">
                    <p class="text-black text-lg x:text-sm font-medium w-16 leading-5">{{ __("Total Orders") }}</p>
                    <p class="text-black text-3xl x:text-base font-semibold">{{ auth()->user()->totalOrder() }}</p>
                </a>
            </div>
        </section>
        
        @if ($order)
            <section>
                <div class="flex flex-wrap justify-between items-center gap-3 w-full mt-9">
                    <p class="font-medium leading-5 text-neutral-500">{{ __("Your last order") }}</p>
                    <a href="{{ route('site.order') }}" class="flex flex-wrap justify-end items-center gap-0.5 cursor-pointer font-medium leading-5 text-neutral-500">
                        {{ __("See all") }}
                        <svg class="neg-transition-scale" width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.52925 3.52925C5.7896 3.2689 6.21171 3.2689 6.47206 3.52925L10.4721 7.52925C10.7324 7.7896 10.7324 8.21171 10.4721 8.47205L6.47206 12.4721C6.21171 12.7324 5.7896 12.7324 5.52925 12.4721C5.2689 12.2117 5.2689 11.7896 5.52925 11.5292L9.05784 8.00065L5.52925 4.47206C5.2689 4.21171 5.2689 3.7896 5.52925 3.52925Z"
                                fill="#898989" />
                        </svg>
                    </a>
                </div>
                <div class="overflow-auto">
                    <table class="w-full bg-white mt-3 customer-table">
                        <thead>
                            <tr class="border-gray-400 border rounded">
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Invoice No.') }} </th>
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Order Date') }}
                                </th>
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Amount') }}
                                </th>
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Payment Method') }}</th>
                                <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                    {{ __('Status') }}
                                </th>
                                <th class="py-2 font-normal text-black px-3 rtl:text-left ltl:text-right whitespace-nowrap text-sm">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-100">
                                <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                    <span class="font-medium text-sm text-black whitespace-nowrap">
                                        {{ $order->reference }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                    <span class="font-medium text-sm text-black whitespace-nowrap">
                                        {{ formatDate($order->order_date) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4">
                                    <span class="font-medium text-sm text-black whitespace-nowrap">
                                        {{ optional($order->currency)->symbol . formatCurrencyAmount($order->total) }}
                                    </span>
                                </td>
                                    
                                <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                    <span class="ffont-medium text-sm text-black whitespace-nowrap">
                                        {{ paymentRenamed($order->paymentMethod?->gateway) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 ltr:text-left rtl:text-right">
                                    <?php
                                        list($r, $g, $b) = sscanf($order->orderStatus?->color, "#%02x%02x%02x");
                                    ?>
                                    <span class="font-medium px-3 py-1 rounded-full text-xs leading-5 whitespace-nowrap"
                                        style="color: {{ $order->orderStatus?->color }}; background: rgba({{ $r . ',' . $g . ',' . $b . ', 0.1' }});">
                                        {{ $order->orderStatus?->name }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 ltr:text-right rtl:text-left">
                                    <a class="bg-black font-medium text-white px-3 py-1 rounded text-xs leading-5 whitespace-nowrap"
                                        href="{{ route('site.orderDetails', $order->reference) }}">{{ __('View') }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
        
        @if ($address)
            <section class="mt-9">
                <p class="font-medium leading-5 text-neutral-500">{{ __("Default Address") }}</p>
                <div class="mt-3">
                    <div class="border border-gray-300 bg-gray-100 ltr:pl-4 ltr:pr-3 rtl:pr-4 rtl:pl-3 py-5 rounded relative">
                        <ul class="flex flex-col gap-4">
                            <li
                                class="flex justify-start items-start md:items-center gap-3 font-normal text-black leading-5 ltr:mr-20 rtl:ml-20">
                                <span class="w-5 h-5 mt-1 md:mt-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9 2.25C6.1005 2.25 3.75 4.60051 3.75 7.5C3.75 8.91908 4.38988 10.2585 5.46921 11.66C6.38056 12.8434 7.54705 14.0004 8.79921 15.2425C8.8659 15.3086 8.93284 15.375 9 15.4417C9.06716 15.375 9.1341 15.3086 9.20079 15.2425C10.4529 14.0004 11.6194 12.8434 12.5308 11.66C13.6101 10.2585 14.25 8.91908 14.25 7.5C14.25 4.60051 11.8995 2.25 9 2.25ZM2.25 7.5C2.25 3.77208 5.27208 0.75 9 0.75C12.7279 0.75 15.75 3.77208 15.75 7.5C15.75 9.39463 14.8899 11.0552 13.7192 12.5753C12.741 13.8455 11.4889 15.0867 10.2381 16.3266C10.0015 16.5612 9.76497 16.7957 9.53033 17.0303C9.23744 17.3232 8.76256 17.3232 8.46967 17.0303C8.23503 16.7957 7.99848 16.5612 7.76188 16.3266C6.5111 15.0867 5.25904 13.8455 4.28079 12.5753C3.11012 11.0552 2.25 9.39463 2.25 7.5ZM9 6C8.17157 6 7.5 6.67157 7.5 7.5C7.5 8.32843 8.17157 9 9 9C9.82843 9 10.5 8.32843 10.5 7.5C10.5 6.67157 9.82843 6 9 6ZM6 7.5C6 5.84315 7.34315 4.5 9 4.5C10.6569 4.5 12 5.84315 12 7.5C12 9.15685 10.6569 10.5 9 10.5C7.34315 10.5 6 9.15685 6 7.5Z"
                                            fill="#2C2C2C" />
                                    </svg>
                                </span>
                                <span>
                                    @if(!empty($address->address_1))
                                        {{ $address->address_1 }}
                                    @endif
                                    @if(!empty($address->city))
                                        {{ __("City") }}: {{ $address->city }},
                                    @endif
                                    @if(!empty($address->zip))
                                        {{ __("Postcode") }}: {{ $address->zip }},
                                    @endif
                                    @if(!empty($address->country))
                                        {{ __("Country") }}: {{ $address->country }}
                                    @endif
                                </span>
                            </li>
                            <li class="inline-block font-normal text-black leading-5">
                                <svg class="inline-block ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.17876 2.74675C4.96593 2.6391 4.71458 2.6391 4.50174 2.74675C4.4217 2.78724 4.32192 2.87369 3.88165 3.31395L3.76343 3.43218C3.34326 3.85234 3.23001 3.97386 3.13948 4.13502C3.03454 4.32182 2.94663 4.65988 2.94727 4.87413C2.94784 5.06479 2.97598 5.1796 3.09993 5.61629C3.71163 7.77147 4.86558 9.80531 6.56383 11.5035C8.26207 13.2018 10.2959 14.3557 12.4511 14.9674C12.8878 15.0914 13.0026 15.1195 13.1932 15.1201C13.4075 15.1207 13.7456 15.0328 13.9324 14.9279C14.0935 14.8374 14.215 14.7241 14.6352 14.3039L14.7534 14.1857C15.1937 13.7455 15.2801 13.6457 15.3206 13.5656C15.4283 13.3528 15.4283 13.1014 15.3206 12.8886C15.2801 12.8086 15.1937 12.7088 14.7534 12.2685L15.2838 11.7382L14.7534 12.2685L14.6073 12.1224C14.318 11.8331 14.2529 11.7739 14.2036 11.7418C13.9551 11.5802 13.6346 11.5802 13.386 11.7418C13.3367 11.7739 13.2717 11.8331 12.9824 12.1224C12.9767 12.1281 12.9708 12.134 12.9648 12.14C12.8975 12.2075 12.8123 12.293 12.71 12.3663L12.2733 11.7565L12.71 12.3663C12.3447 12.6278 11.8482 12.7125 11.4169 12.5868C11.2966 12.5517 11.1976 12.504 11.1206 12.4669C11.1145 12.4639 11.1086 12.4611 11.1027 12.4583C9.94028 11.9001 8.85151 11.1396 7.88965 10.1777C6.92779 9.21587 6.16723 8.1271 5.6091 6.96463C5.60631 6.95881 5.60344 6.95286 5.6005 6.94677C5.56337 6.86975 5.51564 6.77074 5.48058 6.65046L6.20061 6.44057L5.48058 6.65046C5.35486 6.21918 5.43953 5.72264 5.70106 5.3574L5.70106 5.35739C5.77434 5.25507 5.85985 5.16986 5.9274 5.10256C5.93342 5.09656 5.93929 5.09071 5.945 5.085C6.23429 4.79571 6.29352 4.73067 6.32557 4.68137L6.32557 4.68137C6.48719 4.43279 6.48719 4.11232 6.32557 3.86374C6.29352 3.81443 6.23429 3.74939 5.945 3.46011L5.79885 3.31395C5.35858 2.87369 5.2588 2.78724 5.17876 2.74675ZM3.82472 1.40823C4.46323 1.08528 5.21728 1.08528 5.85578 1.40823C6.18023 1.57233 6.46189 1.85472 6.78773 2.18139C6.81141 2.20513 6.83533 2.22911 6.85951 2.25329L7.00566 2.39945C7.0216 2.41538 7.03739 2.43114 7.05302 2.44675C7.26801 2.66138 7.45321 2.84626 7.58314 3.0461L6.95436 3.45492L7.58314 3.0461C8.06801 3.79185 8.06801 4.75325 7.58314 5.49901C7.45321 5.69884 7.26801 5.88373 7.05302 6.09836C7.03739 6.11396 7.0216 6.12972 7.00566 6.14566C6.96246 6.18886 6.94042 6.21102 6.92506 6.22726C6.92478 6.22849 6.92451 6.22984 6.92426 6.2313C6.92398 6.23292 6.92378 6.23443 6.92364 6.23579C6.92611 6.24127 6.92945 6.24852 6.93406 6.25832C6.94127 6.27364 6.94974 6.29129 6.96132 6.3154C7.44718 7.32736 8.1098 8.27655 8.95031 9.11706C9.79082 9.95757 10.74 10.6202 11.752 11.1061L11.4274 11.7822L11.752 11.1061C11.7761 11.1176 11.7937 11.1261 11.8091 11.1333C11.8189 11.1379 11.8261 11.1413 11.8316 11.1437C11.8329 11.1436 11.8345 11.1434 11.8361 11.1431C11.8375 11.1429 11.8389 11.1426 11.8401 11.1423C11.8564 11.127 11.8785 11.1049 11.9217 11.0617C11.9377 11.0458 11.9534 11.03 11.969 11.0143C12.1837 10.7994 12.3685 10.6142 12.5684 10.4842C13.3141 9.99937 14.2755 9.99937 15.0213 10.4842C15.2211 10.6142 15.406 10.7994 15.6206 11.0143C15.6362 11.03 15.652 11.0458 15.6679 11.0617L15.1376 11.592L15.6679 11.0617L15.8141 11.2079C15.8383 11.232 15.8622 11.256 15.886 11.2796C16.2127 11.6055 16.495 11.8871 16.6591 12.2116C16.9821 12.8501 16.9821 13.6041 16.6591 14.2427C16.495 14.5671 16.2127 14.8488 15.886 15.1746C15.8622 15.1983 15.8383 15.2222 15.8141 15.2464L15.6959 15.3646C15.6787 15.3817 15.6618 15.3987 15.6451 15.4154C15.2961 15.7647 15.0285 16.0326 14.667 16.2357C14.2545 16.4674 13.6619 16.6215 13.1888 16.6201C12.7749 16.6189 12.473 16.5331 12.0838 16.4225C12.0698 16.4185 12.0557 16.4145 12.0415 16.4104C9.6466 15.7307 7.38689 14.4479 5.50317 12.5642C3.61944 10.6805 2.33668 8.42078 1.65693 6.02586C1.6529 6.01166 1.64889 5.99758 1.64493 5.98362C1.5343 5.59437 1.44851 5.29251 1.44728 4.8786C1.44587 4.40552 1.6 3.81284 1.83169 3.40038L1.83169 3.40038C2.03479 3.03883 2.30266 2.77124 2.65196 2.42229C2.66871 2.40556 2.68564 2.38864 2.70277 2.37152L2.82099 2.25329C2.84518 2.22911 2.8691 2.20513 2.89278 2.18139C3.21861 1.85472 3.50028 1.57233 3.82472 1.40823L4.1594 2.06991L3.82472 1.40823Z"
                                        fill="#2C2C2C" />
                                </svg>
                                <span>{{ $address->phone }}</span>
                            </li>
                            <li class="inline-block font-normal text-black leading-5">
                                <svg class="inline-block ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 18 18"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M5.06909 2.25H12.931C13.5348 2.24999 14.033 2.24998 14.4389 2.28315C14.8605 2.31759 15.248 2.39151 15.612 2.57698C16.1765 2.8646 16.6355 3.32354 16.9231 3.88803C17.1021 4.23929 17.1772 4.61245 17.2132 5.01698C17.2533 5.13953 17.2603 5.26879 17.2365 5.3922C17.2501 5.72979 17.2501 6.12027 17.2501 6.56901V11.431C17.2501 12.0347 17.2501 12.533 17.2169 12.9389C17.1825 13.3604 17.1086 13.748 16.9231 14.112C16.6355 14.6765 16.1765 15.1354 15.612 15.423C15.248 15.6085 14.8605 15.6824 14.4389 15.7169C14.033 15.75 13.5348 15.75 12.9311 15.75H5.06907C4.46535 15.75 3.96709 15.75 3.5612 15.7169C3.13962 15.6824 2.75209 15.6085 2.38809 15.423C1.82361 15.1354 1.36467 14.6765 1.07704 14.112C0.891577 13.748 0.817653 13.3604 0.78321 12.9389C0.750047 12.533 0.750054 12.0347 0.750064 11.431V6.56903C0.750057 6.12028 0.750051 5.72979 0.763667 5.3922C0.73985 5.26879 0.746879 5.13952 0.786976 5.01697C0.822967 4.61245 0.898071 4.23929 1.07704 3.88803C1.36466 3.32354 1.82361 2.8646 2.38809 2.57698C2.75209 2.39151 3.13962 2.31759 3.5612 2.28315C3.96709 2.24998 4.46536 2.24999 5.06909 2.25ZM2.25006 6.69049V11.4C2.25006 12.0424 2.25065 12.4792 2.27823 12.8167C2.30509 13.1455 2.35379 13.3137 2.41355 13.431C2.55736 13.7132 2.78684 13.9427 3.06908 14.0865C3.18638 14.1463 3.35453 14.195 3.68334 14.2218C4.02091 14.2494 4.45763 14.25 5.10006 14.25H12.9001C13.5425 14.25 13.9792 14.2494 14.3168 14.2218C14.6456 14.195 14.8138 14.1463 14.9311 14.0865C15.2133 13.9427 15.4428 13.7132 15.5866 13.431C15.6463 13.3137 15.695 13.1455 15.7219 12.8167C15.7495 12.4792 15.7501 12.0424 15.7501 11.4V6.69049L10.8065 10.151C10.7774 10.1714 10.7485 10.1916 10.72 10.2117C10.3115 10.4985 9.95279 10.7504 9.54427 10.8522C9.18693 10.9413 8.8132 10.9413 8.45586 10.8522C8.04735 10.7504 7.68866 10.4985 7.28017 10.2117C7.25159 10.1916 7.22276 10.1714 7.19366 10.151L2.25006 6.69049ZM15.688 4.90296L9.94628 8.92216C9.39957 9.30485 9.28375 9.37125 9.18147 9.39675C9.06235 9.42644 8.93778 9.42644 8.81866 9.39675C8.71638 9.37125 8.60056 9.30485 8.05385 8.92216L2.31214 4.90296C2.33893 4.74759 2.37379 4.64705 2.41355 4.56902C2.55736 4.28677 2.78684 4.0573 3.06908 3.91349C3.18638 3.85372 3.35453 3.80503 3.68334 3.77816C4.02091 3.75058 4.45763 3.75 5.10006 3.75H12.9001C13.5425 3.75 13.9792 3.75058 14.3168 3.77816C14.6456 3.80503 14.8138 3.85372 14.9311 3.91349C15.2133 4.0573 15.4428 4.28677 15.5866 4.56902C15.6263 4.64705 15.6612 4.74759 15.688 4.90296Z"
                                        fill="#2C2C2C" />
                                </svg>

                                <span>{{ $address->email }}</span>
                            </li>
                        </ul>
                        <a href="{{ route('site.addressEdit', $address->id) }}"
                            class="flex jusitfy-start items-center gap-1 rounded-3xl px-3 py-1 bg-yellow-400 absolute lg:top-3 -top-9 ltr:right-3 rtl:left-3 font-medium text-xs leading-4 text-black ">
                            <svg  width="12" height="12" viewBox="0 0 12 12" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_20535_2352)">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M8.14646 1.1466C8.89401 0.39905 10.106 0.399051 10.8536 1.1466C11.6011 1.89415 11.6011 3.10616 10.8536 3.85371L4.25042 10.4568C4.24204 10.4652 4.23373 10.4735 4.22549 10.4818C4.10305 10.6044 3.99503 10.7126 3.8667 10.7972C3.75387 10.8717 3.6315 10.9305 3.50292 10.9721C3.35667 11.0194 3.20471 11.0362 3.03244 11.0552C3.02086 11.0565 3.00918 11.0578 2.9974 11.0591L1.30522 11.2471C1.15426 11.2639 1.00385 11.2111 0.89645 11.1037C0.789046 10.9963 0.736288 10.8459 0.753061 10.6949L0.941082 9.00275C0.942391 8.99097 0.943679 8.97929 0.944958 8.9677C0.963959 8.79544 0.98072 8.64349 1.02807 8.49723C1.06969 8.36865 1.1285 8.24628 1.20291 8.13345C1.28754 8.00512 1.39572 7.89711 1.51836 7.77466C1.52662 7.76642 1.53493 7.75811 1.54331 7.74973L8.14646 1.1466ZM10.1465 1.8537C9.78944 1.49668 9.21059 1.49668 8.85357 1.8537L2.25042 8.45684C2.08917 8.61809 2.05923 8.65137 2.03774 8.68396C2.01293 8.72157 1.99333 8.76236 1.97945 8.80522C1.96743 8.84237 1.96015 8.88653 1.93497 9.11318L1.81596 10.1842L2.88697 10.0652C3.11362 10.04 3.15778 10.0327 3.19493 10.0207C3.23779 10.0068 3.27858 9.98722 3.31619 9.96242C3.34879 9.94092 3.38206 9.91099 3.54331 9.74974L10.1465 3.1466C10.5035 2.78958 10.5035 2.21073 10.1465 1.8537Z"
                                        fill="#2C2C2C" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_20535_2352">
                                        <rect width="12" height="12" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            {{ __("Edit") }}
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
