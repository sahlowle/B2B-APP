@php
    $carts = \App\Cart\Cart::cartCollection()->sortKeys();
    $textColor = $header['top']['text_color'];
    $userRole = auth()->user()?->role();
@endphp

<section style="background: {{ $header['top']['bg_color'] }}" class="{{ isset($header['top']['show_header']) && $header['top']['show_header'] == 1 ? '' : 'md:hidden' }}">
    <div class="layout-wrapper px-4 xl:px-0 pt-2p font-medium text-base flex justify-between items-center h-16 md:h-10 roboto-medium">
        <div class="flex items-center">
            <div style="color: {{ $header['top']['text_color'] }}" class="hidden md:block">
                <ul class="flex flex-col sm:flex-row text-xs">
                    @if (isset($header['top']['show_phone']) && $header['top']['show_phone'] == 1)
                        <li>
                            <a href="javascript: void(0)" class="w-fill flex ltr:pr-30p rtl:pl-30p">
                                <svg  width="13" height="13" viewBox="0 0 13 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.37104 0.70694L1.84948 0.228499C2.15415 -0.0761661 2.64811 -0.0761666 2.95277 0.228499L4.97006 2.24579C5.27472 2.55045 5.27472 3.04441 4.97006 3.34908L3.57172 4.74742C3.33855 4.98059 3.28074 5.3368 3.42821 5.63175C4.28072 7.33676 5.66324 8.71928 7.36826 9.57179C7.6632 9.71926 8.01941 9.66145 8.25259 9.42828L9.65092 8.02994C9.95559 7.72528 10.4495 7.72528 10.7542 8.02994L12.7715 10.0472C13.0762 10.3519 13.0762 10.8459 12.7715 11.1505L12.2931 11.629C10.6459 13.2761 8.03822 13.4614 6.17467 12.0638L5.23194 11.3567C3.87173 10.3366 2.66343 9.12827 1.64327 7.76806L0.936223 6.82533C-0.461438 4.96178 -0.276117 2.3541 1.37104 0.70694Z" fill="{{ $textColor }}" />
                                </svg>
                                <span class="rtl-direction-space -mt-0.5 ltr:pl-2 rtl:pr-2">
                                    &#x200E;{!! isset($header['top']['phone']) ? $header['top']['phone'] : '' !!}
                                </span>
                                
                            </a>
                        </li>
                    @endif

                    @if (isset($header['top']['show_email']) && $header['top']['show_email'] == 1)
                        <li>
                            <a href="javascript: void(0)" class="w-fill flex">
                                <svg  width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.781049 0.815917C0 1.63183 0 2.94503 0 5.57143V7.42857C0 10.055 0 11.3682 0.781049 12.1841C1.5621 13 2.81918 13 5.33333 13H10.6667C13.1808 13 14.4379 13 15.219 12.1841C16 11.3682 16 10.055 16 7.42857V5.57143C16 2.94503 16 1.63183 15.219 0.815917C14.4379 0 13.1808 0 10.6667 0H5.33333C2.81918 0 1.5621 0 0.781049 0.815917ZM3.15973 2.94167C2.75126 2.6572 2.19938 2.7725 1.92707 3.19921C1.65475 3.62591 1.76513 4.20243 2.1736 4.4869L7.01387 7.8578C7.61102 8.27368 8.38898 8.27368 8.98613 7.8578L13.8264 4.4869C14.2349 4.20243 14.3452 3.62591 14.0729 3.19921C13.8006 2.7725 13.2487 2.6572 12.8403 2.94167L8 6.31257L3.15973 2.94167Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="rtl-direction-space -mt-0.5 ltr:pl-2 rtl:pr-2">{!! isset($header['top']['email']) ? $header['top']['email'] : '' !!}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="md:hidden mobile-sidebar">
                <svg class="burger pointer" width="27" height="21" viewBox="0 0 27 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 18.5233C0 17.6563 0.737949 16.9535 1.64826 16.9535H11.5378C12.4481 16.9535 13.186 17.6563 13.186 18.5233C13.186 19.3902 12.4481 20.093 11.5378 20.093H1.64826C0.737949 20.093 0 19.3902 0 18.5233Z"
                        fill="#2C2C2C" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 10.0465C0 9.00615 0.749663 8.16278 1.67442 8.16278H18.4186C19.3434 8.16278 20.093 9.00615 20.093 10.0465C20.093 11.0869 19.3434 11.9302 18.4186 11.9302H1.67442C0.749663 11.9302 0 11.0869 0 10.0465Z"
                        fill="#2C2C2C" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0 1.56977C0 0.702809 0.755519 0 1.6875 0H25.3125C26.2445 0 27 0.702809 27 1.56977C27 2.43673 26.2445 3.13953 25.3125 3.13953H1.6875C0.755519 3.13953 0 2.43673 0 1.56977Z"
                        fill="#2C2C2C" />
                </svg>
            </div>

            <div class="md:hidden ltr:ml-10 rtl:mr-10">
                <a href="{{ route('site.index') }}">
                   <h1 class="text-2xl font-bold text-gray-900 tracking-wide leading-tight">Export Valley</h1>
                </a>
            </div>

            {{-- @if (isset($header['main']['show_logo']) && $header['main']['show_logo'] == 1 && $headerLogo->objectFile)
                <div class="md:hidden ltr:ml-10 rtl:mr-10">
                    <a href="{{ route('site.index') }}">
                        <img class="w-36 h-11 object-contain" src="{{ $headerLogo->fileUrlQuery() }}" alt="{{ __('Image') }}">
                    </a>
                </div>
            @endif --}}
        </div>
        <div class="flex items-center">
            <div style="color: {{ $header['top']['text_color'] }}" class="hidden md:block">
                <ul class="flex flex-col sm:flex-row">
                    @if (isset($header['top']['show_seller']) && $header['top']['show_seller'] == 1 && preference('vendor_signup') == '1' && (!Auth::check() || $userRole->type != 'admin' && $userRole->type != 'vendor'))
                        <li class="flex items-center">
                            <a href="{{ route('site.seller.signUp') }}" class="flex w-fill ltr:pl-30p rtl:pr-0">
                                <svg width="19" height="15" viewBox="0 0 19 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.1481 8.24503C12.3121 8.12948 12.3903 7.9282 12.3568 7.73064L11.9505 5.36374L13.6688 3.69013C13.8105 3.55222 13.8627 3.33976 13.803 3.14966C13.7397 2.95956 13.5757 2.82165 13.3781 2.79183L11.0037 2.44518L9.94143 0.294465C9.85198 0.11555 9.66933 0 9.46805 0C9.26677 0 9.08413 0.11555 8.99467 0.294465L7.93236 2.44518L5.558 2.79183C5.36045 2.82165 5.19645 2.95956 5.13308 3.14966C5.06971 3.33976 5.1219 3.54849 5.26727 3.69013L6.9856 5.36374L6.57931 7.73064C6.54577 7.9282 6.62777 8.12575 6.78805 8.24503C6.95205 8.3643 7.16452 8.37921 7.34343 8.28603L9.46805 7.1678L11.5927 8.28603C11.6747 8.32703 11.9393 8.39412 12.1481 8.24503V8.24503ZM9.71779 6.10922C9.47178 6.02722 9.47178 6.02722 9.2295 6.10922L7.80563 6.85843L8.07773 5.27055C8.10755 5.09909 8.05164 4.92763 7.92491 4.80463L6.77314 3.67895L8.36847 3.44785C8.53993 3.42176 8.68903 3.31367 8.76357 3.16084L9.47551 1.71833L10.1874 3.16084C10.2657 3.31739 10.4111 3.42549 10.5825 3.44785L12.1779 3.67895L11.0261 4.80463C10.9031 4.9239 10.8472 5.09909 10.8733 5.27055L11.1454 6.85843L9.71779 6.10922Z" fill="{{ $textColor }}"/>
                                <path d="M18.9133 9.80298C18.85 9.61288 18.6859 9.47497 18.4884 9.44515L16.114 9.0985L15.0517 6.94779C14.9623 6.76887 14.7796 6.65332 14.5783 6.65332C14.3771 6.65332 14.1944 6.76887 14.105 6.94779L13.0427 9.0985L10.6683 9.44515C10.4707 9.47497 10.3067 9.61288 10.2434 9.80298C10.18 9.99308 10.2322 10.2018 10.3776 10.3435L12.0959 12.0171L11.6896 14.384C11.6561 14.5815 11.7381 14.7791 11.8983 14.8983C12.0623 15.0176 12.2748 15.0325 12.4537 14.9393L14.5783 13.8211L16.703 14.9393C16.7812 14.9803 17.0459 15.0474 17.2583 14.8983C17.4224 14.7828 17.5006 14.5815 17.4671 14.384L17.0608 12.0171L18.7791 10.3435C18.9245 10.2018 18.9767 9.99308 18.9133 9.80298V9.80298ZM16.1289 11.4542C16.0059 11.5735 15.95 11.7487 15.9761 11.9201L16.2482 13.508L14.8244 12.7588C14.5783 12.6768 14.5783 12.6768 14.3361 12.7588L12.9122 13.508L13.1843 11.9201C13.2141 11.7487 13.1582 11.5772 13.0315 11.4542L11.8797 10.3323L13.475 10.1012C13.6465 10.0751 13.7956 9.96699 13.8701 9.81416L14.5821 8.37165L15.294 9.81416C15.3723 9.97071 15.5176 10.0788 15.6891 10.1012L17.2844 10.3323L16.1289 11.4542Z" fill="{{ $textColor }}"/>
                                <path d="M8.27157 9.44515L5.89721 9.0985L4.8349 6.94779C4.74544 6.76887 4.5628 6.65332 4.36152 6.65332C4.16024 6.65332 3.97759 6.76887 3.88814 6.94779L2.82583 9.0985L0.451467 9.44515C0.253914 9.47497 0.0899081 9.61288 0.0265422 9.80298C-0.0368237 9.99308 0.01536 10.2018 0.160729 10.3435L1.87906 12.0171L1.47278 14.384C1.43923 14.5815 1.52123 14.7791 1.68151 14.8983C1.84552 15.0176 2.05798 15.0325 2.23689 14.9393L4.36152 13.8211L6.48614 14.9393C6.56441 14.9803 6.82906 15.0474 7.04152 14.8983C7.20553 14.7828 7.2838 14.5815 7.25026 14.384L6.84397 12.0171L8.56231 10.3435C8.70395 10.2055 8.75613 9.99308 8.69649 9.80298C8.63313 9.61288 8.46912 9.47124 8.27157 9.44515V9.44515ZM5.91212 11.4542C5.78911 11.5735 5.7332 11.7487 5.75929 11.9201L6.0314 13.508L4.60753 12.7588C4.36152 12.6768 4.36152 12.6768 4.11924 12.7588L2.69537 13.508L2.96747 11.9201C2.99729 11.7487 2.94137 11.5772 2.81464 11.4542L1.65915 10.3323L3.25448 10.1012C3.42594 10.0751 3.57503 9.96699 3.64958 9.81416L4.36152 8.37165L5.07345 9.81416C5.15173 9.97071 5.2971 10.0788 5.46856 10.1012L7.06389 10.3323L5.91212 11.4542Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="text-xs rtl-direction-space ml-7p">{{ __('Be a seller') }}</span>
                            </a>
                        </li>
                    @endif

                    @includeIf('affiliate::layouts.includes.be_affiliate')

                    @if (isset($header['top']['show_compare']) && $header['top']['show_compare'] == 1)
                        @php
                            $productCount = \App\Compare\Compare::totalProduct();
                        @endphp
                        <li class="flex items-center">
                            <a href="{{ route('site.compare') }}" class="flex w-fill ltr:pl-30p rtl:pr-30p">
                                <div class="flex items-center justify-center text-xss roboto-medium rounded-full mr-7p rtl:ml-7p {{ !empty($productCount) ? 'w-4 h-4' : '' }} bg-reds-3 text-white" id="totalCompareItem">
                                    {{ !empty($productCount) ? $productCount : ''  }}
                                </div>
                                <svg  width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.0488 0.0126572C2.01118 0.0194979 1.8949 0.043438 1.79229 0.0639582C1.68969 0.0844793 1.46055 0.169981 1.2827 0.255483C1.01252 0.385445 0.909917 0.457267 0.677352 0.689831C0.444787 0.925816 0.372966 1.025 0.243003 1.29518C0.0412193 1.71585 -0.00324155 1.91422 0.000178515 2.36908C0.00701865 2.93682 0.171182 3.38484 0.547389 3.84313C0.776534 4.12016 1.22114 4.4177 1.59393 4.53741L1.72047 4.57845L1.73415 7.44104C1.74783 10.6217 1.73415 10.4439 1.98382 10.9535C2.27794 11.5588 2.84225 12.0171 3.50575 12.1881C3.68359 12.236 3.95036 12.2497 4.93534 12.2599L6.14604 12.277L5.69459 12.7285L5.24656 13.1765L5.65697 13.5869L6.06738 13.9973L7.06262 13.0055C7.60983 12.4583 8.07838 11.9658 8.10574 11.9042C8.1673 11.764 8.1673 11.5793 8.10574 11.4391C8.07838 11.3775 7.60983 10.8851 7.06262 10.3378L6.06738 9.34602L5.65697 9.75643L5.24656 10.1668L5.69801 10.6217L6.15288 11.0766L4.93876 11.0663L3.72463 11.0561L3.55363 10.9637C3.34842 10.8543 3.12954 10.632 3.0201 10.4233L2.93802 10.2694L2.92776 7.42394L2.92092 4.58187L3.04746 4.53741C4.08032 4.20566 4.76433 3.14886 4.63779 2.09548C4.51809 1.12418 3.89906 0.382025 2.97222 0.0981588C2.74307 0.0263376 2.19928 -0.0249634 2.0488 0.0126572ZM2.59601 1.20626C3.13296 1.34648 3.47497 1.78425 3.47497 2.33488C3.47497 2.60849 3.41341 2.80685 3.2595 3.01548C3.04404 3.31986 2.71229 3.48403 2.3224 3.48745C1.76835 3.48745 1.33058 3.14544 1.19036 2.59481C1.03988 1.99288 1.41267 1.37726 2.0317 1.20968C2.27452 1.1447 2.35319 1.1447 2.59601 1.20626Z" fill="{{ $textColor }}"/>
                                    <path d="M6.89801 1.02512C6.34738 1.57575 5.88225 2.07166 5.86173 2.12296C5.81385 2.25634 5.81727 2.4376 5.87541 2.56757C5.90277 2.62913 6.37132 3.12162 6.91853 3.66883L7.91377 4.66065L8.32418 4.25024L8.73459 3.83983L8.28314 3.38496L7.82827 2.93009L9.04239 2.94036L10.2565 2.95062L10.4275 3.04296C10.6327 3.1524 10.8516 3.3747 10.9611 3.58333L11.0431 3.73723L11.0534 6.58273L11.0602 9.4248L10.9337 9.46926C10.5199 9.60265 10.065 9.92071 9.80849 10.2627C9.48358 10.6902 9.33652 11.1314 9.33652 11.6718C9.33652 12.3216 9.55882 12.8551 10.0171 13.3134C10.3215 13.6178 10.5985 13.7854 11.026 13.9154C11.3886 14.0282 11.9289 14.0282 12.2915 13.9154C13.0883 13.6691 13.6561 13.1082 13.8955 12.325C14.2477 11.1759 13.6116 9.91729 12.4659 9.50005L12.2607 9.4248L12.247 6.57931C12.2367 4.01084 12.2299 3.71671 12.1786 3.51493C11.9973 2.84801 11.5219 2.27002 10.9132 1.97932C10.4754 1.77411 10.4002 1.76385 9.06291 1.74675L7.83511 1.72965L8.28656 1.2782L8.73459 0.830173L8.33102 0.426605C8.11213 0.207721 7.92061 0.0264578 7.91377 0.0264578C7.90351 0.0264578 7.44522 0.477906 6.89801 1.02512ZM12.0589 10.5808C12.4112 10.7039 12.6882 11.022 12.7908 11.4119C12.9994 12.2327 12.2196 13.0125 11.3988 12.8038C10.6498 12.6123 10.2873 11.836 10.6225 11.1451C10.8721 10.6321 11.5048 10.3824 12.0589 10.5808Z" fill="{{ $textColor }}"/>
                                </svg>
                                <span class="text-xs rtl-direction-space ml-7p">{{ __('Compare') }}</span>
                            </a>
                        </li>
                    @endif

                    @if (isset($header['top']['show_currency']) && $header['top']['show_currency'] == 1)
                        <button class="rtl-direction-space-left flex items-center justify-end ltr:pl-30p rtl:pr-30p">
                            
                            <div class="dropdown rounded shadow-none relative lang-dropdown currency">

                                <div class="select flex justify-between items-center lang-p">
                                    <p class="roboto-medium msg-color ltr:mr-1.5 rtl:ml-1.5"><span>{{ $defaultMulticurrency['symbol'] }}<span> {{ $defaultMulticurrency['name'] }}</p>
                                    @if(count($multiCurrencies) > 0 && preference('enable_multicurrency') == '1')
                                    <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z"
                                                fill="{{ $textColor }}" />
                                    </svg>
                                    @endif
                                </div>

                                @if(preference('enable_multicurrency') == '1')
                                <ul class="dropdown-menu language-dropdown border border-gray-11 ltr:-right-2 rtl:-left-2 top-30p">
                                    @foreach ($multiCurrencies as $multicurrency)
                                        <li id="{{ $multicurrency->currency?->name }}" class="Showing currency-change text-gray-10 {{ $defaultMulticurrency['currency_id'] == $multicurrency->currency_id ? ' primary-bg-color text-gray-12' : '' }}">
                                            <a class="roboto-medium text-xs text-left currency" data-currency_id="{{ $multicurrency->currency_id }}">
                                                {{ $multicurrency->currency?->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </button>
                    @endif

                    @php
                        $languages  = \App\Models\Language::getAll()->where('status', 'Active');
                    @endphp
                    @if ($languages->isNotEmpty() && isset($header['top']['show_language']) && $header['top']['show_language'] == 1)
                        <button class="rtl-direction-space-left flex items-center justify-end ltr:pl-30p rtl:pr-30p">
                            <span class="text-sm roboto-medium text-gray-12 ltr:mr-6 rtl:ml-6">
                                <svg class="ltr:-mr-2 rtl:-ml-2" width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.22222 0V4.27867C5.02711 4.15124 3.92648 3.73362 3.09069 3.09917C2.62635 2.74669 2.26451 2.34416 2.00906 1.91439C3.10808 0.870404 4.57949 0.169659 6.22222 0ZM7.77778 0V4.27867C8.97289 4.15124 10.0735 3.73362 10.9093 3.09917C11.3736 2.7467 11.7355 2.34416 11.9909 1.91439C10.8919 0.870406 9.42051 0.169659 7.77778 0ZM13.0019 3.13255C12.6939 3.53233 12.3204 3.90054 11.8902 4.22711C10.7609 5.08438 9.30819 5.60689 7.77778 5.73959L7.77778 7.26013C8.41133 7.31505 9.03445 7.437 9.62923 7.62402C10.4661 7.88714 11.2354 8.27553 11.8902 8.77263C12.3177 9.09708 12.692 9.46462 13.0021 9.86715C13.6356 8.88358 14 7.73154 14 6.5C14 5.26833 13.6356 4.11619 13.0019 3.13255ZM11.991 11.0856C11.7336 10.653 11.3698 10.2501 10.9093 9.90056C10.4086 9.52047 9.80605 9.21303 9.13305 9.00142C8.69923 8.86501 8.24368 8.77083 7.77778 8.72112V13C9.42054 12.8303 10.892 12.1296 11.991 11.0856ZM6.22222 13L6.22222 8.72112C5.75632 8.77083 5.30077 8.86501 4.86695 9.00142C4.19395 9.21303 3.5914 9.52047 3.09069 9.90056C2.63019 10.2501 2.26635 10.653 2.00901 11.0856C3.10803 12.1296 4.57946 12.8303 6.22222 13ZM0.997862 9.86715C1.30804 9.46462 1.68235 9.09708 2.10976 8.77263C2.76462 8.27553 3.53394 7.88714 4.37077 7.62402C4.96555 7.437 5.58867 7.31505 6.22222 7.26013V5.73959C4.69181 5.60689 3.23909 5.08438 2.10976 4.22711C1.67956 3.90054 1.30615 3.53233 0.998052 3.13255C0.364433 4.11618 0 5.26833 0 6.5C0 7.73154 0.364361 8.88358 0.997862 9.86715Z" fill="{{ $textColor }}"/>
                                </svg>
                            </span>

                            @php
                                $langData = Cache::get(config('cache.prefix') . '-user-language-' . optional(Auth::guard('user')->user())->id);
                                if (!auth()->user()) {
                                    $langData = Cache::get(config('cache.prefix') . '-guest-language-' . request()->server('HTTP_USER_AGENT'));
                                }
                                if (empty($langData)) {
                                    $langData = preference('dflt_lang');
                                }
                            @endphp
                            
                            <div id="directionSwitch" class="dropdown rounded shadow-none relative lang-dropdown lang"
                                data-value={{ $languages->where('short_name', $langData)->first()->direction }}>
                                <div class="select flex justify-between items-center lang-p">
                                    <p class="msg roboto-medium msg-color ltr:mr-1.5 rtl:ml-1.5">
                                        {{ $languages->where('short_name', $langData)->first()->name }} </p>
                                    <svg width="7" height="4" viewBox="0 0 7 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3.93933e-08 0.696543L0.737986 8.80039e-09L3.5 2.60691L6.26201 7.46738e-08L7 0.696543L3.5 4L3.93933e-08 0.696543Z"
                                            fill="{{ $textColor }}" />
                                    </svg>
                                </div>
                                <input type="hidden" name="Showing" value="English">
                                <ul class="dropdown-menu language-dropdown border border-gray-11 ltr:-right-2 rtl:-left-2 top-30p">
                                    @foreach ($languages as $language)
                                        <li id="{{ $language->name }}" class="Showing lang-change text-gray-10 {{ $langData == $language->short_name ? ' primary-bg-color text-gray-12' : '' }}">
                                            <a class="roboto-medium text-xs text-left lang" data-short_name="{{ $language->short_name }}">
                                                {{ $language->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </button>
                    @endif
                </ul>
            </div>
        </div>
        <div class="md:hidden">
            <div class="flex justify-end items-end rev">
                <ul class="flex">
                    <li>
                        @auth
                            <!--user dropdown start-->
                            <div class="flex relative inline-block">
                                <div class="relative text-sm" x-data="{ open: false }" x-cloak>
                                    <button @click="open = !open" class="flex items-center focus:outline-none">
                                        <div class="flex flex-col justify-center ltr:mr-10 rtl:ml-10 bg-gray-100 items-center h-9 w-9 rounded-full pink-blue dark:text-gray-2 hover:text-purple-500 cursor-pointer">
                                            <img class="h-9 w-9 rounded-full pink-blue dark:text-gray-2 hover:text-purple-500 cursor-pointer" src="{{ Auth::user()->fileUrlQuery() }}" alt="{{ __('Avatar of User') }}">
                                        </div>
                                    </button>
                                    <div x-show.transition="open" @click.away="open = false"
                                        class="absolute ltr:right-0 rtl:left-0 w-40 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700 overflow-auto z-50">
                                        <ul class="list-reset text-gray-600">
                                            @if (isset($header['main']['show_account']) && $header['main']['show_account'] == 1)
                                                <li class="flex">
                                                    <a href="{{ route('site.dashboard') }}"
                                                        class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" aria-hidden="true" fill="none"
                                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                        <span>{{ __('My Account') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                            @if ($userRole->type == 'admin')
                                                <li class="flex">
                                                    <a href="{{ route('dashboard') }}" target="_blank" class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 2H13V4H18.5858L10.2929 12.2929C9.90237 12.6834 9.90237 13.3166 10.2929 13.7071C10.6834 14.0976 11.3166 14.0976 11.7071 13.7071L20 5.41421V11H22V2Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.90036 5.04616C7.39907 5.00096 8.04698 5 9 5C9.55228 5 10 4.55229 10 4C10 3.44772 9.55228 3 9 3L8.95396 3C8.05849 2.99998 7.31952 2.99997 6.71983 3.05432C6.09615 3.11085 5.52564 3.23242 5 3.5359C4.39192 3.88697 3.88697 4.39192 3.5359 5C3.23242 5.52564 3.11085 6.09615 3.05432 6.71983C2.99997 7.31953 2.99998 8.05851 3 8.95399V14.0705C2.99996 15.4247 2.99993 16.5413 3.11875 17.4251C3.24349 18.3529 3.51546 19.1723 4.17157 19.8284C4.82768 20.4845 5.64711 20.7565 6.57494 20.8813C7.4587 21.0001 8.57532 21 9.92945 21H15.046C15.9415 21 16.6805 21 17.2802 20.9457C17.9039 20.8892 18.4744 20.7676 19 20.4641C19.6081 20.113 20.113 19.6081 20.4641 19C20.7676 18.4744 20.8891 17.9039 20.9457 17.2802C21 16.6805 21 15.9415 21 15.046L21 15C21 14.4477 20.5523 14 20 14C19.4477 14 19 14.4477 19 15C19 15.953 18.999 16.6009 18.9538 17.0996C18.9099 17.5846 18.8305 17.8295 18.732 18C18.5565 18.304 18.304 18.5565 18 18.7321C17.8295 18.8305 17.5846 18.9099 17.0996 18.9538C16.6009 18.999 15.953 19 15 19H10C8.55752 19 7.57625 18.9979 6.84143 18.8991C6.13538 18.8042 5.80836 18.6368 5.58579 18.4142C5.36321 18.1916 5.19584 17.8646 5.10092 17.1586C5.00212 16.4237 5 15.4425 5 14V9C5 8.04698 5.00096 7.39908 5.04616 6.90036C5.09011 6.41539 5.1695 6.17051 5.26795 6C5.44348 5.69596 5.69596 5.44349 6 5.26795C6.17051 5.16951 6.41539 5.09011 6.90036 5.04616Z" fill="#898989"/>
                                                        </svg>
                                                    <span class="break-all">{{ __('Admin Panel') }}</span>
                                                    </a>
                                                </li>
                                            @endif

                                            @if ($userRole->type == 'admin' || ($userRole->type == 'vendor' && optional(auth()->user()->vendors()->first())->status == 'Active'))
                                                <li class="flex">
                                                    <a href="{{ route('vendor-dashboard') }}" target="_blank" class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                        <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M22 2H13V4H18.5858L10.2929 12.2929C9.90237 12.6834 9.90237 13.3166 10.2929 13.7071C10.6834 14.0976 11.3166 14.0976 11.7071 13.7071L20 5.41421V11H22V2Z" fill="#898989"/>
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.90036 5.04616C7.39907 5.00096 8.04698 5 9 5C9.55228 5 10 4.55229 10 4C10 3.44772 9.55228 3 9 3L8.95396 3C8.05849 2.99998 7.31952 2.99997 6.71983 3.05432C6.09615 3.11085 5.52564 3.23242 5 3.5359C4.39192 3.88697 3.88697 4.39192 3.5359 5C3.23242 5.52564 3.11085 6.09615 3.05432 6.71983C2.99997 7.31953 2.99998 8.05851 3 8.95399V14.0705C2.99996 15.4247 2.99993 16.5413 3.11875 17.4251C3.24349 18.3529 3.51546 19.1723 4.17157 19.8284C4.82768 20.4845 5.64711 20.7565 6.57494 20.8813C7.4587 21.0001 8.57532 21 9.92945 21H15.046C15.9415 21 16.6805 21 17.2802 20.9457C17.9039 20.8892 18.4744 20.7676 19 20.4641C19.6081 20.113 20.113 19.6081 20.4641 19C20.7676 18.4744 20.8891 17.9039 20.9457 17.2802C21 16.6805 21 15.9415 21 15.046L21 15C21 14.4477 20.5523 14 20 14C19.4477 14 19 14.4477 19 15C19 15.953 18.999 16.6009 18.9538 17.0996C18.9099 17.5846 18.8305 17.8295 18.732 18C18.5565 18.304 18.304 18.5565 18 18.7321C17.8295 18.8305 17.5846 18.9099 17.0996 18.9538C16.6009 18.999 15.953 19 15 19H10C8.55752 19 7.57625 18.9979 6.84143 18.8991C6.13538 18.8042 5.80836 18.6368 5.58579 18.4142C5.36321 18.1916 5.19584 17.8646 5.10092 17.1586C5.00212 16.4237 5 15.4425 5 14V9C5 8.04698 5.00096 7.39908 5.04616 6.90036C5.09011 6.41539 5.1695 6.17051 5.26795 6C5.44348 5.69596 5.69596 5.44349 6 5.26795C6.17051 5.16951 6.41539 5.09011 6.90036 5.04616Z" fill="#898989"/>
                                                        </svg>
                                                    <span>{{ __('Vendor Panel') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="flex">
                                                <a href="{{ route('site.logout') }}"
                                                    class="inline-flex items-center w-full px-2 py-1 text-sm transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                                                    <svg class="w-4 h-4 ltr:mr-3 rtl:ml-3" aria-hidden="true" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path
                                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                        </path>
                                                    </svg>
                                                    <span>{{ __('Logout') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- user dropdown end -->
                        @else
                            <!-- unauthenticated -->
                            <div
                                class="flex flex-col justify-center ltr:mr-11 rtl:ml-11 items-center cursor-pointer open-login-modal">
                                <svg width="21" height="22" viewBox="0 0 21 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10.4102 2.38517C8.43424 2.38517 6.83243 3.98698 6.83243 5.96291C6.83243 7.93885 8.43424 9.54066 10.4102 9.54066C12.3861 9.54066 13.9879 7.93885 13.9879 5.96291C13.9879 3.98698 12.3861 2.38517 10.4102 2.38517ZM4.44727 5.96291C4.44727 2.66969 7.11695 0 10.4102 0C13.7034 0 16.3731 2.66969 16.3731 5.96291C16.3731 9.25614 13.7034 11.9258 10.4102 11.9258C7.11695 11.9258 4.44727 9.25614 4.44727 5.96291Z"
                                        fill="#2C2C2C" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M4.00564 15.9486C5.86929 14.8761 8.11934 14.311 10.4085 14.311C12.6976 14.311 14.9477 14.8761 16.8113 15.9486C18.6743 17.0207 20.0908 18.5688 20.7471 20.4058C20.9687 21.0261 20.6455 21.7085 20.0253 21.9301C19.405 22.1517 18.7226 21.8286 18.501 21.2083C18.0701 20.0024 17.0911 18.8615 15.6216 18.0159C14.1528 17.1706 12.3198 16.6961 10.4085 16.6961C8.49717 16.6961 6.66414 17.1706 5.19535 18.0159C3.72586 18.8615 2.74681 20.0024 2.31597 21.2083C2.09437 21.8286 1.41193 22.1517 0.791676 21.9301C0.171426 21.7085 -0.151748 21.0261 0.0698463 20.4058C0.726164 18.5688 2.14268 17.0207 4.00564 15.9486Z"
                                        fill="#2C2C2C" />
                                </svg>
                            </div>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="block md:hidden">
        <div class="fixed bottom-0 left-0 right-0 z-50 flex h-14 justify-around border-t border-gray-200 bg-white shadow-lg">
            <div class="flex flex-col items-center justify-center text-gray-950">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="{1.5}"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                />
            </svg>
            <div class="text-sm">Home</div>
            </div>
            <div class="flex flex-col items-center justify-center text-gray-950">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="{1.5}"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"
                />
            </svg>
            <div class="text-sm">Categories</div>
            </div>
            <div class="flex flex-col items-center justify-center text-gray-950">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="{1.5}"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                />
            </svg>
            <div class="text-sm">Categories</div>
            </div>
            <div class="flex flex-col items-center justify-center text-gray-950">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                strokeWidth="{1.5}"
                stroke="currentColor"
                class="h-6 w-6"
            >
                <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                />
            </svg>
        
            <div class="text-sm">Account</div>
            </div>
        </div>
    </div>
</section>
