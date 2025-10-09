@extends('vendor.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.min.css') }}">
@endsection

@section('content')
    <div class="col-sm-12 list-container" id="private-plan-container">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Private Plan') }}</h5>
            </div>
        </div>
        @if($status == 'fail')
        <div class="col-12">
            <div class="card min-h-25">
                <div class="card-body position-relative">
                    <section class="pricing-section">
                        <div class="d-flex justify-content-center">
                            <div class="outer-box mt-4">
                                <h2 class="text-warning">{{ __('Link Expire') }}</h2>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @else
        <div class="col-12">
            <div class="card min-h-100">
                <div class="card-body position-relative">
                    <section class="pricing-section">
                        <div class="container">
                            <div class="outer-box">
                                <div class="row plan-root">
                                    @foreach ($package['billing_cycle'] as $billing_cycle => $value)
                                        @continue($value == 0)
                                        <div class="plan-parent plan-{{ $billing_cycle }} pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
                                            <div class="inner-box">
                                                <div class="price-box">
                                                    <div class="title">{{ $package->name }}</div>
                                                    <div>
                                                        <h4 class="mt-2 text-secondary">
                                                            @empty($package->discount_price[$billing_cycle])
                                                                {{ $package->sale_price[$billing_cycle] == 0 ? __('Free') : formatNumber($package->sale_price[$billing_cycle]) }}
                                                            @else
                                                                {{ $package->discount_price[$billing_cycle] == 0 ? __('Free') : formatNumber($package->discount_price[$billing_cycle]) }}
                                                            @endempty
                                                            /
                                                            <span class="d-inline">
                                                                @if ($billing_cycle == 'days')
                                                                    {{ $package->duration . ' ' . __('Days') }}
                                                                @else
                                                                    {{ ucfirst($billing_cycle) }}
                                                                @endif
                                                            </span>
                                                        </h4>
                                                    </div>

                                                </div>
                                                <div class="features text-center text-dark mt-2">
                                                    @foreach($package['features'] as $key => $meta)
                                                        @if ($meta->is_visible && $meta->status == 'Active')
                                                            <p class="mt-4">
                                                                @if ($meta->type != 'number')
                                                                    {{ $meta->title }}
                                                                @elseif ($meta->title_position == 'before')
                                                                    {{ $meta->title . ': ' }} {{ ($meta->value == -1) ? __('Unlimited') : $meta->value }}
                                                                @else
                                                                    {{ ($meta->value == -1 ? __('Unlimited') : $meta->value) }} {{ $meta->title }}
                                                                @endif
                                                            </p>
                                                        @endif
                                                    @endforeach
                                                </div>

                                                <form action="{{ route('vendor.subscription.store') }}" method="POST">
                                                    @csrf
                                                    <div class="btn-box">
                                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                        <input type="hidden" name="billing_cycle" value="{{ $billing_cycle }}">
                                                        @if ($package->trial_day && !subscription('isUsedTrial', $package->id))
                                                            <button type="submit" class="btn btn-outline-primary">{{ __(':x Days Trial', ['x' => $package->trial_day]) }}</button>
                                                        @elseif (!$subscription?->package?->id)
                                                            <button type="submit" class="btn btn-outline-primary">{{ __('Subscribe Now') }}</button>
                                                        @elseif ($subscription?->package?->id == $package['id'] && $billing_cycle == $subscription?->billing_cycle)
                                                            @if ($subscription?->package?->renewable)
                                                                <button type="submit" class="btn btn-outline-primary">{{ __('Renew Plan') }}</button>
                                                            @endif
                                                        @elseif (preference('subscription_change_plan') && $subscription?->package?->sale_price[$subscription?->billing_cycle] < $package['sale_price'][$billing_cycle])
                                                            <button type="submit" class="btn btn-outline-primary">{{ __('Upgrade Plan') }}</button>
                                                        @elseif (preference('subscription_change_plan') && preference('subscription_downgrade') && $subscription?->package?->sale_price[$subscription?->billing_cycle] >= $package['sale_price'][$billing_cycle])
                                                            <button type="submit" class="btn btn-outline-primary">{{ __('Downgrade Plan') }}</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{ asset('Modules/Subscription/Resources/assets/js/subscription.min.js') }}"></script>
@endsection
