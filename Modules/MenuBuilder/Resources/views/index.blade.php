@extends('admin.layouts.app')
@section('page_title', __('Menus'))
@section('css')
    <link rel="stylesheet" href="{{ asset('Modules/MenuBuilder/Resources/assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/bootstrap/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/dist/css/menu-builder.min.css') }}">
@endsection
@section('content')
<!-- Main content -->
<div class="col-sm-12 list-container" id="menu-container">
    <?php
        $currentUrl = url()->current();
    ?>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Preference') }}</h5>
                    <div class="card-header-right">
                        <div class="btn-group card-option card-accordion">
                            <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                                <i class="fas fa-angle-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="accordion-body sections-body">
                    <form method="get" id="menu-from" action="{{ $currentUrl }}">
                        <div class="form-group">
                            <label for="">{{ __('Location')}}</label>
                            <select name="menu" class="form-control select2-hide-search form-select">
                                @foreach ($menulist as $role)
                                <option {{ $menuId == $role->id ? 'selected' : '' }} value="{{ $role->id }}">
                                    {{ ucwords($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="mt-3" for="">{{ __('Language')}}</label>
                            <x-backend.select2.language name="lang" :activeShortName="$selectedLang" />
                        </div>
                        
                        <div class="text-right">
                            <button class="btn btn-square btn-light f-w-600 btn-sm m-0 mt-3">
                                <i class="feather icon-edit-1"></i>{{ __('Apply to Edit Menu') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Custom Links') }}</h5>
                    <div class="card-header-right ">
                        <div class="btn-group card-option card-accordion">
                            <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                                <i class="fas fa-angle-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="accordion-body sections-body">
                    <div class="customlinkdiv" id="customlinkdiv">
                        <div class="form-group">
                            <label for="url">{{ __('URL')}}</label>
                            <input id="custom-menu-item-url" name="url" type="text" class="form-control inputFieldDesign" placeholder="https://">
                        </div>
                        
                        <div class="form-group">
                            <label for="label">{{ __('Label')}}</label>
                            <input id="custom-menu-item-name" name="label" type="text" class="form-control inputFieldDesign" placeholder="{{ __('Label Text') }}">

                        </div>
                        <div class="text-right">
                            <button class="btn btn-square btn-light f-w-600 btn-sm m-0" onclick="addcustommenuToDb()">
                                <i class="feather icon-plus"></i>{{ __('Add to Menu') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5>{{ isset($menuName) && !empty($menuName->name) ? ucfirst($menuName->name) : ''}}</h5>
                    <div class="card-header-right ">
                        <div class="btn-group card-option card-accordion">
                            <button type="button" class="btn dropdown-toggle drop-down-icon text-mute">
                                <i class="fas fa-angle-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div  class="accordion-body sections-body outer-border pe-0">
                    @if(!empty($adminMenus) && $adminMenus->count() > 0)
                    <div class="accordion-section-content">
                        <div class="inside menu-list section-scrollbar">
                            @foreach ($adminMenus as $key => $value)
                                @if($value->getModuleName($value->permission))
                                    <div class="customlinkdiv customlinkDropdown mb-1" id="customlinkdiv">
                                        <input type="checkbox" class="menu"
                                            id="{{ $value->slug }}" name="menu[]"
                                            data-name="{{ $value->slug }}"
                                            data-url="{{ $value->url }}"
                                            data-permission="{{ $value->permission }}"
                                            data-delete="{{ $value->is_default }}"
                                            value="{{ $value->id }}">
                                            <label for="{{ $value->slug }}"> {{ $value->name }}</label>
                                            <br>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-square btn-light f-w-600 btn-sm mt-2" onclick="addcustommenu()">
                            <i class="feather icon-plus"></i>{{ __('Add menu item') }}
                        </button>
                    </div>
                    @elseif (!empty($pages) && $pages->count() > 0)
                        <div class="accordion-section-content">
                            <div class="inside">
                                @foreach ($pages as $key => $page)
                                <div class="customlinkdiv customlinkDropdown mb-2 " id="customlinkdiv">
                                    <input type="checkbox" class="menu m-0 ltr:me-2 rtl:ms-2"
                                        id="{{ $page->name }}" name="menu[]"
                                        data-name="{{ $page->name }}"
                                        data-url="{{ $page->slug }}"
                                        data-permission=""
                                        data-delete="1"
                                        value="{{ $page->id }}">
                                    <label class="mb-0" for="{{ $page->name }}"> {{ $page->name }}</label>
                                    <br>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-square btn-light f-w-600 btn-sm mt-2" onclick="addcustommenu()">
                                <i class="feather icon-plus"></i>{{ __('Add menu item') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="hwpwrap" class="card">
                <div class="card-header">
                    @if (request()->has("menu"))
                        <h5>@if(isset($menuName->name) && !empty($menuName->name)) {{ ucwords($menuName->name) }} @endif {{ __('Menu Structure') }} </h5>
                    @else
                        <h5>{{ __('Menu Creation') }}</h5>
                    @endif
                </div>
                <div class="sections-body nav-menus-php pe-0 pb-1">
                    <div id="menu-management-liquid">
                        <div id="menu-management">
                            <form dir="ltr" id="update-nav-menu" action="" method="post"
                                enctype="multipart/form-data">
                                <div class="bg-white">
                                    <div class="bg-white main-menu-section section-scrollbar">
                                        <div id="post-body-content">
                                            @if(request()->has("menu"))
                                            <div class="drag-instructions post-body-plain">
                                                <p>{{ __('Place each item in the order you prefer. Click on the arrow to the right of the item to display more configuration options') }}</p>
                                            </div>
                                            @else
                                            <div class="drag-instructions post-body-plain">
                                                <p>
                                                    {{ __('Please enter the name and select Create menu button') }}
                                                </p>
                                            </div>
                                            @endif
                                            <ul class="menu ui-sortable" id="menu-to-edit">
                                                @if(isset($menus))
                                                    @foreach ($menus as $m)
                                                        @if($m->getModuleName())
                                                            @include('menubuilder::menus', $m)
                                                        @endif
                                                        @foreach($m->child as $key => $m)
                                                            @include('menubuilder::menus', $m)
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="nav-menu-footer" class="bg-white mt-3 border-top">
                                        <div class="major-publishing-actions">
                                            @if(request()->has('action'))
                                            <div class="publishing-action">
                                                <a onclick="createnewmenu()" name="save_menu"
                                                    id="save_menu_header"
                                                    class="btn btn-primary custom-btn-small menu-save">{{ __('Create menu') }}
                                                </a>
                                            </div>
                                            @elseif(request()->has("menu"))
                                            @if(!$adminMenus->isEmpty())
                                            <span class="delete-actions">
                                                <button type="button"
                                                    class="btn btn-outline-danger"
                                                    onclick="deletemenu()">{{ __('Delete All Menu') }}
                                                </button>
                                            </span>
                                            @endif
                                            <div class="action-btn d-inline-block mt-10p">
                                                <button type="button" class="btn" onclick="getmenus1()">{{ __('Save Menu') }}</button>
                                            </div>
                                            @else
                                            <div class="publishing-action">
                                                <a onclick="createnewmenu()" name="save_menu"
                                                    id="save_menu_header"
                                                    class="btn btn-primary custom-btn-small menu-save">{{ __('Create menu') }}
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    var menus = {
		"oneThemeLocationNoMenus" : "",
		"moveUp" : "Move up",
		"moveDown" : "Mover down",
		"moveToTop" : "Move top",
		"moveUnder" : "Move under of %s",
		"moveOutFrom" : "Out from under  %s",
		"under" : "Under %s",
		"outFrom" : "Out from %s",
		"menuFocus" : "%1$s. Element menu %2$d of %3$d.",
		"subMenuFocus" : "%1$s. Menu of subelement %2$d of %3$s."
	};
	var arraydata = [];
	var addCustomMenu= '{{ route("menu.custom") }}';
	var updateProduct = '{{ route("menu.update")}}';
	var generateMenuControl = '{{ route("menu.control") }}';
	var deleteItemMenu = '{{ route("menu.item.delete") }}';
	var deleteMenu = '{{ route("menu.delete") }}';
	var createNewMenu = '{{ route("menu.create") }}';
	var updateItem = '{{ route("menu.update") }}';
	var csrftoken="{{ csrf_token() }}";
	var menuwr = "{{ url()->current() }}";
    var menuId = new URL(window.location.href).searchParams.get("menu");
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrftoken
		}
	});
</script>
<script src="{{ asset('public/dist/js/custom/common.min.js') }}"></script>
<script src="{{ asset('public/datta-able/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('public/datta-able/plugins/sweetalert/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('Modules/MenuBuilder/Resources/assets/js/scripts.min.js') }}"></script>
<script src="{{ asset('Modules/MenuBuilder/Resources/assets/js/scripts2.min.js') }}"></script>
<script src="{{ asset('Modules/MenuBuilder/Resources/assets/js/menu.min.js?v=2.4') }}"></script>
@endsection
