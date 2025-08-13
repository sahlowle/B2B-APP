@extends('admin.layouts.app2')
@section('page_title', __('Seller OTP'))
@section('content')
    <div class="auth-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4 col-xl-3">
                    <div class="card shadow border-0 rounded-3 overflow-hidden">
                        <!-- Header Section -->
                        <div class="card-header bg-primary text-white text-center py-4 border-0">
                            <div class="mb-3">
                                @php
                                    $logo = App\Models\Preference::getLogo('company_logo');
                                @endphp
                                <img class="img-fluid" style="max-height: 50px;" src="{{ $logo }}" alt="{{ trimWords(preference('company_name'), 17)}}">
                            </div>
                            <h4 class="mb-2 fw-bold text-white">{{ __("Verify Your Account") }}</h4>
                            <p class="mb-0 opacity-75 small">{{ __("Enter the verification code sent to your email") }}</p>
                        </div>

                        <!-- Form Section -->
                        <div class="card-body p-4">
                            <form action="{{ route('site.seller.otpVerify') }}" method="post">
                                @csrf
                                
                                <!-- Notifications -->
                                <div class="mb-3">
                                    @include('admin.auth.partial.notification')
                                </div>
                                
                                <!-- OTP Input -->
                                <div class="mb-4">
                                    <label for="login-email" class="form-label fw-semibold text-dark">
                                        {{ __('Verification Code') }}
                                    </label>
                                    <div class="position-relative">
                                        <input 
                                            id="login-email" 
                                            type="text" 
                                            class="form-control form-control-lg text-center fw-bold fs-4 border-2" 
                                            style="letter-spacing: 0.5em; font-family: 'Courier New', monospace;"
                                            name="token" 
                                            placeholder="0000"
                                            maxlength="4"
                                            autocomplete="one-time-code"
                                            inputmode="numeric"
                                            pattern="[0-9]*"
                                        >
                                        <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                            <i class="fas fa-shield-alt text-muted"></i>
                                        </div>
                                    </div>
                                    <div class="form-text text-muted small mt-2">
                                        {{ __('Enter the 4-digit code sent to your email') }}
                                    </div>
                                </div>
                                
                                <!-- Hidden Email Field -->
                                @if (isset($user) && !empty($user))
                                    <div class="d-none">
                                        <input id="email" type="hidden" name="email" value="{{ $user->email }}">
                                    </div>
                                @endif

                                <!-- Resend Code Section -->
                                <div class="text-center mb-4">
                                    <p class="text-muted small mb-2">{{ __("Didn't receive the code yet?") }}</p>
                                    <button type="button" class="btn btn-link text-decoration-none p-0 resend-verification-code-seller">
                                        {{ __('Resend Code') }}
                                    </button>
                                </div>
                        
                                <!-- Submit Button -->
                                <button class="btn btn-primary btn-lg w-100 mb-3 fw-semibold" type="submit">
                                    <span class="me-2 text-white">{{ __("Verify & Continue") }}</span>
                                    <div class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                            </form>

                            <!-- Back to Login Link -->
                            <div class="text-center">
                                <a href="{{ route('site.login') }}" class="text-decoration-none text-muted small">
                                    <i class="fas fa-arrow-left me-1"></i>{{ __('Back to Login') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <p class="text-muted small mb-0">
                            {{ __('Need help?') }} 
                            <a href="#" class="text-decoration-none">{{ __('Contact Support') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-wrapper {
            background-color: #F5F5F5;
            min-height: 100vh;
        }
        
        .card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #0b5ed7);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, #0b5ed7, #0a58ca);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }
        
        .btn-link:hover {
            color: #0d6efd !important;
        }
        
        /* Loading state for button */
        .btn.loading .spinner-border {
            display: inline-block !important;
        }
        
        .btn.loading span {
            opacity: 0.7;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .card-body {
                padding: 1.5rem !important;
            }
        }
    </style>

    <script>
        // Auto-focus on OTP input
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('login-email');
            if (otpInput) {
                otpInput.focus();
            }
            
            // Auto-format OTP input (only allow numbers, max 4 digits)
            otpInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) {
                    value = value.substring(0, 4);
                }
                e.target.value = value;
            });
            
            // Form submission with loading state
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection
