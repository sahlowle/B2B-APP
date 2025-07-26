<div id="overlay" class="fixed z-50 top-0 left-0 bg-darken-4"></div>

<nav class="bg-white h-max border border-gray-300 p-2 shadow-md sidebar-nav z-50 md:z-30 top-0 left-0 md:w-64 lg:w-1/4 text-color-14 flex flex-col"
    id="sidenavbar">
    <div class="custom-close absolute top-3 right-3 cursor-pointer md:hidden">
                <svg class="neg-transition-scale" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0.439152 0.43934C1.02469 -0.146447 1.97403 -0.146447 2.55957 0.43934L11.5557 9.43934C12.1413 10.0251 12.1413 10.9749 11.5557 11.5607C10.9702 12.1464 10.0208 12.1464 9.43531 11.5607L0.439152 2.56066C-0.146384 1.97487 -0.146384 1.02513 0.439152 0.43934Z"
                fill="#898989" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M11.5569 0.43934C10.9714 -0.146447 10.0221 -0.146447 9.43653 0.43934L0.44037 9.43934C-0.145167 10.0251 -0.145167 10.9749 0.44037 11.5607C1.02591 12.1464 1.97525 12.1464 2.56078 11.5607L11.5569 2.56066C12.1425 1.97487 12.1425 1.02513 11.5569 0.43934Z"
                fill="#898989" />
        </svg>
    </div>
    
    <ul class="overflow-auto mt-5">
        <?php
            $menus = Modules\MenuBuilder\Http\Models\MenuItems::menus(2);
        ?>
        @foreach ($menus as $menu)
        <li>
            @if ($menu->icon == 'fas fa-universal-access')
                @continue
            @endif
            <a href="{{ $menu->url('myaccount') }}" class="flex justify-start items-center text-black  {{ $menu->isLinkActive() ? 'bg-yellow-300 ' : 'hover:bg-gray-11' }} rounded md:py-4 py-3 px-5 gap-3 font-medium leading-5 cursor-pointer">
                <i class="{{ $menu->icon }} {{ !$menu->isLinkActive() ? 'text-gray-7' : '' }}"></i>
            <span>{{ $menu->label_name }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</nav>
