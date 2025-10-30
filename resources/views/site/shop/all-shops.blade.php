@extends('site.layouts.app')

@section('page_title', __('All Shops'))

{{-- @section('seo')
    @include('site.shop.seo', ['page' => null])
@endsection --}}

@section('css')
<style>
    .shops-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, rgba(252, 202, 25, 0.8) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .shops-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .shop-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(229, 231, 235, 0.8);
        overflow: hidden;
        position: relative;
    }
    
    .shop-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), rgba(252, 202, 25, 0.6));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .shop-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: var(--primary-color);
    }
    
    .shop-card:hover::before {
        transform: scaleX(1);
    }
    
    .shop-logo {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        object-fit: cover;
        border: 3px solid rgba(252, 202, 25, 0.1);
        transition: all 0.3s ease;
    }
    
    .shop-card:hover .shop-logo {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }
    
    .rating-stars {
        color: #fbbf24;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
    }
    
    .empty-state {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
    }
    
    .breadcrumb-modern {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 12px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .page-title {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }
    
    .stats-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    @media (max-width: 768px) {
        .shop-card {
            margin-bottom: 1rem;
        }
        
        .shops-hero {
            padding: 2rem 1rem;
        }
    }
    
    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endsection

@section('content')


    <section class="layout-wrapper px-4 xl:px-0 py-8">
        <!-- Modern Breadcrumb -->
        <div class="mb-8">
            <nav class="breadcrumb-modern inline-block" aria-label="Breadcrumb">
                <ol class="list-none p-0 flex flex-wrap md:inline-flex text-sm font-medium text-gray-700">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <a href="{{ route('site.index') }}" class="hover:text-gray-900 transition-colors">{{ __('Home') }}</a>
                        <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </li>
                    <li class="text-gray-900 font-semibold">
                        {{ __('Factories') }}
                    </li>
                </ol>
            </nav>
        </div>

        @php
            $vendors = \App\Models\Vendor::with(['shop', 'reviews'])
                ->where('status', 'Active')
                ->whereHas('shop')
                ->paginate(24);
                
            // Calculate stats for the hero section
            $totalShops = $vendors->total();
            $totalProducts = \App\Models\Product::where('status', 'Active')->count();
            $avgRating = \App\Models\Review::avg('rating') ?? 0;
        @endphp

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h2 class="page-title text-3xl md:text-4xl mb-4">{{ __('Our Partner Factories') }}</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">{{ __('Explore a curated network of verified and trusted factories') }}</p>
        </div>

        <!-- Shops Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
            @forelse ($vendors as $vendor)
                @php
                    $shop = $vendor->shop;
                    $logoUrl = optional($vendor->logo)->fileUrl() ?? $vendor->fileUrl();
                    // $logoUrl = $vendor->fileUrl();
                    $review = $vendor->shopReview();
                @endphp
                <div class="shop-card group">
                    <a href="{{ $shop ? route('site.shop', ['alias' => $shop->alias]) : 'javascript:void(0)' }}" class="block p-6">
                        <div class="flex flex-col items-center text-center">
                            <!-- Logo -->
                            <div class="mb-4 relative">
                                <img class="shop-logo mx-auto" 
                                     src="{{ $logoUrl ?: asset('public/frontend/img/seller.png') }}" 
                                     alt="{{ $vendor->name }}"
                                     onerror="this.src='{{ asset('public/frontend/img/seller.png') }}'">
                               
                            </div>
                            
                            <!-- Shop Name -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-gray-700 transition-colors">
                                <li class="flex items-center">
                                    @if($vendor->status === 'Active')
                                    <div
                                     class="absolute top-2 right-2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                                   
                                    {{ $vendor->name }}
                                   
                                </li>
                            </h3>
                            
                            <!-- Rating -->
                            @if ($review && $review->count)
                                <div class="flex items-center justify-center mb-3">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 rating-stars {{ $i <= floor($review->rating) ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600 font-medium">
                                        {{ number_format($review->rating, 1) }} ({{ $review->count }})
                                    </span>
                                </div>
                            @else
                                <div class="flex items-center justify-center mb-3">
                                    <span class="text-sm text-gray-400">{{ __('No reviews yet') }}</span>
                                </div>
                            @endif
                            
                            <!-- Shop Info -->
                            <div class="text-sm text-gray-500 mb-4">
                                @if($shop)
                                    <div class="flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $shop->name ?? __('Factory') }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Visit Button -->
                            <div class="w-full">
                                <span class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-700 transition-colors group-hover:bg-gray-700">
                                    {{ __('Visit Factory') }}
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Enhanced Empty State -->
                <div class="col-span-full">
                    <div class="empty-state p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('No Factories Found') }}</h3>
                            <p class="text-gray-500 mb-6">{{ __('We are working on adding more factories to our platform. Check back soon!') }}</p>
                            <a href="{{ route('site.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Back to Home') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Enhanced Pagination -->
        @if($vendors->hasPages())
            <div class="flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    {{ $vendors->links() }}
                </div>
            </div>
        @endif
    </section>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats counters
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        function updateCounter() {
            start += increment;
            if (start < target) {
                element.textContent = Math.floor(start);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target;
            }
        }
        
        updateCounter();
    }
    
    // Update stats with actual data
    const totalShopsElement = document.getElementById('total-shops');
    const totalProductsElement = document.getElementById('total-products');
    const avgRatingElement = document.getElementById('avg-rating');
    
    if (totalShopsElement) {
        animateCounter(totalShopsElement, {{ $totalShops }});
    }
    
    if (totalProductsElement) {
        animateCounter(totalProductsElement, {{ $totalProducts }});
    }
    
    if (avgRatingElement) {
        // Animate rating with one decimal place
        let start = 0;
        const target = {{ number_format($avgRating, 1) }};
        const increment = target / (2000 / 16);
        
        function updateRating() {
            start += increment;
            if (start < target) {
                avgRatingElement.textContent = start.toFixed(1);
                requestAnimationFrame(updateRating);
            } else {
                avgRatingElement.textContent = target.toFixed(1);
            }
        }
        
        updateRating();
    }
    
    // Add loading animation to shop cards
    const shopCards = document.querySelectorAll('.shop-card');
    shopCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Add intersection observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all shop cards
    shopCards.forEach(card => {
        observer.observe(card);
    });
});

// Add CSS for fade-in animation
const style = document.createElement('style');
style.textContent = `
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection


