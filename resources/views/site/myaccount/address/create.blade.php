@extends('site.myaccount.layouts.master')
@section('page_title', __('Create Address'))
@section('content')
@php
    $countries = \App\Models\Country::getAll();
    $addresses = \App\Models\Address::getAll()->where('user_id', auth()->user()->id);
@endphp
    <main class="md:w-3/5 lg:w-3/4 w-full main-content flex flex-col flex-1 address-form" id="customer_address_create">
        <p class="text-2xl text-black font-medium">{{ __("New Address") }}</p>
        <div class="md:w-3/5 lg:w-3/4 w-full mt-5">
            <form class="w-full" action="{{ route('site.address.store') }}" method="post" id="addressForm" onsubmit="return formValidation()">
                @csrf
                <div class="bg-neutral-100 p-5 rounded-lg">
                    <div class="grid grid-cols-2 lg:gap-3 gap-4">
                        @if (preference('address_first_name_visible', 1))
                            <div class="mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_first_name_required', 1) ? 'require-profile' : '' }}" for="first_name">
                                    {{ __('First Name') }}</label>
                                <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-gray-600 form-control focus:border-gray-300 px-2 mt-1.5"
                                    type="text" 
                                    name="first_name" 
                                    {{ preference('address_first_name_required', 1) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                        
                        @if (preference('address_last_name_visible', 1))
                            <div class="mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_last_name_required', 0) ? 'require-profile' : '' }}"
                                    for="last_name">{{ __('Last Name') }}</label>
                                <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-gray-600 form-control focus:border-gray-300 px-2 mt-1.5" 
                                    {{ preference('address_last_name_required', 0) ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                    name="last_name"
                                    type="text">
                            </div>
                        @endif
                        
                        @if (preference('address_company_name_visible', 1))
                            <div class="mb-5">
                                <label class=" text-sm font-normal capitalize text-black {{ preference('address_company_name_required', 0) ? 'require-profile' : '' }}" for="company_name">{{ __('Company Name') }} </label>
                                <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-gray-600 form-control focus:border-gray-300 px-2 mt-1.5" 
                                    type="text" 
                                    name="company_name" 
                                    id="compnay_name" 
                                    value="{{ old('company_name') }}" 
                                    {{ preference('address_company_name_required', 0) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                        
                        @if (preference('address_email_visible', 1))
                            <div class="mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_email_required', 0) ? 'require-profile' : '' }}" for="email">
                                    {{ __('Email Address') }}</label>
                                <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5" 
                                    type="email" 
                                    name="email" 
                                    {{ preference('address_email_required', 0) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                        
                        @if (preference('address_phone_visible', 1))
                            <div class="mb-5 set-dial">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_phone_required', 1) ? 'require-profile' : '' }}">
                                    {{ __('Phone Number') }}</label>
                                <input class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5 ltr:text-left rtl:text-right" 
                                    {{ preference('address_phone_required', 1) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')"
                                    name="phone" >
                            </div>
                        @endif
                        
                        @if (preference('address_street_address_1_visible', 1))
                            <div class="mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_street_address_1_required', 1) ? 'require-profile' : '' }}" for="address_1">
                                    {{ __('Street Address 1') }}</label>
                                <input  name="address_1" type="text"class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5"
                                    {{ preference('address_street_address_1_required', 1) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                        
                        @if (preference('address_street_address_2_visible', 1))
                            <div class="mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_street_address_2_required', 0) ? 'require-profile' : '' }}"
                                    for="address_2">{{ __('Street Address 2') }}</label>
                                <input id="address_2" name="address_2" type="text" placeholder="{{ __('Address Line 2') . ' (' . __('optional') . ')' }}" 
                                    class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5" 
                                    {{ preference('address_street_address_2_required', 0) ? 'required' : '' }} 
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                        
                        @if (preference('address_country_visible', 1))
                            <div class="w-full validSelect gender-container mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_country_required', 1) ? 'require-profile' : '' }}" for="country">
                                    {{ __('Country') }} </label>
                                <select id="country" name="country" class="addressSelect border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5 country"
                                    {{ preference('address_country_required', 1) ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option>{{ __('Select Country') }}</option>
                                </select>
                            </div>
                        @endif
                        
                        @if (preference('address_state_visible', 1))
                            <div class="w-full validSelect gender-container mb-5">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_state_required', 1) ? 'require-profile' : '' }}"
                                    for="state">{{ __('State') . ' / ' . __('Province') }} </label>
                                <select name="state"  id="state" class="addressSelect border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5 country addressSelect"
                                    {{ preference('address_state_required', 1) ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value="">{{ __('Select State') }}</option>
                                </select>
                            </div>
                        @endif
                        
                        @if (preference('address_city_visible', 1))
                            <div class="validSelect gender-container">
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_city_required', 1) ? 'require-profile' : '' }}" for="city">
                                    {{ __('City') }}</label>
                                <select name="city" id="city" 
                                    class="addressSelect border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5 country addressSelect"
                                    {{ preference('address_city_required', 1) ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                                    <option value="">{{ __('Select City') }}</option>
                                </select>
                            </div>
                        @endif
                        
                        @if (preference('address_zip_visible', 1))
                            <div>
                                <label class="text-sm font-normal capitalize text-black {{ preference('address_zip_required', 0) ? 'require-profile' : '' }}" for="zip">
                                    {{ __('Postcode') . ' / ' . __('ZIP') }} </label>
                                <input name="zip" type="text" maxlength="10"
                                    class="border border-gray-300 rounded w-full h-11 font-medium text-sm text-black form-control focus:border-gray-300 mt-1.5"
                                    {{ preference('address_zip_required', 0) ? 'required' : '' }}
                                    oninvalid="this.setCustomValidity('{{ __('This field is required.') }}')">
                            </div>
                        @endif
                    </div>
                    
                    @if (preference('address_type_of_place_visible', 1))
                        <div class="mt-6">
                            <p class="text-sm font-normal capitalize text-black {{ preference('address_type_of_place_required', 1) ? 'require-profile' : '' }}">
                                {{ __('Select the type of your place') }} </p>
                            <div class="flex mt-1.5 radio-buttons gap-3">
                                <label class="custom-radio">
                                    <input type="radio" class="hidden radio-test" name="type_of_place" value="home" />
                                    <span class="radio-btn lg:w-36 lg:h-14 border border-gray-300 rounded  cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-5 rtl:pr-5 text-black bg-white">
                                        <svg class="ltr:right-0 rtl:left-0 bg-yellow-300 p-1 rounded-full absolute opacity-0 w-5 h-5 top-1"
                                            xmlns="http://www.w3.org/2000/svg" width="11" height="9"
                                            viewBox="0 0 11 9" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                fill="currentColor" />
                                        </svg>
                                        <div class="ltr:lg:ml-5 ltr:ml-2 rtl:lg:mr-5 rtl:mr-2">
                                            <div class="flex items-center">
                                                <svg class="my-4 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                                    height="18" viewBox="0 0 16 18" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M6.57318 1.76695C5.97512 2.15794 5.27179 2.75321 4.27687 3.59733L3.22194 4.49239C2.09056 5.4523 1.68078 5.81759 1.46221 6.28799C1.24439 6.75675 1.23083 7.29905 1.23083 8.77444V13.2024C1.23083 14.2048 1.23218 14.8929 1.30238 15.4097C1.36998 15.9075 1.49089 16.1528 1.66444 16.3246C1.83961 16.498 2.09219 16.6198 2.60059 16.6875C3.12551 16.7573 3.82351 16.7586 4.83519 16.7586H11.1648C12.1765 16.7586 12.8745 16.7573 13.3994 16.6875C13.9078 16.6198 14.1604 16.498 14.3356 16.3246C14.5091 16.1528 14.63 15.9075 14.6976 15.4097C14.7678 14.8929 14.7692 14.2048 14.7692 13.2024V8.77444C14.7692 7.29905 14.7556 6.75675 14.5378 6.28799C14.3192 5.81759 13.9094 5.4523 12.7781 4.49239L11.7231 3.59733C10.7282 2.75321 10.0249 2.15794 9.42682 1.76695C8.84342 1.38555 8.42216 1.24138 8 1.24138C7.57784 1.24138 7.15658 1.38555 6.57318 1.76695ZM5.90376 0.725255C6.59589 0.27277 7.25143 0 8 0C8.74858 0 9.40411 0.27277 10.0962 0.725255C10.7663 1.1633 11.5277 1.80936 12.4835 2.62032L13.5703 3.54241C13.6072 3.57366 13.6435 3.60449 13.6794 3.63494C14.6614 4.4675 15.3044 5.01269 15.6522 5.76119C16.0007 6.51119 16.0004 7.3524 16 8.63193C16 8.67884 15.9999 8.72633 15.9999 8.77444V13.2476C16 14.1936 16 14.9673 15.917 15.5782C15.8301 16.2179 15.642 16.7707 15.1976 17.2106C14.7548 17.6489 14.2011 17.8329 13.5604 17.9182C12.9455 18 12.1659 18 11.2083 18H4.79168C3.83408 18 3.05447 18 2.43959 17.9182C1.79889 17.8329 1.24518 17.6489 0.802382 17.2106C0.357973 16.7707 0.169894 16.2179 0.0830068 15.5782C2.77297e-05 14.9673 4.46799e-05 14.1936 6.54405e-05 13.2476L6.61741e-05 8.77444C6.61741e-05 8.72633 4.92282e-05 8.67883 3.25023e-05 8.63192C-0.000424671 7.3524 -0.0007253 6.51119 0.347765 5.76119C0.695552 5.01269 1.33858 4.46751 2.32056 3.63494C2.35647 3.60449 2.39284 3.57366 2.42967 3.54241L3.51646 2.62033C4.47226 1.80937 5.23373 1.1633 5.90376 0.725255Z"
                                                        fill="currentColor" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5 11.3333C5 10.597 5.53726 10 6.2 10H9.8C10.4627 10 11 10.597 11 11.3333V17.3333C11 17.7015 10.7314 18 10.4 18C10.0686 18 9.8 17.7015 9.8 17.3333V11.3333H6.2V17.3333C6.2 17.7015 5.93137 18 5.6 18C5.26863 18 5 17.7015 5 17.3333V11.3333Z"
                                                        fill="currentColor" />
                                                </svg>
                                                <span class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Home') }}</span>
                                            </div>
                                        </div>
                                    </span>
                                </label>
                                <label class="custom-radio">
                                    <input type="radio" class="hidden radio-test" name="type_of_place" value="office" />
                                    <span class="radio-btn lg:w-36 lg:h-14 border border-gray-300 rounded  cursor-pointer relative inline-block font-medium text-center lg:text-sm text-xs ltr:pl-5 rtl:pr-5 text-black bg-white">
                                        <svg class="ltr:right-0 rtl:left-0 bg-yellow-300 p-1 rounded-full absolute opacity-0 w-5 h-5 top-1"
                                            xmlns="http://www.w3.org/2000/svg" width="11" height="9"
                                            viewBox="0 0 11 9" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M11 1.41885L4.38163 9L8.22563e-07 4.81748L1.64177 3.25031L4.22561 5.71673L9.21633 -4.01642e-07L11 1.41885Z"
                                                fill="currentColor" />
                                        </svg>
                                        <div class="ltr:lg:ml-5 ltr:ml-2 rtl:lg:mr-5 rtl:mr-2">
                                            <div class="flex items-center">
                                                <svg class="my-4 w-5 h-5" width="21" height="20" viewBox="0 0 21 20"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16.1194 18.0009H4.82176C4.07382 17.9995 3.3569 17.7062 2.82802 17.1852C2.29914 16.6642 2.0014 15.9579 2 15.2211V8.55064C2 7.81291 2.29712 7.10532 2.82615 6.58318C3.35519 6.06104 4.0729 5.76701 4.82176 5.76562H16.1194C16.8683 5.76701 17.586 6.06104 18.115 6.58318C18.6441 7.10532 18.9412 7.81291 18.9412 8.55064V15.2211C18.9398 15.9579 18.642 16.6642 18.1132 17.1852C17.5843 17.7062 16.8674 17.9995 16.1194 18.0009ZM4.82176 6.88172C4.37246 6.88172 3.94155 7.05755 3.62384 7.37053C3.30613 7.68352 3.12765 8.10802 3.12765 8.55064V15.2211C3.12765 15.6637 3.30613 16.0882 3.62384 16.4012C3.94155 16.7142 4.37246 16.89 4.82176 16.89H16.1194C16.5687 16.89 16.9996 16.7142 17.3173 16.4012C17.635 16.0882 17.8135 15.6637 17.8135 15.2211V8.55064C17.8135 8.10802 17.635 7.68352 17.3173 7.37053C16.9996 7.05755 16.5687 6.88172 16.1194 6.88172H4.82176Z"
                                                        fill="#2C2C2C" />
                                                    <path
                                                        d="M13.6073 4.76984C13.5247 4.76984 13.4428 4.75545 13.3665 4.72751C13.2902 4.69957 13.2208 4.65861 13.1624 4.60698C13.104 4.55534 13.0576 4.49404 13.026 4.42658C12.9944 4.35912 12.9781 4.28681 12.9781 4.21379V3.66294C12.9781 3.51637 12.9126 3.37571 12.7959 3.27158C12.6792 3.16745 12.5207 3.10827 12.3548 3.1069H8.59159C8.42472 3.1069 8.26469 3.16548 8.1467 3.26976C8.02871 3.37404 7.96242 3.51547 7.96242 3.66294V4.21379C7.9709 4.29098 7.96101 4.36888 7.93339 4.44248C7.90578 4.51609 7.86104 4.58378 7.80207 4.6412C7.74309 4.69862 7.67118 4.74451 7.59095 4.77591C7.51072 4.80731 7.42394 4.82353 7.3362 4.82353C7.24845 4.82353 7.16167 4.80731 7.08144 4.77591C7.00121 4.74451 6.9293 4.69862 6.87033 4.6412C6.81135 4.58378 6.76662 4.51609 6.739 4.44248C6.71139 4.36888 6.7015 4.29098 6.70997 4.21379V3.66294C6.70997 3.2219 6.90821 2.79893 7.26108 2.48706C7.61396 2.1752 8.09255 2 8.59159 2H12.3548C12.8539 2 13.3325 2.1752 13.6853 2.48706C14.0382 2.79893 14.2364 3.2219 14.2364 3.66294V4.21379C14.2364 4.28681 14.2202 4.35912 14.1886 4.42658C14.1569 4.49404 14.1106 4.55534 14.0522 4.60698C13.9937 4.65861 13.9244 4.69957 13.848 4.72751C13.7717 4.75545 13.6899 4.76984 13.6073 4.76984Z"
                                                        fill="#2C2C2C" />
                                                    <path
                                                        d="M10.4528 12.3526C9.90611 12.3463 9.36647 12.2014 8.8681 11.9272L5.17048 9.9354C5.03039 9.86104 4.92024 9.72181 4.86427 9.54834C4.8083 9.37487 4.81109 9.18138 4.87203 9.01043C4.93297 8.83947 5.04707 8.70506 5.18923 8.63676C5.33138 8.56846 5.48995 8.57187 5.63004 8.64624L9.32766 10.6509C9.68777 10.8458 10.0773 10.9465 10.4713 10.9465C10.8652 10.9465 11.2548 10.8458 11.6149 10.6509L15.3125 8.64624C15.3819 8.60941 15.4565 8.58963 15.5321 8.588C15.6078 8.58637 15.6829 8.60294 15.7533 8.63676C15.8237 8.67058 15.888 8.72098 15.9424 8.7851C15.9968 8.84921 16.0403 8.92578 16.0705 9.01043C16.1007 9.09507 16.1169 9.18615 16.1182 9.27844C16.1196 9.37074 16.106 9.46245 16.0783 9.54834C16.0506 9.63423 16.0093 9.71262 15.9567 9.77904C15.9042 9.84545 15.8414 9.89858 15.7721 9.9354L12.0375 11.9272C11.5391 12.2014 10.9995 12.3463 10.4528 12.3526Z"
                                                        fill="#2C2C2C" />
                                                </svg>
                                                <span class="lg:my-0 my-3 ltr:ml-2 ltr:lg:mr-0 ltr:mr-9 rtl:mr-2 rtl:lg:ml-0 rtl:ml-9">{{ __('Office') }}</span>
                                            </div>
                                        </div>
                                    </span>
                                </label>
                            </div>
                        </div>
                        @if (preference('address_type_of_place_required', 1))
                            <p id="radio-error-msg" class="hidden font-normal text-11 text-reds-5 -mt-5 radio-error-msg"><br><br>{{ __('This field is required.') }}</p>
                        @endif
                    @endif
                </div>
                <div class="flex gap-3 mt-6">
                    <button class="save-add-func items-center cursor-pointer py-2.5 px-6 font-medium text-sm whitespace-nowrap text-black hover:text-white bg-yellow-400 hover:bg-black rounded">{{ __('Save Address') }}</button>
                    <a href="{{ route('site.address') }}" class="text-center rounded py-2.5 px-6 cursor-pointer font-medium text-sm text-gray-12 bg-white border border-gray-2 hover:border-gray-12">{{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection

@section('js')
    <script>
        'use strict';
        let oldCountry = "{!! old('country') ?? 'null' !!}";
        let oldState = "{!! old('state') ?? 'null' !!}";
        let oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
@endsection
