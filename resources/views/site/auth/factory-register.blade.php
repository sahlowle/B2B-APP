@extends('site.auth.layout')

@section('title')
    {{ __("Factory Registration") }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/gh/priyashpatil/phone-input-by-country@0.0.1/cpi.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
        <!-- CSS -->
<link href="https://unpkg.com/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@php
    $uppercase = $lowercase = $number = $symbol = $length = 0;
    if (env('PASSWORD_STRENGTH') != null && env('PASSWORD_STRENGTH') != '') {
        $length = filter_var(env('PASSWORD_STRENGTH'), FILTER_SANITIZE_NUMBER_INT);
        $conditions = explode('|', env('PASSWORD_STRENGTH'));
        $uppercase = in_array('UPPERCASE', $conditions);
        $lowercase = in_array('LOWERCASE', $conditions);
        $number = in_array('NUMBERS', $conditions);
        $symbol = in_array('SYMBOLS', $conditions);
    }
@endphp
   
    <!-- Modern Factory Registration Form -->
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <div class="flex justify-center mx-auto">
                <img class="w-auto h-7 md:h-20" src="https://exportsvalley.com/public/uploads/20250809/dbe06c7860a0e3390969d8392dbcd898.webp" alt="">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ __('Seller Registration Form') }}</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">{{ __('Register now with few easy steps!') }}</p>
            <div class="w-24 h-1 mx-auto mt-6 rounded-full" style="background: linear-gradient(to right, var(--primary-color), color-mix(in srgb, var(--primary-color) 80%, black));"></div>
        </div>

        <!-- Alert Messages -->
        @error('fail')
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ $message }}</p>
                    </div>
                </div>
            </div>
        @enderror

        @php
            $colors = ['fail' => 'red', 'info' => 'red', 'success' => 'green']
        @endphp
        @foreach (['success', 'fail', 'info'] as $msg)
            @if ($message = Session::get($msg))
                <div class="mb-6 bg-{{ $colors[$msg] }}-50 border border-{{ $colors[$msg] }}-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            @if($msg === 'success')
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            @else
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-{{ $colors[$msg] }}-700">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Note Section -->
        <div class="rounded-lg p-4 mb-8" style="background-color: color-mix(in srgb, var(--primary-color) 5%, white); border: 1px solid color-mix(in srgb, var(--primary-color) 20%, white);">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5" style="color: color-mix(in srgb, var(--primary-color) 60%, white);" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm" style="color: color-mix(in srgb, var(--primary-color) 80%, black);">{{ __('Note: Please make sure to fill in the form with your actual information or else your account may become banned or suspended.') }}</p>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <form method="post" action="{{ auth()->user() ? route('seller.store.request') : route('site.seller.signUpStore') }}" 
              class="bg-white shadow-xl rounded-2xl p-8" onsubmit="return formValidation()">
            @csrf

            <!-- SmartWizard Steps -->
            <div id="smartwizard" class="mb-8">
                <ul class="nav flex items-center justify-between">
                    <li class="nav-item">
                        <a class="nav-link flex items-center" href="#step-1">
                            <div class="num">1</div>
                            <span class="text-sm font-medium text-gray-900">{{ __('Basic Details') }}</span>
                        </a>
                    </li>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <li class="nav-item">
                        <a class="nav-link flex items-center" href="#step-2">
                            <div class="num">2</div>
                            <span class="text-sm font-medium text-gray-500">{{ __('Address Details') }}</span>
                        </a>
                    </li>
                    <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    <li class="nav-item">
                        <a class="nav-link flex items-center" href="#step-3">
                            <div class="num">3</div>
                            <span class="text-sm font-medium text-gray-500">{{ __('Shop Details') }}</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Step 1: Basic Details -->
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('Basic Details') }}
                                </h3>

                                @guest
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('First Name') }} <span class="text-red-500">*</span></label>
                                            <input type="text" name="f_name" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   value="{{ old('f_name') }}" 
                                                   placeholder="{{ __('Enter Your :x', ['x' => __('First Name')]) }}">
                                            @error('f_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Last Name') }} <span class="text-red-500">*</span></label>
                                            <input type="text" name="l_name" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   value="{{ old('l_name') }}" 
                                                   placeholder="{{ __('Enter Your :x', ['x' => __('Last Name')]) }}">
                                            @error('l_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endguest

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Phone Number') }} <span class="text-red-500">*</span></label>
                                        <div class="flex" dir="ltr" >
                                            <span class="inline-flex items-center px-4 py-3 text-sm text-gray-700 bg-gray-50 border border-r-0 border-gray-300 rounded-l-lg">
                                                🇸🇦 +966
                                            </span>
                                            <input type="tel" name="phone" required pattern="5[0-9]{8}" maxlength="9"
                                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-r-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   oninvalid="this.setCustomValidity('Please enter a valid Saudi phone number (5xxxxxxxx)')" 
                                                   oninput="this.setCustomValidity('')"
                                                   value="{{ old('phone') }}" 
                                                   placeholder="5xxxxxxxx">
                                            <input type="hidden" name="country_code" value="+966">
                                        </div>
                                        @error('phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @guest
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Email Address') }} <span class="text-red-500">*</span></label>
                                            <input type="email" name="email" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   value="{{ old('email') }}" 
                                                   placeholder="{{ __('Enter Your :x', ['x' => __('Email')]) }}" 
                                                   autocomplete="new-email">
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @else
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Alias') }} <span class="text-red-500">*</span></label>
                                            <input type="text" name="alias" required 
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   value="{{ old('alias') }}" 
                                                   placeholder="{{ __('Enter Your :x', ['x' => __('Alias')]) }}">
                                            @error('alias')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Address Details -->
                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ __('Address Details') }}
                                </h3>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Address') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="address" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                               style="--tw-ring-color: var(--primary-color);"
                                               value="{{ old('address') }}" 
                                               placeholder="{{ __('Enter Your :x', ['x' => __('Address')]) }}">
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    @auth
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Description') }} <span class="text-red-500">*</span></label>
                                            <textarea name="description" required rows="3"
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                      style="--tw-ring-color: var(--primary-color);"
                                                      placeholder="{{ __('Enter Your :x', ['x' => __('Description')]) }}">{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endauth

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Country') }} <span class="text-red-500">*</span></label>
                                            <select name="country" id="country" required 
                                                    class="w-full px-4 py-3 border border-gray-300">
                                                <option value="">{{ __('Select Country') }}</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('State') . ' / ' . __('Province') }}</label>
                                            <select name="state" id="state" 
                                                   class="w-full px-4 py-3 border border-gray-300">
                                                <option value="">{{ __('Select State') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('City') }} <span class="text-red-500">*</span></label>
                                            <select name="city" id="city" required 
                                                    class="w-full px-4 py-3 border border-gray-300">
                                                <option value="">{{ __('Select City') }}</option>
                                            </select>
                                        </div>
                                        @guest
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Postcode') . ' / ' . __('ZIP') }} <span class="text-red-500">*</span></label>
                                                <input type="text" name="post_code" required 
                                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                       style="--tw-ring-color: var(--primary-color);"
                                                       value="{{ old('post_code') }}" 
                                                       placeholder="{{ __('Enter Your :x', ['x' => __('Postcode')]) }}">
                                                @error('post_code')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Shop Details -->
                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    {{ __('Shop Details') }}
                                </h3>

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Shop Name') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="shop_name" maxlength="191" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                               style="--tw-ring-color: var(--primary-color);"
                                               value="{{ old('shop_name') }}" 
                                               placeholder="{{ __('Enter Your :x', ['x' => __('Shop Name')]) }}">
                                        @error('shop_name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Commercial Registration Number') }} <span class="text-red-500">*</span></label>
                                        <input type="text" name="commercial_registration_number" maxlength="191" required 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                               style="--tw-ring-color: var(--primary-color);"
                                               value="{{ old('commercial_registration_number') }}" 
                                               placeholder="{{ __('Enter Your :x', ['x' => __('Commercial Registration Number')]) }}">
                                        @error('commercial_registration_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @guest
                                <!-- Account Section -->
                                <div class="border-b border-gray-200 pb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        {{ __('Account') }}
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <label class="block text-sm font-medium text-gray-700">{{ __('Enter Password') }} <span class="text-red-500">*</span></label>
                                                <div class="relative group">
                                                    <svg class="w-5 h-5 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div class="absolute bottom-full right-0 mb-2 w-64 p-3 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                                                        {{ __('Password must be at least :x characters. Contain uppercase and lowercase letters, numbers and special characters.', ['x' => $length]) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="relative">
                                                <input type="password" name="password" id="password_seller" required autocomplete="new-password"
                                                       class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 password-validation"
                                                       style="--tw-ring-color: var(--primary-color);"
                                                       placeholder="{{ __('Enter Password') }}">
                                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password">
                                                    <svg class="h-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Repeat Password') }} <span class="text-red-500">*</span></label>
                                            <input type="password" name="password_confirmation" id="password_confirm" required autocomplete="new-password"
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition duration-200"
                                                   style="--tw-ring-color: var(--primary-color);"
                                                   placeholder="{{ __('Repeat Password') }}">
                                            <span class="password-validation-match-error block text-sm mt-1"></span>
                                        </div>
                                    </div>
                                </div>
                            @endguest

                            @include('admin.auth.partial.re-captcha')

                            <!-- Submit Button -->
                            <div class="flex justify-center pt-8">
                                <button type="submit" onclick="formValidation()" id="btnSubmits"
                                        class="inline-flex items-center px-8 py-4 text-white font-semibold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transform transition-all duration-200 hover:scale-105 shadow-lg"
                                        style="background: linear-gradient(to right, var(--primary-color), color-mix(in srgb, var(--primary-color) 80%, black)); --tw-ring-color: var(--primary-color);"
                                        onmouseover="this.style.background='linear-gradient(to right, color-mix(in srgb, var(--primary-color) 90%, black), color-mix(in srgb, var(--primary-color) 70%, black))'"
                                        onmouseout="this.style.background='linear-gradient(to right, var(--primary-color), color-mix(in srgb, var(--primary-color) 80%, black))'">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
    <script>
        'use strict';
        var SITE_URL = "{{ URL::to('/') }}";
        var uppercase = "{!! auth()->user() ? false : $uppercase !!}";
        var lowercase = "{!! auth()->user() ? false : $lowercase !!}";
        var number = "{!! auth()->user() ? false : $number !!}";
        var symbol = "{!! auth()->user() ? false : $symbol !!}";
        var length = "{!! auth()->user() ? false : $length !!}";
        var oldCountry = "{!! old('country') ?? 'null' !!}";
        var oldState = "{!! old('state') ?? 'null' !!}";
        var oldCity = "{!! old('city') ?? 'null' !!}";
    </script>
    <script src="{{ asset('public/dist/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/formatting.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('public/dist/plugins/jQueryUI/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/alpine.min.js') }}" defer></script>
    <script src="{{ asset('public/dist/js/custom/site/drawer.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/lang.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/site-nav.min.js?v=3.0') }}"></script>
    <script src="{{ asset('public/frontend/assets/js/sweet-alert2.min.js') }}"></script>

    <script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/site/seller.min.js') }}"></script>
    <script src="{{ asset('public/dist/js/custom/validation.min.js') }}"></script>
    <!-- Sign Up Script -->
    @includeIf ('externalcode::layouts.scripts.signUpScript')
    

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

    <script>
           $('#smartwizard').smartWizard({
            theme: 'dots',
            selected: 0, // Initial selected step, 0 = first step
            justified: true, // Nav menu justification. true/false
            autoAdjustHeight: true, // Automatically adjust content height
            backButtonSupport: true, // Enable the back button support
            enableUrlHash: true, // Enable selection of the step based on url hash
            transition: {
                animation: 'slideHorizontal', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
                speed: '400', // Animation speed. Not used if animation is 'css'
                easing: '', // Animation easing. Not supported without a jQuery easing plugin. Not used if animation is 'css'
                prefixCss: '', // Only used if animation is 'css'. Animation CSS prefix
                fwdShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on forward direction
                fwdHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on forward direction
                bckShowCss: '', // Only used if animation is 'css'. Step show Animation CSS on backward direction
                bckHideCss: '', // Only used if animation is 'css'. Step hide Animation CSS on backward direction
            },
            toolbar: {
                position: 'bottom', // none|top|bottom|both
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                extraHtml: '' // Extra html to show on toolbar
            },
            anchor: {
                enableNavigation: true, // Enable/Disable anchor navigation 
                enableNavigationAlways: false, // Activates all anchors clickable always
                enableDoneState: true, // Add done state on visited steps
                markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
                enableDoneStateNavigation: true // Enable/Disable the done state navigation
            },
            keyboard: {
                keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                keyLeft: [37], // Left key code
                keyRight: [39] // Right key code
            },
            lang: { // Language variables for button
                next: '{{ __('Next') }}',
                previous: '{{ __('Previous') }}'
            }
        });

        $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {

            formId = "step-" + (currentStepIndex+1);
            
            container = document.getElementById(formId);
            inputs = container.querySelectorAll('input, select, textarea');

            console.log(inputs);

            let allValid = true;

            inputs.forEach(input => {
                if (!input.reportValidity()) {
                    allValid = false;
                }
            });

            return allValid;

        });

    </script>
@endsection
