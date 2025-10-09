@extends('admin.layouts.app')
@section('page_title', __('View Plan'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/Subscription/Resources/assets/css/subscription.min.css') }}">
@endsection
@section('content')

<!-- Main content -->
<div class="col-sm-12 list-container" id="package-show-container">
    <div class="card">
        <div class="card-header">
            <h5> <a href="{{ route('package.index') }}">{{ __('Plan') }} >> </a>{{ __('View Plan') }} </h5>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card min-h-100">
        <div class="card-body position-relative">
            <section class="pricing-section">
                <div class="container">
                    <div class="outer-box">
                        <div class="row">
                            <!-- Pricing Block -->
                            <div class="pricing-block col-lg-4 col-md-6 col-sm-12  offset-lg-4 offset-md-3 wow fadeInUp" data-wow-delay="800ms">
                                <div class="inner-box">
                                    <div class="price-box">
                                        <div class="title">{{ $package->name }}</div>
                                        <div>
                                            <h4 class="mt-2 text-secondary">
                                                @empty($package->discount_price)
                                                    {{ $package->sale_price == 0 ? __('Free') : formatNumber($package->sale_price) }}
                                                @else
                                                    {{ $package->discount_price == 0 ? __('Free') : formatNumber($package->discount_price) }}
                                                @endempty
                                                /
                                                <span class="d-inline">
                                                    @if ($package->billing_cycle == 'days')
                                                        {{ $package->duration . ' ' . ucfirst($package->billing_cycle) }}
                                                    @else
                                                        {{ ucfirst($package->billing_cycle) }}
                                                    @endif
                                                </span>
                                            </h4>
                                        </div>

                                    </div>
                                    <div class="features text-center text-dark mt-2">
                                        @foreach($features as $key => $meta)
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

                                    <div class="btn-box">
                                        <button type="button" class="btn btn-outline-primary">{{ __('Subscribe Now') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection


