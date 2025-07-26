
<!-- Profile Image -->
<div class="card card-info display_block" id="nav">
    <div class="card-header p-t-20">
        <h5><a href="{{ route('currency.index') }}" id="general-settings">{{ __('Manage Product') }}</a></h5>
    </div>
    <ul class="nav nav-pills nav-stacked" id="mcap-tab" role="tablist">
        @hasPermission('App\Http\Controllers\ProductSettingController@general')
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'general' ? 'active' : ''}}" href="{{ route('product.setting.general') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('General') }}</a>
            </li>
        @endhasPermission

        @hasPermission('App\Http\Controllers\ProductSettingController@inventory')
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'inventory' ? 'active' : ''}}" href="{{ route('product.setting.inventory') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Inventory') }}</a>
            </li>
        @endhasPermission

        @hasPermission('App\Http\Controllers\ProductSettingController@vendor')
            <li class="nav-item">
                <a class="nav-link h-lightblue text-left {{ isset($list_menu) &&  $list_menu == 'vendor' ? 'active' : ''}}" href="{{ route('product.setting.vendor') }}" id="s" role="tab" aria-controls="mcap-default" aria-selected="true">{{ __('Vendor') }}</a>
            </li>
        @endhasPermission
    </ul>
</div>
<!-- /.box-body -->
