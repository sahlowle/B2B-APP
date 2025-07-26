  <div class="card card-info shadow-none mb-0" id="nav">
    <div class="card-header p-t-20 border-bottom mb-6p">
        <h5>{{ __('Manage') }}</h5>
    </div>
    <ul class="nav flex-column nav-pills ps-4" id="mcap-tab" role="tablist">
        @foreach (\App\Lib\Menus\Vendor\AccountSettings::get() as $liItem)
            @if (isset($liItem['visibility']) && $liItem['visibility'] === false)
                @continue
            @endif

            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) && $list_menu == ($liItem['name'] ?? '') ? 'active' : '' }}"
                    href="{{ $liItem['href'] ?? '#' }}" id="s" role="tab" aria-controls="mcap-default"
                    aria-selected="true">{{ $liItem['label'] }}</a>
            </li>
        @endforeach
    </ul>
  </div>
