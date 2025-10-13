@extends('site.auth.layout')

@section('title')
    {{ __("Buyer Registration") }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/gh/priyashpatil/phone-input-by-country@0.0.1/cpi.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
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

<!-- Modern Buyer Registration Form -->
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="flex justify-center mx-auto mb-4">
                @php
                $logo = App\Models\Preference::getLogo('company_logo');
                @endphp
                <img class="w-auto h-12 sm:h-16" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}" >
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __("Buyer Registration") }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
                {{ __("Create your buyer account to start purchasing") }}
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            {{ __("Please correct the following errors:") }}
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
        <form method="POST" action="{{ route('buyer.register') }}" class="bg-white shadow-xl rounded-2xl p-8">
            @csrf

            <!-- Personal Information Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __("Personal Information") }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Field -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Full Name') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               value="{{ old('name') }}" 
                               placeholder="{{ __('Enter your full name') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Email Address') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               value="{{ old('email') }}" 
                               placeholder="{{ __('Enter your email address') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Phone Number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               value="{{ old('phone') }}" 
                               placeholder="{{ __('Enter your phone number') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               placeholder="{{ __('Enter your password') }}">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               placeholder="{{ __('Confirm your password') }}">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Business Information Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ __("Business Information") }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <!-- Commercial Registration Number -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Commercial Registration Number') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="commercial_registration_number" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:border-transparent transition duration-200 dark:bg-gray-700 dark:text-white"
                               style="--tw-ring-color: var(--primary-color);"
                               value="{{ old('commercial_registration_number') }}" 
                               placeholder="{{ __('Enter commercial registration number') }}">
                        @error('commercial_registration_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mb-8">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                            {{ __('I agree to the') }} 
                            <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400" style="color: var(--primary-color);">
                                {{ __('Terms and Conditions') }}
                            </a> 
                            {{ __('and') }} 
                            <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400" style="color: var(--primary-color);">
                                {{ __('Privacy Policy') }}
                            </a>
                        </label>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                        id="submitBtn"
                        class="flex-1 px-8 py-4 text-lg font-medium text-white rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        style="background-color: var(--primary-color); hover:background-color: color-mix(in srgb, var(--primary-color) 80%, black); focus:ring-color: var(--primary-color);">
                    
                    <!-- Loading Spinner (hidden by default) -->
                    <svg id="loadingSpinner" class="w-5 h-5 mr-2 inline animate-spin hidden" style="display: none !important;" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <!-- Default Icon (shown by default) -->
                    <svg id="defaultIcon" class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    
                    <span id="buttonText">{{ __('Create Buyer Account') }}</span>
                </button>
                
                <a href="{{ route('login') }}" 
                   class="flex-1 px-8 py-4 text-lg font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-600 text-center">
                    {{ __('Already have an account? Login') }}
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    // Password strength validation and form submission loading
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.querySelector('input[name="password"]');
        const confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const defaultIcon = document.getElementById('defaultIcon');
        const buttonText = document.getElementById('buttonText');
        
        // Password confirmation validation
        if (passwordInput && confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.setCustomValidity('{{ __("Passwords do not match") }}');
                } else {
                    this.setCustomValidity('');
                }
            });
        }
        
        // Form submission loading state
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                // Disable the submit button
                submitBtn.disabled = true;
                
                // Show loading spinner and hide default icon
                loadingSpinner.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
                
                // Change button text
                buttonText.textContent = '{{ __("Creating Account...") }}';
                
                // Add loading class for additional styling
                submitBtn.classList.add('loading');
            });
        }
    });
</script>
@endsection
