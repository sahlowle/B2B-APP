<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
       @yield('title')
    </title>

    

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

    @yield('content')
    

    @if (file_exists(base_path('public/js/lang/' . config('app.locale') . '.js')))
        <script src="{{ asset('public/js/lang/' . config('app.locale') . '.js') }}"></script>
    @else
        <script type="text/javascript">
            const translates = {};
        </script>
    @endif

    @yield('js')
</body>
</html>


