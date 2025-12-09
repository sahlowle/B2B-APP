@extends('site.auth.layout')

@section('title')
    {{ __("Login") }}
@endsection

@section('content')

    <section class="">
        <div class="container flex items-center justify-center min-h-screen px-6 mx-auto">
            <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-8">
                <form class="w-full" action="{{ route('login') }}" method="post" id="loginForm">
                    @csrf

                    <x-session-message />

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
                        {{ __("Enter your email and password to access your account") }}
                    </p>
                    
                    <div class="flex items-center justify-center mt-6">
                        <a href="#" class="w-1/3 pb-4 font-medium text-center text-gray-800 capitalize border-b-2"  style="border-color: var(--primary-color);">
                            {{ __("sign in") }}
                        </a>
        
                        <a href="{{ route('registration') }}" class="w-1/3 pb-4 font-medium text-center text-gray-800 capitalize border-b-2">
                            {{ __("sign up") }}
                        </a>
                    </div>
        
                    <div class="relative flex items-center mt-6">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
        
                        <input 
                            type="email" 
                            name="email"
                            class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-opacity-40" 
                            placeholder="{{ __("Email Address")}}" 
                            style="focus:border-color: var(--primary-color); focus:ring-color: var(--primary-color);"
                            required
                            />
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
        
                    <div class="relative flex items-center mt-4 password-wrapper">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
        
                        <input 
                            type="password" 
                            name="password"
                            class="block password-input w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring focus:ring-opacity-40" 
                            placeholder="{{ __("Password") }}" 
                            style="focus:border-color: var(--primary-color); focus:ring-color: var(--primary-color);"
                            required
                            />
                             <button 
                                type="button"
                                class="password-toggle absolute inset-y-0 px-3 flex items-center text-gray-500"
                                >
                                👁️
                            </button>
                    </div>
        
                    <div class="mt-6">
                        <button type="submit" id="loginBtn" class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform rounded-lg focus:outline-none focus:ring focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed" style="background-color: var(--primary-color); hover:background-color: var(--primary-color); focus:ring-color: var(--primary-color);">
                           <span id="loginText">{{ __("Login") }}</span>
                           <span id="loginSpinner" class="hidden">
                               <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                   <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                   <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                               </svg>
                               {{ __("Logging in...") }}
                           </span>
                        </button>
        
                        <div class="mt-6 text-center ">
                            <a href="#" class="text-sm hover:underline text-primary-color">
                               {{ __("Forgot Password?") }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const loginBtn = document.getElementById('loginBtn');
            const loginText = document.getElementById('loginText');
            const loginSpinner = document.getElementById('loginSpinner');
            
            // Disable the button and show loading state
            loginBtn.disabled = true;
            loginText.classList.add('hidden');
            loginSpinner.classList.remove('hidden');
        });
    </script>

@endsection

