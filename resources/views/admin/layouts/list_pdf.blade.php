<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @yield('pdf-title')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/dist/css/pdf/list_pdf.min.css') }}">
</head>

<body>
<div class="content-wraper">
    <div class="unicode_font">
    <div>
      <table class="table">
        <tbody>
          <tr class="tbody-tr">
            @yield('header-info')
            <td class="td-off"></td>
            <td colspan="2" class="tbody-td">
              @php
                $company_logo = preference('company_logo');
              @endphp
              @if(!empty($company_logo))
                @if(isFileExist("public/uploads/companyPic/". $company_logo))
                  <img src="{{ Storage::disk()->url('/') . '/public/uploads/companyPic/' . $company_logo }}" alt="{{ Storage::disk()->url('/') . 'public/uploads/companyPic/' . $company_logo }}" class="mt-1p5">
                @endif
              @endif
              <div><span class="company-name">{{ preference('company_name') }}</span></div>
              <div class="d-block">
                <span class="company-info">{{ preference('company_street') }},  {{ preference('company_city') }}</span>
                <span class="company-info">{{ preference('company_zipCode') }}</span>
              </div>

            <div>
              <span class="company-info">
              {{ __('Web') }}: <a class="company-info-url" href="{{ url('/') }}">{{ url('/') }}</a>
              </span>
            </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="mt-30">
      @yield('list-table')
    </div>
</div>
</body>
</html>
