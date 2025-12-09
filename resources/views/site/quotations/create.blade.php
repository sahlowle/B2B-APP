<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $seo['title'] }}</title>
    
    <x-google-seo-head />

   @section('page_title', 'Privacy Policy')

    <meta name="robots" content="index, follow">
    <meta name="title" content="{{ $seo['meta_title'] }}">
    <meta name="description" content="{{ $seo['meta_description'] }}" />
    <meta name="keywords" content="privacy policy, Exports Valley, data protection, privacy">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $seo['meta_title'] }}">
    <meta itemprop="description" content="{{ $seo['meta_description'] }}">
    <meta itemprop="image" content="{{ asset('images/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $seo['meta_title'] }}">
    <meta property="og:description" content="{{ $seo['meta_description'] }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $seo['meta_title'] }}">
    <meta property="twitter:description" content="{{ $seo['meta_description'] }}">
    <meta property="twitter:image" content="{{ asset('images/logo.png') }}">

    @php
    if (!isset($page->layout)) {
          $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
      }

      $layout = $page->layout;
      $primaryColor = option($layout . '_template_primary_color', '#FCCA19');
      
  @endphp
  
     {{-- Select2  --}}
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/erimicel/select2-tailwindcss-theme/dist/select2-tailwindcss-theme-plain.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.10.6/build/css/intlTelInput.css">
    <!-- Tailwind CSS CDN -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @if(app()->getLocale() === 'ar')    
    <style>
        @import url(https://fonts.googleapis.com/earlyaccess/droidarabickufi.css);
        body { font-family: 'Droid Arabic Kufi', sans-serif; }
    </style>

    @else
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @endif
    
    <!-- Custom CSS for enhanced styling -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);
        }
        
        .card-shadow {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .form-input:focus {
            border-color: <?php echo $primaryColor; ?>;
            box-shadow: 0 0 0 3px <?php echo adjustBrightness($primaryColor, 80); ?>;
            transform: translateY(-1px);
        }
        
        .form-select {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }
        
        .form-select:focus {
            border-color: <?php echo $primaryColor; ?>;
            box-shadow: 0 0 0 3px <?php echo adjustBrightness($primaryColor, 80); ?>;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px <?php echo adjustBrightness($primaryColor, 60); ?>;
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .file-upload {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .file-upload:hover {
            border-color: <?php echo $primaryColor; ?>;
            background: <?php echo adjustBrightness($primaryColor, 95); ?>;
        }
        
        .file-upload:focus-within {
            border-color: <?php echo $primaryColor; ?>;
            background: <?php echo adjustBrightness($primaryColor, 95); ?>;
            box-shadow: 0 0 0 3px <?php echo adjustBrightness($primaryColor, 80); ?>;
        }
        
        .section-header {
            background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .floating-label {
            position: relative;
        }
        
        .floating-label input:focus + label,
        .floating-label input:not(:placeholder-shown) + label {
            transform: translateY(-1.5rem) scale(0.85);
            color: <?php echo $primaryColor; ?>;
        }
        
        .floating-label label {
            position: absolute;
            left: 1rem;
            top: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 0.25rem;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .success-checkmark {
            display: none;
            color: #10b981;
            animation: checkmark 0.5s ease-in-out;
        }
        
        @keyframes checkmark {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }
        
        .input-icon {
            position: absolute;
            @if (languageDirection() == 'ltr')
            left: 1rem;
            @else
            right: 1rem;
            @endif
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            z-index: 10;
        }
        
        .input-with-icon {
            @if (languageDirection() == 'rtl')
            padding-right: 3rem;
            @else
            padding-left: 3rem;
            @endif
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .logo {
            max-height: 80px;
            max-width: 200px;
            object-fit: contain;
        }
        
        .language-switcher {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 8px 12px;
        }
        
        .language-switcher select {
            background: white;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 14px;
            color: #374151;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .language-switcher select:hover {
            border-color: #9ca3af;
        }
        
        .language-switcher select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .iti{
            width: 100%;
        }

        .iti__search {
            width: 100%;
            background-color: transparent;
            color: #334155; /* slate-700 */
            font-size: 0.875rem; /* text-sm */
            border: 1px solid #e5e7eb; /* slate-200 */
            border-radius: 0.375rem; /* rounded-md */
            padding: 1rem 1rem 1rem 7rem; /* py-4 px-4 pl-28 */
            transition: all 300ms ease; /* transition duration-300 ease */
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); /* shadow-sm */
        }

        .iti__search:hover {
            border-color: #cbd5e1; /* slate-300 */
        }

        .iti__search:focus {
            outline: none; /* focus:outline-none */
            border-color: #94a3b8; /* focus:border-slate-400 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06); /* focus:shadow */
        }

        .iti__search-input{
            width: 100%;
            background-color: transparent;
            color: #334155; /* slate-700 */
            font-size: 0.875rem; /* text-sm */
            border: 1px solid #e5e7eb; /* slate-200 */
            border-radius: 0.375rem; /* rounded-md */
            padding: 1rem 1rem 1rem 2rem; /* py-4 px-4 pl-28 */
            transition: all 300ms ease; /* transition duration-300 ease */
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); /* shadow-sm */
        }

        .iti__search-input::placeholder{
            color: #94a3b8; /* slate-400 */
        }

        .iti__search-input:hover{
            border-color: #cbd5e1; /* slate-300 */
        }

        .iti__search-input:focus{
            outline: none; /* focus:outline-none */
            border-color: #94a3b8; /* focus:border-slate-400 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06); /* focus:shadow */
        }
        
    </style>
    
    <?php
        // Helper function to adjust color brightness
        function adjustBrightness($hex, $steps) {
            $hex = str_replace('#', '', $hex);
            
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            
            $r = max(0, min(255, $r + $steps));
            $g = max(0, min(255, $g + $steps));
            $b = max(0, min(255, $b + $steps));
            
            return '#' . sprintf('%02x%02x%02x', $r, $g, $b);
        }
    ?>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen" dir="{{ languageDirection() }}" >
    <!-- Header Section -->
    <header class="py-8">
        <div class="container mx-auto px-6">
            <!-- Language Switcher -->
            <div class="flex justify-end mb-6">
                <div class="language-switcher">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">{{ __("Language") }}:</span>
                        <select id="languageSelect" onchange="window.location.href = this.value"   >
                            @foreach(config('app.available_locales', ['en' => 'English', 'ar' => 'العربية']) as $locale => $name)
                                <option value="{{ LaravelLocalization::getLocalizedURL($locale, null, [], true) }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Logo and Title -->
            <div class="text-center">
                <!-- Logo -->
                <div class="logo-container">
                    <img src="https://exportsvalley.com/public/uploads/20250809/dbe06c7860a0e3390969d8392dbcd898.webp" 
                         alt="Company Logo" 
                         class="logo">
                </div>
                <h1 class="text-4xl font-bold mb-2 text-gray-800">
                    {{ __("Create RFQs") }}
                </h1>
                <p class="text-xl text-gray-600">
                    {{ __("Fill out the form below to submit your quotation request") }}
                </p>
            </div>
        </div>
    </header>

    <!-- Main Form Section -->
    <main class="container mx-auto px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Form Card -->

            <div class="bg-white rounded-2xl card-shadow p-8 animate-fade-in">

                @if ($errors->any())
                <div class="alert alert-danger text-red-500">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="post" action="#" 
                    enctype="multipart/form-data" 
                    onsubmit="return formValidation()"
                    class="space-y-8">

                    @csrf
                    
                    <!-- Personal Information Section -->
                    <div class="animate-slide-up">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-2" style="background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold section-header">
                                {{ __("Personal Information") }}
                            </h2>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __("First Name") }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="input-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <input class="form-input input-with-icon w-full  py-3 rounded-lg text-gray-700 focus:outline-none" 
                                        type="text" 
                                        name="first_name" 
                                        maxlength="191" 
                                        required
                                        placeholder="{{ __('Enter Your :x', ['x' => __('First Name')]) }}">
                                </div>
                                <div class="error-message" id="first_name_error"></div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __("Last Name") }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="input-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <input class="form-input input-with-icon w-full py-3 rounded-lg text-gray-700 focus:outline-none" 
                                        type="text" 
                                        name="last_name" 
                                        maxlength="191" 
                                        required
                                        placeholder="{{ __('Enter Your :x', ['x' => __('Last Name')]) }}" >
                                </div>
                                <div class="error-message" id="last_name_error"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="animate-slide-up" style="animation-delay: 0.1s;">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-2" style="background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold section-header">
                                {{ __("Contact Information") }}
                            </h2>
                        </div>

                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __("Country") }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    
                                    <select class="form-select select2 input-with-icon w-full py-3 rounded-lg text-gray-700 focus:outline-none" 
                                        name="country" 
                                        required>
                                        <option value=""> {{ __("Enter Your :x", ['x' => __('Country')]) }} </option>

                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"> {{ $country->name}}</option>
                                        @endforeach
                                       
                                    </select>
                                </div>
                                <div class="error-message" id="country_error"></div>
                            </div>

                            <div class="form-group">

                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __("Phone Number") }} <span class="text-red-500">*</span>
                                </label>

                                <div class="relative" style="direction: {{ languageDirection() }};" >
                                    
                                   
                                    <input
                                    type="tel"
                                    class="w-full bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded-md px-4 pl-28 py-4 transition duration-300 ease focus:outline-none focus:border-slate-400 hover:border-slate-300 shadow-sm focus:shadow"
                                    maxlength="20" 
                                    required
                                    inputmode="tel"
                                    autocomplete="tel"
                                    placeholder="5XXXXXXXX"
                                    id="phoneNumberInput"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __("Email Address") }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <svg class="input-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <input class="form-input input-with-icon w-full py-3 rounded-lg text-gray-700 focus:outline-none" 
                                    type="email" 
                                    name="email" 
                                    maxlength="191" 
                                    required
                                    placeholder="{{ __("Enter Your :x", ['x' => __('Email Address')]) }}">
                            </div>
                            <div class="error-message" id="email_error"></div>
                        </div>
                    </div>

                    <!-- Quotation Details Section -->
                    <div class="animate-slide-up" style="animation-delay: 0.2s;">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-2" style="background: linear-gradient(135deg, <?php echo $primaryColor; ?> 0%, <?php echo adjustBrightness($primaryColor, -20); ?> 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                                <h2 class="text-2xl font-bold section-header">
                                {{ __("Quotation Details") }}
                            </h2>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __("Category") }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                
                                <select class="form-select input-with-icon w-full py-3 rounded-lg text-gray-700 focus:outline-none" 
                                    name="category" 
                                    id="category"
                                    required>
                                    <option value="">{{ __("Select") }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                              
                                </select>
                            </div>
                            <div class="error-message" id="category_error"></div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __("Upload RFQs") }} <span class="text-red-500">*</span>
                            </label>
                            <div class="file-upload rounded-lg p-6 text-center" id="dropZone">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <input class="hidden" 
                                    type="file" 
                                    name="pdf_file" 
                                    accept=".pdf"
                                    required
                                    id="pdf_upload">
                                <label for="pdf_upload" class="cursor-pointer">
                                    <span class="text-blue-600 font-medium hover:text-blue-500">
                                        {{ __("Click to upload") }}
                                    </span>
                                    <span class="text-gray-500"> {{ __("or drag and drop") }}</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ __("PDF files only, maximum 10MB") }}
                                </p>
                            </div>
                            <div class="error-message" id="pdf_error"></div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __("Additional Notes") }}
                            </label>
                            <textarea class="form-input w-full py-3 rounded-lg text-gray-700 focus:outline-none resize-none" 
                                name="notes" 
                                rows="4"
                                placeholder="{{ __("Enter any additional notes, requirements, or special instructions...") }}"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center pt-8">
                        <button type="submit" 
                            class="btn-primary px-12 py-4 text-white font-semibold rounded-lg text-lg shadow-lg flex items-center space-x-3">
                            <span>{{ __("Submit Quotation") }}</span>
                            @if (languageDirection() == 'ltr')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">
                {{ __("Quotation Submitted!") }}
            </h3>
            <p class="text-gray-600 mb-6">
                {{ __("Thank you for your submission. We'll get back to you soon.") }}
            </p>
            <button onclick="closeSuccessModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Close
            </button>
        </div>
    </div>

    <script>
        // Enhanced form validation with better UX
        function formValidation() {
            clearAllErrors();
            
            let isValid = true;
            const requiredFields = document.querySelectorAll('[required]');
            
            // Validate required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    showError(field.name, 'This field is required');
                    isValid = false;
                }
            });
            
            // Validate email format
            const email = document.querySelector('input[name="email"]');
            if (email.value && !isValidEmail(email.value)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }
            
            // Validate PDF file
            const pdfFile = document.querySelector('input[name="pdf_file"]');
            if (pdfFile.files.length > 0) {
                const file = pdfFile.files[0];
                if (file.type !== 'application/pdf') {
                    showError('pdf_file', 'Please select a valid PDF file');
                    isValid = false;
                }
                if (file.size > 10 * 1024 * 1024) {
                    showError('pdf_file', 'File size must be less than 10MB');
                    isValid = false;
                }
            }
            
            if (isValid) {
                // showSuccessModal();
                // return false; // Prevent form submission for demo
                return true;
            }
            
            return false;
        }
        
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        function showError(fieldName, message) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            const errorDiv = document.getElementById(`${fieldName.replace('_', '')}_error`);
            
            if (field && errorDiv) {
                field.style.borderColor = '#ef4444';
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
        }
        
        function clearAllErrors() {
            const errorMessages = document.querySelectorAll('.error-message');
            const formInputs = document.querySelectorAll('.form-input, .form-select');
            
            errorMessages.forEach(error => error.style.display = 'none');
            formInputs.forEach(input => input.style.borderColor = '#e5e7eb');
        }
        
        function showSuccessModal() {
            document.getElementById('successModal').classList.remove('hidden');
            document.getElementById('successModal').classList.add('flex');
        }
        
        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('successModal').classList.remove('flex');
        }
        
        // File upload preview
        document.getElementById('pdf_upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                updateFileDisplay(file);
            }
        });

        // Drag and drop functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('pdf_upload');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop zone when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                const file = files[0];
                
                // Check if it's a PDF file
                if (file.type === 'application/pdf') {
                    // Check file size (10MB limit)
                    if (file.size <= 10 * 1024 * 1024) {
                        fileInput.files = files;
                        updateFileDisplay(file);
                        clearError('pdf_file');
                    } else {
                        showError('pdf_file', 'File size must be less than 10MB');
                    }
                } else {
                    showError('pdf_file', 'Please select a valid PDF file');
                }
            }
        }

        function updateFileDisplay(file) {
            const fileUpload = document.querySelector('.file-upload');
            // Keep the file input but hide it
            const fileInput = fileUpload.querySelector('input[type="file"]');
            fileInput.style.display = 'none';
            
            // Create display content without removing the file input
            const displayContent = document.createElement('div');
            displayContent.className = 'flex items-center justify-center space-x-3';
            displayContent.innerHTML = `
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-600 font-medium">${file.name}</span>
                <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700 ml-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;
            
            // Clear existing content and add new display
            fileUpload.innerHTML = '';
            fileUpload.appendChild(fileInput); // Keep the file input
            fileUpload.appendChild(displayContent);
        }

        function removeFile() {
            fileInput.value = '';
            const fileUpload = document.querySelector('.file-upload');
            
            // Clear existing content
            fileUpload.innerHTML = '';
            
            // Restore the file input
            fileInput.style.display = 'block';
            fileUpload.appendChild(fileInput);
            
            // Restore the original upload interface
            const originalContent = document.createElement('div');
            originalContent.innerHTML = `
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <label for="pdf_upload" class="cursor-pointer">
                    <span class="text-blue-600 font-medium hover:text-blue-500">Click to upload</span>
                    <span class="text-gray-500"> or drag and drop</span>
                </label>
                <p class="text-xs text-gray-500 mt-2">PDF files only, maximum 10MB</p>
            `;
            
            fileUpload.appendChild(originalContent);
        }

        function clearError(fieldName) {
            const errorDiv = document.getElementById(`${fieldName.replace('_', '')}_error`);
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }
        
        // Language switcher functionality
        function changeLanguage(locale) {
            // Store the selected language in localStorage
            localStorage.setItem('selectedLanguage', locale);
            
            // Create a form to submit the language change
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("change-language") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add locale
            const localeInput = document.createElement('input');
            localeInput.type = 'hidden';
            localeInput.name = 'lang';
            localeInput.value = locale;
            form.appendChild(localeInput);
            
            // Submit the form
            document.body.appendChild(form);
            form.submit();
        }
        
        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add intersection observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe all form sections
            document.querySelectorAll('.animate-slide-up').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(40px)';
                section.style.transition = 'all 0.8s ease-out';
                observer.observe(section);
            });
        });
    </script>

    <script>
        // Limit input to numeric values only and restrict length
        document.getElementById('phoneNumberInput').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').slice(0, 12);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.10.6/build/js/intlTelInput.min.js"></script>
    <script>
    const input = document.querySelector("#phoneNumberInput");
        window.intlTelInput(input, {
            initialCountry: "sa",
            hiddenInput: () => ({ phone: "phone_number", country: "country_code" }),
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.10.6/build/js/utils.js"),
        });
    </script>

    <script src="{{ asset('public/datta-able/plugins/bootstrap-v5/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2(
                {
                    theme: 'tailwindcss-3',
                    placeholder: '{{ __("Select Country") }}',
                    allowClear: true,
                    width: '100%',
                    height: '100%',
                }
            );
        });

        $(document).ready(function() {
                $('#category').select2({
                    theme: 'tailwindcss-3',
                    placeholder: '{{ __("Type to search for a category using HS codes") }}',
                    allowClear: true,
                    dir:'{{ languageDirection() }}',
                    width: '100%',
                    minimumInputLength: 2,
                    ajax: {
                        url: '{{ route("categories.ajax") }}',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                            results:  $.map(data, function (item) {
                                    return {
                                        text: item.text,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
            });
        });
    
    </script>
</body>
</html>


