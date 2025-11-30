@extends('vendor.layouts.app')
@section('page_title', __('View Plan'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.css?v=1.3') }}">
@endsection
@section('content')
@if (isset($product) && $product > 0 && (($meta['value'] != -1 && ($meta['value'] - $meta['usage'] < 0)) || subscription('isExpired', $subscription->user_id) || $subscription->status == 'Cancel'))
    <div id="notifications" class="row no-print">
        <div class="col-md-12">
            <div class="top-notification noti-alert pad no-print js-alert">
                <div class="alert alert-danger">
                    <strong class="alertText">
                        @if ($meta['value'] - $meta['usage'] < 0)
                            {{ __('You have exceeded the product quantity limit. Please consider upgrading your package or removing the exceeded products. If not addressed by :x, your latest exceeded products will be removed.', ['x' => formatDate(date('Y-m-d', strtotime($subscription->next_billing_date . ' + ' . preference('subscription_remove_product_day', 7) . ' days')))]) }}
                        @elseif (subscription('isExpired', $subscription->user_id))
                            {{ __('Your subscription has expired. Please renew your subscription to continue accessing our services. If not addressed by :x, your latest exceeded products will be removed.', ['x' => formatDate(date('Y-m-d', strtotime($subscription->next_billing_date . ' + ' . preference('subscription_remove_product_day', 7) . ' days')))]) }}
                        @else
                            {{ __('Your subscription has canceled. Please renew your subscription to continue accessing our services. If not addressed by :x, your latest exceeded products will be removed.', ['x' => formatDate(date('Y-m-d', strtotime($subscription->next_billing_date . ' + ' . preference('subscription_remove_product_day', 7) . ' days')))]) }}
                        @endif
                    </strong>
                    <button type="button" class="btn-close {{ languageDirection() == 'ltr' ? 'float-right' : 'float-left' }} notification-close" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Main content -->

@php
    $isStaff = checkIfUserIsStaff();
@endphp
<div class="col-sm-12 list-container vendor-subscription-container" id="subscription-container">
    <div class="col-12">
        <div class="card">
            <div class="row gx-custom">
                @if (!is_null($subscription))

                    <div class="col-md-12">
                        <div class="bg-white p-4">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="border-b d-flex justify-content-between">
                                        <div class="d-flex pb-2 align-items-center mb-2">
                                            <h4 class="fw-bold text-dark mb-0">{{ $subscription?->package?->name ?? __('Unknown') }}</h4>
                                            <div>
                                                <span class="badge mt-1 {{ $subscription->status == 'Active' ? 'badge-success' : 'badge-danger' }} f-10 ms-2">{{ $subscription->status }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                @if (in_array('Modules\Subscription\Http\Controllers\Vendor\SubscriptionController@history', $prms))
                                                    <a href="{{ route('vendor.subscription.history') }}" class="d-inline-block mt-0 btn-light px-4 py-2 text-dark me-2 rounded mb-3">
                                                        {{ __('History') }}
                                                    </a>
                                                @endif

                                                @if (!$isStaff && $subscription && $subscription->status == 'Active')
                                                    <div class="cancel-btn float-right">
                                                        <a href="{{ route('vendor.subscription.cancel', ['user_id' => $subscription->user_id]) }}" class="btn">{{ __("Cancel") }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ __('Code') }}</span>
                                            <h4 class="mt-10p fw-bold">{{ $subscription->code }}</h4>
                                        </div>
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ __('Price') }}</span>
                                            <h4 class="mt-10p fw-bold">{{$subscription->billing_price == 0 ? __('Free') : formatNumber((float) $subscription->billing_price) }}</h4>
                                        </div>
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ __('Activation Date') }}</span>
                                            <h4 class="mt-10p fw-bold">{{ timezoneFormatDate($subscription->activation_date) }}</h4>
                                        </div>
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ __('Renewable') }}</span>
                                            <h4 class="mt-10p fw-bold">{{ $subscription->renewable ? __('Yes') : __('No') }}</h4>
                                        </div>
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ __('Payment Status') }}</span>
                                            <h4 class="mt-10p fw-bold">{{ $subscription->billing_price == 0 ? __('Not Applicable') : $subscription->payment_status }}</h4>
                                        </div>
                                        <div class="col-md-4 mt-20p">
                                            <span class="text-dark">{{ $subscription->renewable ? __('Next Billing Date') : __('Expiration Date') }}</span>
                                            <h4 class="mt-10p fw-bold">
                                                @if ($subscription->billing_cycle == 'lifetime' && !subscription('isTrialMode', $subscription->id))
                                                    {{ __('Not Applicable') }}
                                                @else
                                                    {{ timezoneFormatDate($subscription->next_billing_date) }}
                                                @endif
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="border-b mb-20p mt-20p"></div>
                                        </div>
                                    </div>

                                    <div class="row gy-3">
                                        @foreach ($subscriptionFeatures as $key => $feature)
                                            @if (is_int($feature['limit']))
                                                <div class="col-md-6 mb-2">
                                                    <div class="font-16 text-dark fw-bold mb-3">
                                                        <i class="feather icon-layers f-16 text-secondary"></i>
                                                        <span class="ms-1">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                                        <span class="float-end">{{ $feature['used'] . '/'. ($feature['limit'] == -1 ? __('Unlimited') : $feature['limit'] + $feature['used']) }}</span>
                                                    </div>
                                                    <div class="progress ml-25p h-8p border-radius-5p">
                                                        <div class="progress-bar border-radius-5p" style="width: {{  ($feature['limit'] + $feature['used']) == 0 ? 0 : ($feature['used'] / ($feature['limit'] + $feature['used'])) * 100 }}%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="p-3 ms-4">
                                        <h6 class="fw-bold mb-3 mt-10p">{{ __('Services') }}</h6>
                                        <div class="my-4">
                                            <div class="max-h-400 overflow-auto pe-2">
                                                <div class="checklist">
                                                    @foreach ($subscriptionFeatures as $key => $feature)
                                                        @if (!is_int($feature['limit']))
                                                            <div class="{{ $feature['limit'] == 0 ? 'checklist-item-disable' : 'checklist-item-enable' }}">{{ ucwords(str_replace('_', ' ', $key)) }} {{ is_array(json_decode($feature['limit'])) ? ': ' . implode(', ', json_decode($feature['limit'])) : __('Service') }}</div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-body py-4">
                        <strong class="text-warning">{{ __('Please Subscribe a package first.') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card min-h-100">
            <div class="card-body position-relative">
                <section class="pricing-section">
                    <div class="container">
                        <div class="outer-box">
                            <div class="containers">
                                <div class="selector">
                                    @php
                                        $hasMonthlyBilling = array_key_exists('monthly', $billingCycles);
                                        $activeBillingCycle = '';
                                    @endphp
                                    @foreach ($billingCycles as $key => $billingCycle)
                                        @php
                                            if (($hasMonthlyBilling && $key == 'monthly') || (!$hasMonthlyBilling && $loop->first)) {
                                                $activeBillingCycle = $key;
                                            }
                                        @endphp
                                        <div class="selector-item">
                                            <input type="radio" id="{{ $key }}" value="{{ $key }}" name="check_billing" class="selector-item_radio" 
                                                {{ $activeBillingCycle == $key ? 'checked' : '' }}/>
                                            <label for="{{ $key }}" class="selector-item_label cursor-pointer">{{ $billingCycle }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row plan-root">
                                <!-- Pricing Block -->
                                @foreach ($packages as $package)
                                    @foreach ($package['billing_cycle'] as $billing_cycle => $value)
                                        @continue($value == 0)
                                        <div class="plan-parent plan-{{ $billing_cycle }} pricing-block col-lg-6 col-md-6 col-sm-12 wow fadeInUp {{ $billing_cycle == $activeBillingCycle ? '' : 'd-none' }}" data-wow-delay="800ms">
                                            <div class="inner-box">
                                                <div class="price-box">
                                                    <div class="title wb-all"><h2>{{ $package->name }}</h2></div>
                                                    <div>
                                                        @php
                                                            $original = $package->sale_price[$billing_cycle] ?? 0;
                                                            $discount = $package->discount_price[$billing_cycle] ?? null;

                                                            // Pick the correct displayed price
                                                            $price = $discount && $discount > 0 ? $discount : $original;
                                                        @endphp

                                                        <h4 class="text-secondary charge-text">

                                                             {{-- Show old/original price only if discount exists --}}
                                                            @if ($discount && $discount < $original)
                                                                <p>
                                                                    <span class="text-muted text-decoration-line-through ms-2">
                                                                    {{ formatNumber((float) $original) }}
                                                                </span>
                                                                </p>
                                                            @endif

                                                            {{-- Current price --}}
                                                            {{ formatNumber((float) $price) }}

                                                           

                                                            <span class="d-inline t-duration">
                                                                /
                                                                @if ($billing_cycle == 'days')
                                                                    {{ $package->duration . ' ' . __('Days') }}
                                                                @else
                                                                    {{ ucfirst($billing_cycle) }}
                                                                @endif
                                                            </span>

                                                        </h4>

                                                    </div>
                                                </div>

                                                <div class="features text-center text-dark">
                                                    <div class="d-flex justify-content-center flex-column align-items-center wb-all">
                                                        <p class="mb-1 plan-text">{{ __("PLAN Includes") }}</p>
                                                        <div class="underlines"></div>
                                                    </div>
                                                    @foreach($features[$package->id] as $key => $meta)
                                                        @if ($meta->is_visible)
                                                            <div class="d-flex justify-content-center">
                                                                <div class="d-flex gap-2 align-items-baseline w-75">
                                                                    @if ($meta->type == 'bool' && !$meta->value)
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="11" viewBox="0 0 15 11" fill="none">
                                                                            <path d="M13.88 10.8298C14.2755 10.4343 14.2755 9.79202 13.88 9.39651L9.39651 4.91303L13.88 0.429548C14.2755 0.0340385 14.2755 -0.608278 13.88 -1.00379C13.4845 -1.3993 12.8422 -1.3993 12.4467 -1.00379L7.96323 3.47968L3.47974 -1.00379C3.08423 -1.3993 2.44192 -1.3993 2.04641 -1.00379C1.65091 -0.608278 1.65091 0.0340385 2.04641 0.429548L6.52989 4.91303L2.04641 9.39651C1.65091 9.79202 1.65091 10.4343 2.04641 10.8298C2.44192 11.2253 3.08423 11.2253 3.47974 10.8298L7.96323 6.34631L12.4467 10.8298C12.8422 11.2253 13.4845 11.2253 13.88 10.8298Z" fill="currentColor"></path>
                                                                        </svg>
                                                                    @else
                                                                        <svg class="min-w-15p" xmlns="http://www.w3.org/2000/svg" width="15" height="11" viewBox="0 0 15 11" fill="none">
                                                                            <path d="M13.88 1.17017C14.2755 1.56567 14.2755 2.20798 13.88 2.60349L5.77995 10.7035C5.38444 11.099 4.74214 11.099 4.34663 10.7035L0.296631 6.65349C-0.0988769 6.25798 -0.0988769 5.61567 0.296631 5.22017C0.692139 4.82466 1.33444 4.82466 1.72995 5.22017L5.06487 8.55192L12.4498 1.17017C12.8453 0.774658 13.4876 0.774658 13.8831 1.17017H13.88Z" fill="currentColor"></path>
                                                                        </svg>
                                                                    @endif                                                                                                                                 
                                                                    <p class="text-start wb-all">
                                                                        @switch($meta->type)
                                                                            @case('select')
                                                                                {{ trans($meta->title). ': ' . $meta->value }}
                                                                                @break
                                                                            @case('multi-select')
                                                                                {{ trans($meta->title). ': ' . implode(', ', array_unique(json_decode($meta->value, true))) }}
                                                                                @break
                                                                            @case('bool')
                                                                                @lang($meta->title)
                                                                                @break
                                                                            @case('text')
                                                                                @lang($meta->title)
                                                                                @break
                                                                            @case('number')
                                                                                @if ($meta->title_position == 'before')
                                                                                    {{ trans($meta->title). ': ' }} {{ ($meta->value == -1) ? __('Unlimited') : $meta->value }}
                                                                                @else
                                                                                    {{ ($meta->value == -1 ? __('Unlimited') : $meta->value) }} {{ trans($meta->title)}}
                                                                                @endif
                                                                                @break
                                                                            @default
                                                                        @endswitch
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @php
                                                    // Extract current and target package prices for the respective billing cycles
                                                    $currentPrice = $subscription?->package?->sale_price[$subscription?->billing_cycle] ?? 0;
                                                    $targetPrice = $package['sale_price'][$billing_cycle] ?? 0;
                                                    
                                                    // Determine plan change type
                                                    $isUpgrade = $currentPrice < $targetPrice;
                                                    $isDowngrade = $currentPrice >= $targetPrice;
                                                    
                                                    // Check if plan changes are allowed
                                                    $canChangePlan = preference('subscription_change_plan');
                                                    // $canDowngrade = $canChangePlan && preference('subscription_downgrade');
                                                    $canDowngrade = $canChangePlan && preference('subscription_downgrade');
                                                    
                                                    // Check if user has active subscription and current plan details
                                                    $hasSubscription = !empty($subscription?->package?->id);
                                                    $isCurrentPlan = $hasSubscription && 
                                                                    $subscription->package->id === $package['id'] && 
                                                                    $subscription->billing_cycle === $billing_cycle;
                                                    
                                                    // Trial eligibility check
                                                    $hasTrialAvailable = $package->trial_day && 
                                                                        !subscription('isUsedTrial', $package->id);
                                                    
                                                    $canUseTrial = $hasTrialAvailable && (
                                                        !$hasSubscription || 
                                                        ($canChangePlan && $isUpgrade) || 
                                                        ($canDowngrade && $isDowngrade)
                                                    );
                                                @endphp

                                                @if (!$isStaff)
                                                    <form action="{{ route('vendor.subscription.store') }}" method="POST" id="subscriptionForm{{ $package->id }}" >
                                                        @csrf
                                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                        <input type="hidden" name="billing_cycle" value="{{ $billing_cycle }}">
                                                        
                                                        <div class="btn-box price-btn">
                                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                            
                                                            @if ($canUseTrial)
                                                                {{-- Show trial button when trial is available and conditions are met --}}
                                                                @if (Auth::user()->doseNotHaveActiveCard())
                                                                    <button data-bs-toggle="modal" data-bs-target="#paymentModal{{ $package->id }}" type="button" class="btn btn-outline-primary" aria-label="{{ __('Start :x days trial', ['x' => $package->trial_period]) }}">
                                                                        {{ $package->getTrialPeriod() }}
                                                                    </button>
                                                                @else
                                                                    <button type="submit" class="btn btn-outline-primary" aria-label="{{ __('Subscribe to this plan') }}">
                                                                        {{ __('Subscribe Now') }}
                                                                    </button>
                                                                @endif
                                                                
                                                            @elseif (!$hasSubscription)
                                                                {{-- New subscription --}}
                                                                <button type="submit" class="btn btn-outline-primary" aria-label="{{ __('Subscribe to this plan') }}">
                                                                    {{ __('Subscribe Now') }}
                                                                </button>
                                                                
                                                            @elseif ($isCurrentPlan)
                                                                {{-- Current active plan - show renew if renewable --}}
                                                                @if (subscription('isExpired', $subscription->user_id) && $subscription->package->renewable)
                                                                    <button type="submit" class="btn btn-outline-primary" aria-label="{{ __('Renew current plan') }}">
                                                                        {{ __('Renew Plan') }}
                                                                    </button>
                                                                @else
                                                                   <button type="button" class="btn btn-success pe-none" aria-label="{{ __('Current Plan') }}">
                                                                        <i class="feather icon-check me-1"></i>{{ __('Current Plan') }}
                                                                   </button>
                                                                @endif
                                                                
                                                            @elseif ($canChangePlan && $isUpgrade)
                                                                {{-- Upgrade to higher-tier plan --}}
                                                                <button type="submit" class="btn btn-outline-primary" aria-label="{{ __('Upgrade to this plan') }}">
                                                                    {{ __('Upgrade Plan') }}
                                                                </button>
                                                                
                                                            @elseif ($canDowngrade && $isDowngrade)
                                                                {{-- Downgrade to lower-tier plan --}}
                                                                <button type="submit" class="btn btn-outline-primary" aria-label="{{ __('Downgrade to this plan') }}">
                                                                    {{ __('Downgrade Plan') }}
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </form>

                                                    @if ($canUseTrial)
                                                        <!-- Modal -->
                                                        <div class="modal fade " id="paymentModal{{ $package->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        {{ __('Add Payment Card') }}
                                                                    </h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @include('subscription::vendor.add-card')
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    @endif

                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>

    <script>
        const form = document.querySelector('.payment-form');
        const holderNameInput = document.querySelector('input[name="holder_name"]');
        const cardNumberInput = document.querySelector('input[name="card_number"]');
        const expiryDateInput = document.querySelector('input[name="expiry_date"]');
        const cvvInput = document.querySelector('input[name="cvv"]');
        const nameError = document.querySelector('.name-error');
        const cardError = document.querySelector('.card-error');
        const expiryError = document.querySelector('.expiry-error');
        const cvvError = document.querySelector('.cvv-error');

        // name
        holderNameInput.addEventListener('input', function(e) {
            validateHolderName();
        });

        // Format card number with spaces
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            value = value.replace(/\D/g, '');
            
            let formattedValue = value.match(/.{1,4}/g);
            e.target.value = formattedValue ? formattedValue.join(' ') : value;
            
            validateCardNumber();
        });

        // Format expiry date
        expiryDateInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            
            e.target.value = value;
            validateExpiryDate();
        });

        // CVV validation - numbers only
        cvvInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
            validateCVV();
        });

          // Validation functions
        function validateHolderName() {
            const value = holderNameInput.value;

            if (value.length === 0) {
                showError(holderNameInput, nameError, 'Holder name is required');
                return false;
            }
            
            // Check if value has at least two names (first name and last name)
            const names = value.split(/\s+/); // Split by one or more spaces
            if (names.length < 2) {
                showError(holderNameInput, nameError, 'Please enter both first and last name');
                return false;
            }
            
            // Optional: Check if each name has at least 2 characters
            if (names.some(name => name.length < 2)) {
                showError(holderNameInput, nameError, 'Each name must be at least 2 characters');
                return false;
            }
            
            showSuccess(holderNameInput, nameError); // Fixed: should be holderNameInput and nameError
            return true;
        }

        // Validation functions
        function validateCardNumber() {
            const value = cardNumberInput.value.replace(/\s/g, '');
            
            if (value.length === 0) {
                showError(cardNumberInput, cardError, 'Card number is required');
                return false;
            }
            
            if (value.length < 13 || value.length > 19) {
                showError(cardNumberInput, cardError, 'Card number must be between 13-19 digits');
                return false;
            }
            
            if (!luhnCheck(value)) {
                showError(cardNumberInput, cardError, 'Invalid card number');
                return false;
            }
            
            showSuccess(cardNumberInput, cardError);
            return true;
        }

        function validateExpiryDate() {
            const value = expiryDateInput.value;
            
            if (value.length === 0) {
                showError(expiryDateInput, expiryError, 'Expiry date is required');
                return false;
            }
            
            if (value.length !== 5) {
                showError(expiryDateInput, expiryError, 'Expiry date must be MM/YY format');
                return false;
            }
            
            const parts = value.split('/');
            const month = parseInt(parts[0]);
            const year = parseInt('20' + parts[1]);
            
            if (month < 1 || month > 12) {
                showError(expiryDateInput, expiryError, 'Invalid month');
                return false;
            }
            
            const now = new Date();
            const currentYear = now.getFullYear();
            const currentMonth = now.getMonth() + 1;
            
            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                showError(expiryDateInput, expiryError, 'Card has expired');
                return false;
            }
            
            showSuccess(expiryDateInput, expiryError);
            return true;
        }

        function validateCVV() {
            const value = cvvInput.value;
            
            if (value.length === 0) {
                showError(cvvInput, cvvError, 'CVV is required');
                return false;
            }
            
            if (value.length < 3 || value.length > 4) {
                showError(cvvInput, cvvError, 'CVV must be 3-4 digits');
                return false;
            }
            
            showSuccess(cvvInput, cvvError);
            return true;
        }

        // Luhn algorithm for card validation
        function luhnCheck(cardNumber) {
            let sum = 0;
            let isEven = false;
            
            for (let i = cardNumber.length - 1; i >= 0; i--) {
                let digit = parseInt(cardNumber[i]);
                
                if (isEven) {
                    digit *= 2;
                    if (digit > 9) {
                        digit -= 9;
                    }
                }
                
                sum += digit;
                isEven = !isEven;
            }
            
            return sum % 10 === 0;
        }

        function showError(input, errorElement, message) {
            input.classList.remove('success');
            input.classList.add('error');
            errorElement.textContent = message;
            errorElement.classList.add('show text-danger');
        }

        function showSuccess(input, errorElement) {
            input.classList.remove('error');
            input.classList.add('success');
            errorElement.textContent = '';
            errorElement.classList.remove('show');
        }

        submitBtn = form.querySelector('button[type="submit"]');


        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

   
            var parentFormID = formData.get("parent_form_id");

            
            const isHolderNameValid = validateHolderName();
            const isCardValid = validateCardNumber();
            const isExpiryValid = validateExpiryDate();
            const isCVVValid = validateCVV();
            
            if (isCardValid && isHolderNameValid && isExpiryValid && isCVVValid) {
                addCard(parentFormID);
                // Here you would normally send the data to your server
            } else {
                alert('Please fix the errors in the form');
            }
        });

        // Validate on blur
        cardNumberInput.addEventListener('blur', validateCardNumber);
        expiryDateInput.addEventListener('blur', validateExpiryDate);
        cvvInput.addEventListener('blur', validateCVV);
        holderNameInput.addEventListener('blur', validateHolderName);


        function addCard(parentFormID) {
            $.ajax({
                url: '{{ route("vendor.subscription.add-card") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    holder_name: holderNameInput.value,
                    card_number:  cardNumberInput.value.replace(/\s/g, ''),
                    expiry_date: expiryDateInput.value,
                    cvv: cvvInput.value,
                },
                success: function(response) {
                    $("#" + parentFormID).submit();
                },
                error: function(response) {
                    alert('Failed to add card!');
                }
            });
        }
    </script>
@endsection


