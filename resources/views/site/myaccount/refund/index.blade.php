@extends('site.myaccount.layouts.master')
@section('page_title', __('Refunds'))
@section('content')
    @php
        $refunds = Modules\Refund\Entities\Refund::where('user_id', auth()->user()->id)->with(['orderDetail', 'refundReason']);

        $filterDay = ['today' => today(), 'last_week' => now()->subWeek(), 'last_month' => now()->subMonth(), 'last_year' => now()->subYear()];
        if (isset(request()->filter_day) && array_key_exists(request()->filter_day, $filterDay)) {
            $refunds->whereDate('created_at', '>=', $filterDay[request()->filter_day]);
        }
        if (isset(request()->filter_status) && request()->filter_status != 'All Status') {
            $refunds->where('status', request()->filter_status);
        }

        $refunds = $refunds->paginate(preference('row_per_page'));
        $orders = Modules\Refund\Entities\Refund::getOrders();
    @endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1" id="customer_refunds">
        <section>
            <div class="flex justify-between lg:items-center sm:gap-7 gap-3 flex-wrap">
                <p class="text-2xl text-black font-medium">{{ __("Refunds") }}</p>
                @if (count($orders) && preference('order_refund'))
                    <a href="{{ route('site.createRefundRequest') }}"
                        class="text-sm px-6 py-2.5 whitespace-nowrap font-medium text-black bg-yellow-400 hover:text-white hover:bg-black rounded">
                        {{ __("Request a Refund") }}
                    </a>
                @endif
            </div>
            <div class="flex justify-between lg:items-center sm:gap-7 gap-3 flex-wrap mt-7">
                <p class="text-lg text-black font-medium">{{ __("List") }}</p>
                <div class="flex gap-2 day-sorting">
                    @php
                        $filterDay = ['all' => __('All'), 'today' => __('Today'), 'last_week' => __('Last Week'), 'last_month' => __('Last Month'), 'last_year' => __('Last Year')];
                    @endphp
                    <select data-type="filter_day"
                        class="customer-filter border border-gray-400 rounded flex justify-between items-center p-2 font-medium text-sm text-black form-control genderSelect days-conntainer">
                        @foreach ($filterDay as $key => $value)
                            <option @selected(request('filter_day') == $key) value="{{ $key }}" class="font-medium text-sm text-black">{{ $value }}</option>
                        @endforeach
                    </select>
                    
                    @php
                        $filterStatus = ['All Status' => __('All Status'), 'Opened' => __('Opened'), 'In progress' => __('In progress'), 'Accepted' => __('Accepted'), 'Declined' => __('Declined')];
                    @endphp
                    <select data-type="filter_status"
                        class="customer-filter border border-gray-400 rounded flex justify-between items-center p-2 font-medium text-sm text-black form-control genderSelect days-conntainer">
                        @foreach ($filterStatus as $key => $value)
                            <option @selected(request('filter_status') == $key) value="{{ $key }}" class="font-medium text-sm text-black">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="overflow-auto">
                <table class="w-full bg-white mt-3 customer-table">
                    <thead>
                        <tr class="border-gray-400 border rounded">
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Image') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Product') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Amount') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Qty') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Date') }}</th>
                            <th class="py-2 font-normal text-black px-3 ltr:text-left rtl:text-right whitespace-nowrap text-sm">
                                {{ __('Status') }}
                            </th>
                            <th class="py-2 font-normal text-black px-3 rtl:text-left ltr:text-right whitespace-nowrap text-sm">
                                {{ __('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($refunds as $refund)
                        <tr>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <img src="{{ $refund->getProduct()?->getFeaturedImage('small') }}" alt="item"
                                    class="w-14 h-14 rounded">
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <a href="#" class="flex items-center justify-start">
                                    <span
                                        class="w-72 break-words h-11 flex items-center line-clamp-double font-medium text-black text-sm">
                                        {{ $refund->getProduct()?->name }}
                                    </span>
                                </a>
                                <span class="font-medium text-xs text-gray-400 whitespace-nowrap">
                                    {{ __("Invoice") }}: {{ $refund->orderDetail?->order?->reference }}
                                </span>
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <span class="font-medium text-sm text-black whitespace-nowrap">{{ formatNumber($refund->orderDetail->price) }}</span>
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <span class="font-medium text-sm text-black whitespace-nowrap">
                                    {{ $refund->quantity_sent }}
                                </span>
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <span class="font-medium text-sm text-black whitespace-nowrap">
                                    {{ timeZoneFormatDate($refund->created_at) }}
                                </span>
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                @php
                                    $color = ['Opened' => 'bg-gray-11 ; text-gray-10 ', 'In progress' => 'bg-green-2 ; text-green-1', 'Accepted' => 'bg-green-2 ; text-green-1', 'Declined' => 'bg-pinks-2 ; text-reds-3'];
                                @endphp
                                <span
                                    class="font-medium px-3 py-1 rounded-full text-xs leading-5 {{ $color[$refund->status] }} whitespace-nowrap">{{ $refund->status }}</span>
                            </td>
                            <td class="p-3 ltr:text-left rtl:text-right">
                                <a class="bg-black font-medium text-white px-3 py-1 rounded text-xs leading-5 whitespace-nowrap flex justify-center items-center gap-1"
                                    href="{{ route('site.refundDetails', $refund->id) }}">
                                    {{ __('Details') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <span
                                    class="font-medium text-lg text-neutral-500 text-center flex justify-center flex-col items-center gap-4 py-10">
                                    <svg class="w-16 h-16" xmlns="http://www.w3.org/2000/svg" width="106"
                                        height="106" viewBox="0 0 106 106" fill="none">
                                        <path
                                            d="M6.31466 0.35157C4.96895 0.848442 4.03731 1.51094 3.292 2.5461C2.33966 3.8711 2.07052 5.11329 2.07052 8.23946C2.07052 10.7031 2.02911 11.0758 1.65645 11.5934C1.40802 11.9246 0.97325 12.732 0.662703 13.3945L0.103719 14.5953L0.0416094 49.6871C0.000203108 80.866 0.0209062 85.0273 0.31075 87.0355C0.97325 91.5281 2.83653 96.0621 5.46583 99.4988C6.19044 100.451 6.21114 100.513 6.21114 102.397C6.21114 104.55 6.43888 105.275 7.267 105.71C7.99161 106.082 8.5713 106.082 9.29591 105.71C10.124 105.275 10.3518 104.55 10.3518 102.397C10.3518 100.513 10.3725 100.451 11.0971 99.4988C13.7057 96.0828 15.569 91.5695 16.2315 87.1184C16.5213 85.2137 16.5627 81.1559 16.5627 54.8836V24.8434H17.8049C19.2541 24.8434 20.1029 25.1953 20.4549 25.982C20.6412 26.3754 20.7033 29.191 20.7033 36.4578C20.7033 47.2441 20.7033 47.2648 21.842 47.7824C22.9393 48.2793 24.2022 47.8652 24.6162 46.8508C24.8026 46.416 24.844 43.4555 24.8026 35.816C24.7404 25.6922 24.7197 25.3402 24.3057 24.4086C23.2084 22.0484 21.3244 20.8891 18.4053 20.7441L16.6041 20.6613L16.5213 17.618C16.4592 14.8645 16.3971 14.4918 15.9002 13.3945C15.5897 12.732 15.1549 11.9453 14.9272 11.6348C14.5959 11.1379 14.5131 10.6203 14.451 7.8668C14.3682 4.30586 14.1404 3.49844 12.8568 2.00782C11.3869 0.330864 8.44708 -0.414444 6.31466 0.35157ZM9.29591 4.43008C10.0619 4.84415 10.3518 5.56876 10.3518 7.10078V8.38438H8.28145H6.21114V7.03868C6.23184 5.56876 6.52169 4.84415 7.267 4.43008C7.9088 4.07813 8.592 4.07813 9.29591 4.43008ZM10.5588 13.1254C10.9936 13.3945 11.5525 13.9949 11.8217 14.4297C12.2772 15.1336 12.3186 15.5063 12.3807 17.9492L12.4635 20.7027H8.30216H4.14083V18.3633C4.14083 17.1004 4.24434 15.6926 4.36856 15.2578C4.6377 14.3055 5.942 12.9184 6.87364 12.6492C7.97091 12.318 9.66856 12.525 10.5588 13.1254ZM12.4221 52.9996V81.1559H8.28145H4.14083V52.9996V24.8434H8.28145H12.4221V52.9996ZM12.1529 86.4766C11.8838 89.0645 10.0412 93.9711 8.69552 95.648L8.28145 96.1656L7.86739 95.648C6.52169 93.9711 4.67911 89.0645 4.40997 86.4766L4.28575 85.2965H8.28145H12.2772L12.1529 86.4766Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M36.9139 15.1956C33.1667 16.1065 29.9991 19.3776 29.2124 23.1456C29.0467 23.9116 28.9846 33.8491 28.9846 56.8295V89.437H25.6721C22.0698 89.437 21.4694 89.5819 20.9932 90.4928C20.3307 91.7971 20.8897 95.1096 22.2768 97.9252C23.0842 99.5608 23.5604 100.203 25.0303 101.673C26.521 103.163 27.1421 103.619 28.7776 104.405C32.235 106.103 30.6616 106.02 59.7288 105.958L85.4006 105.896L86.5807 105.42C89.2307 104.343 91.1768 102.583 92.419 100.078C93.6198 97.6768 93.5784 99.0639 93.5784 65.9803V35.6088H98.9612C104.903 35.6088 105.317 35.526 105.773 34.4081C105.959 33.9733 106 32.0893 105.959 27.5139L105.897 21.2202L105.234 19.8331C104.323 17.9077 103.164 16.7069 101.28 15.7753L99.7065 15.0092L68.8588 14.9678C44.6569 14.9471 37.7628 14.9885 36.9139 15.1956ZM89.9967 20.1229L89.5413 21.2202L89.4378 59.1069L89.3342 96.9936L88.7545 98.1737C87.9678 99.7678 86.4358 101.134 84.9245 101.569C81.9846 102.439 78.8585 100.969 77.5542 98.153C77.2022 97.3456 77.1194 96.7038 77.0573 94.1987C77.0366 92.5424 76.8917 90.9276 76.7674 90.617C76.2913 89.3749 77.3264 89.437 54.2424 89.437H33.1253V56.9745C33.1253 21.3444 33.0632 23.3733 34.3674 21.5721C35.0507 20.6198 36.21 19.771 37.4108 19.3362C38.0526 19.1085 42.8971 19.0671 64.3249 19.0463H90.4729L89.9967 20.1229ZM99.9963 19.7503C100.431 20.0194 100.99 20.6198 101.259 21.0546C101.735 21.8206 101.756 22.0069 101.818 26.6444L101.88 31.4682H97.7397H93.5784V27.0584C93.5784 24.6155 93.6819 22.3174 93.8061 21.8827C94.0753 20.9303 95.3795 19.5432 96.3112 19.2741C97.4085 18.9428 99.1061 19.1499 99.9963 19.7503ZM72.9167 95.6893C73.0409 97.9873 73.4963 99.6643 74.428 101.072L74.9456 101.859H54.4909C32.2143 101.859 32.9596 101.9 30.4339 100.679C28.1979 99.6022 25.7342 96.5381 25.1753 94.1366L25.051 93.5776H48.9217H72.8131L72.9167 95.6893Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M51.7788 27.6589C48.5905 28.5078 45.8991 31.3441 45.1538 34.5945C44.8226 35.9816 44.8847 38.7144 45.2573 39.9773C46.3546 43.6625 48.3007 45.9191 56.3128 52.7925C60.5777 56.457 61.0124 56.6847 62.1511 56.0843C63.062 55.6082 71.2191 48.4035 73.0823 46.4367C75.132 44.2836 76.0843 42.9171 76.9745 40.7433C77.4507 39.6046 77.5128 39.1492 77.5128 37.1617C77.5128 35.2777 77.43 34.6566 77.0159 33.6421C76.0429 31.0957 74.5523 29.398 72.3577 28.28C68.8382 26.5203 64.9667 27.2035 62.1511 30.0812L61.2609 30.9921L60.1636 29.9156C57.907 27.6589 54.8429 26.8308 51.7788 27.6589ZM55.6089 31.7789C57.1409 32.4207 58.5073 33.9941 59.1284 35.8574C59.5011 36.996 60.3292 37.6793 61.323 37.6793C62.0683 37.6793 62.9999 36.789 63.4347 35.6296C64.2214 33.5593 65.6499 32.0894 67.2855 31.6546C70.6808 30.7437 73.7862 33.8285 73.4343 37.7414C73.1859 40.5156 71.1984 43 64.946 48.3621L61.2402 51.5296L57.9277 48.6933C52.255 43.8695 50.2882 41.7371 49.4394 39.5011C49.0253 38.3832 48.9425 36.3543 49.2738 35.1535C50.0191 32.5242 53.2488 30.7851 55.6089 31.7789Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M42.4623 64.8836C40.6611 65.8773 41.4272 68.7344 43.4768 68.7344C44.5326 68.7344 45.5471 67.7199 45.5471 66.6848C45.5471 65.132 43.8287 64.1176 42.4623 64.8836Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M50.7435 64.8837C49.3564 65.6497 49.3978 67.8442 50.8263 68.486C51.5923 68.838 79.2517 68.838 80.0177 68.486C80.6181 68.2169 81.1564 67.3474 81.1564 66.6642C81.1564 65.981 80.6181 65.1114 80.0177 64.8423C79.1896 64.4696 51.4267 64.511 50.7435 64.8837Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M42.4623 77.3055C40.6611 78.2992 41.4272 81.1562 43.4768 81.1562C44.5326 81.1562 45.5471 80.1418 45.5471 79.1066C45.5471 77.5539 43.8287 76.5394 42.4623 77.3055Z"
                                            fill="#B0B0B0"></path>
                                        <path
                                            d="M50.7435 77.3056C49.3564 78.0716 49.3978 80.2661 50.8263 80.9079C51.5923 81.2599 79.2517 81.2599 80.0177 80.9079C80.6181 80.6388 81.1564 79.7692 81.1564 79.086C81.1564 78.4028 80.6181 77.5333 80.0177 77.2642C79.1896 76.8915 51.4267 76.9329 50.7435 77.3056Z"
                                            fill="#B0B0B0"></path>
                                    </svg>
                                    {{ __("No refund found") }}
                                </span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
