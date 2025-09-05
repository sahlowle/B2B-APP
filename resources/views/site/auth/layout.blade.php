<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
       @yield('title')
    </title>

    @php
        $favicon = App\Models\Preference::getFavicon()
    @endphp
    
    @if(!empty($favicon))
        <link rel='shortcut icon' href="{{ $favicon }}" type='image/x-icon' />
    @endif

    

    @php
    if (!isset($page->layout)) {
          $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
      }

      $layout = $page->layout;
      $primaryColor = option($layout . '_template_primary_color', '#FCCA19');
      
   @endphp

  <style>
    :root {
      --primary-color: {{ $primaryColor }};
    }

    body {
      background-color: #F3F4F6 !important;
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
  </style>

  
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
    

    @yield('css')

</head>

<body class="min-h-screen" dir="{{ languageDirection() }}" >

     <!-- Header Section -->
     <header class="">
        <div class="container mx-auto mt-4">
            <!-- Language Switcher -->
            <div class="flex justify-end">
                <div class="language-switcher">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">{{ __("Language") }}:</span>
                        <select id="languageSelect" onchange="changeLanguage(this.value)">
                            @foreach(config('app.available_locales', ['en' => 'English', 'ar' => 'العربية']) as $locale => $name)
                                <option value="{{ $locale }}" {{ app()->getLocale() == $locale ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    </header>

    @yield('content')
    

    @if (file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">
            const translates = {};
        </script>
    @endif

    <script>
        function changeLanguage(locale) {
            var url =  "{{ route('change-language')}}?lang="+locale;
            window.location.href = url;
        }
    </script>

    @yield('js')
</body>
</html>


