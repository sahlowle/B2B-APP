@extends('site.auth.layout')

@section('title')
    {{ __("Login") }}
@endsection

@section('content')

    <section class="">
        <div class="container flex items-center justify-center min-h-screen px-6 mx-auto">
            <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <div class="flex justify-center mx-auto">
                    @php
                        $logo = App\Models\Preference::getLogo('company_logo');
                    @endphp
                    <img class="w-auto h-7 sm:h-8" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}" >
                </div>
        
                <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">
                    {{ __("Welcome Back") }}
                </h3>
        
                <p class="mt-1 text-center text-gray-500 dark:text-gray-400">
                    {{ __("Choose your account type to get started") }}
                </p>
                
                <div class="flex items-center justify-center mt-6">
                    <a href="{{ route('login') }}" class="w-1/3 pb-4 font-medium text-center text-gray-500 capitalize border-b dark:border-gray-400 dark:text-gray-300">
                        {{ __("sign in") }}
                    </a>
    
                    <a href="#" class="w-1/3 pb-4 font-medium text-center text-gray-800 capitalize border-b-2" style="border-color: var(--primary-color);">
                        {{ __("sign up") }}
                    </a>
                </div>

                <div class="mt-8 space-y-4">
                    <!-- Buyer Button -->
                    <div onclick="window.location.href='{{ route('buyer/register') }}'" class="w-full p-4 bg-white border border-gray-200 rounded-lg cursor-pointer hover:shadow-md transition-shadow duration-200 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: var(--primary-color);">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div class="mx-4">
                                <h3 class="text-lg font-medium" style="color: var(--primary-color);">
                                    {{ __("Sign up as a buyer") }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("I plan to purchase the products") }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Vendor Button -->
                    <div onclick="window.location.href='{{ route('factory/register') }}'" class="w-full p-4 bg-white border border-gray-200 rounded-lg cursor-pointer hover:shadow-md transition-shadow duration-200 dark:bg-gray-700 dark:border-gray-600">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: var(--primary-color);">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="mx-4">
                                <h3 class="text-lg font-medium" style="color: var(--primary-color);">
                                    {{ __("Sign up as a Factory") }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("I plan to sell products") }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm hover:underline" style="color: var(--primary-color);">
                        {{ __("Already have an account?") }}
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

