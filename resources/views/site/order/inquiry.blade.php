@extends('../site/layouts.app')
@section('page_title', __('Contact Sellers in Seconds'))
@section('css')
    <link rel="stylesheet" href="{{ asset('public/datta-able/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')

    <section class="text-gray-600 body-font relative layout-wrapper px-4 xl:px-0 mt-80p inquiry-form"
        id="inquiry-container">
        <form action="{{ route('site.inquiryStore') }}" method="POST" id="inquiryForm">
            @csrf
            <div class="flex md:flex-nowrap flex-wrap pt-8">
                <div class="md:w-2/3 overflow-hidden flex justify-start relative mb-10 rtl-direction-space-left-cart">
                    <div class="flex flex-wrap w-full ltr:lg:pr-7 rtl:lg:pl-7">
                        <!-- Product Information Section -->
                        <div class="w-full mb-6">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <div class="flex items-start space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <img src="{{ $product->photo ?? asset('public/dist/images/default-product.png') }}" 
                                             alt="{{ $product->name ?? 'Product' }}" 
                                             class="w-20 h-20 object-cover rounded border">
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <div class="mb-2">
                                            <label class="text-sm font-medium text-gray-600">{{ __('Product') }}</label>
                                            <h3 class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                                                <a href="#" class="hover:underline">{{ $product->name ?? 'Disposable PE Shoe Cover' }}</a>
                                            </h3>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ $product->name ?? '' }}
                                                <a href="{{ route('site.productDetails', $product->slug) }}" class="text-blue-600 hover:underline ml-1">{{ __('Detail >>') }}</a>
                                            </p>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <label class="text-sm font-medium text-gray-600">{{ __('Seller') }}</label>
                                            <p class="text-sm font-medium text-gray-900">{{ $seller->name ?? 'Suzhou Hengshuo Imp and Exp Co., Ltd.' }}</p>
                                        </div>
                                        
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Inquiry Form Section -->
                        <div class="w-full">
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <!-- Subject Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="subject">
                                        {{ __('Subject') }}
                                    </label>
                                    <div class="flex items-center">
                                        <input type="text" 
                                               id="subject" 
                                               name="subject" 
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="{{ __('Enter inquiry subject') }}"
                                               maxlength="255"
                                               required>
                                        <span class="ml-3 text-sm text-gray-500">255 / 255</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ __('Subject should be between 10 to 255 characters') }}</p>
                                </div>

                                <!-- Message Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="message">
                                        {{ __('Message') }}
                                    </label>
                                    <textarea id="message" 
                                              name="message" 
                                              rows="6"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                              placeholder="{{ __('Enter your inquiry message') }}"
                                              maxlength="3000"
                                              required></textarea>
                                    <div class="flex justify-between items-center mt-2">
                                        <a href="#" class="text-blue-600 hover:underline text-sm">+ {{ __('Ask More Information') }}</a>
                                        <span class="text-sm text-gray-500">{{ __('Characters Remaining: 3000 / 3000') }}</span>
                                    </div>
                                </div>

                   

                                <!-- Required Quantity Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2" for="required_quantity">
                                        {{ __('Required Quantity') }}
                                    </label>
                                    <input type="text" 
                                           id="required_quantity" 
                                           name="required_quantity" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="{{ __('Enter required quantity') }}">
                                </div>

                               

                                <!-- Submit Button -->
                                <div class="mb-6">
                                    <button type="submit"
                                            class="process-goto relative flex justify-center items-center text-center lg:px-4 md:px-2 px-4 py-4 text-sm md:text-base text-white w-full mt-5 rounded dm-bold font-bold primary-bg-hover hover:text-gray-12 bg-black">
                                        {{ __('Submit Inquiry') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- ship different address end --}}
                    </div>
                </div>
                <!-- How to Post Inquiries Section -->
                <div class="md:w-1/3 flex flex-col ltr:md:ml-auto rtl:md:mr-auto w-full mb-10">
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-blue-600 mb-4">{{ __('How to Post Inquiries') }}</h3>
                        
                        <div class="space-y-4 text-sm text-gray-700">
                            <p>{{ __('Introduce yourself and your company.') }}</p>
                            
                            <p>{{ __('Indicate your requirements. Provide as much information as possible to receive a detailed response. For example:') }}</p>
                            
                            <ul class="list-disc list-inside space-y-1 ml-4">
                                <li>{{ __('Quantity') }}</li>
                                <li>{{ __('Size') }}</li>
                                <li>{{ __('Best Price') }}</li>
                                <li>{{ __('Port') }}</li>
                            </ul>
                            
                            <p>{{ __('From optional details, select what would you additionally like to know from sellers.') }}</p>
                            
                            <p>{{ __('Mention the required quantity that will assist sellers to give you best competitive quotes.') }}</p>
                            
                            <p>{{ __('Ask for any other information you find appropriate.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection

@section('js')
    <script>
        "use strict";
        
        // Character counter for subject field
        document.addEventListener('DOMContentLoaded', function() {
            const subjectInput = document.getElementById('subject');
            const subjectCounter = subjectInput.nextElementSibling;
            
            if (subjectInput && subjectCounter) {
                subjectInput.addEventListener('input', function() {
                    const remaining = 255 - this.value.length;
                    subjectCounter.textContent = remaining + ' / 255';
                });
            }
            
            // Character counter for message field
            const messageInput = document.getElementById('message');
            const messageCounter = document.querySelector('.text-sm.text-gray-500:last-child');
            
            if (messageInput && messageCounter) {
                messageInput.addEventListener('input', function() {
                    const remaining = 3000 - this.value.length;
                    messageCounter.textContent = 'Characters Remaining: ' + remaining + ' / 3000';
                });
            }
            
            // Form validation
            const form = document.getElementById('inquiryForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const subject = document.getElementById('subject').value.trim();
                    const message = document.getElementById('message').value.trim();
                    
                    if (subject.length < 10) {
                        e.preventDefault();
                        alert('{{ __("Subject must be at least 10 characters long.") }}');
                        return false;
                    }
                    
                    if (message.length < 10) {
                        e.preventDefault();
                        alert('{{ __("Message must be at least 10 characters long.") }}');
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
