<button class="flex justify-center items-center gap-2 border border-gray-400 rounded p-2.5 collapse-icon mt-5 md:hidden text-sm font-medium text-black">
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 4.5C1.5 4.08579 1.83579 3.75 2.25 3.75H15.75C16.1642 3.75 16.5 4.08579 16.5 4.5C16.5 4.91421 16.1642 5.25 15.75 5.25H2.25C1.83579 5.25 1.5 4.91421 1.5 4.5ZM1.5 9C1.5 8.58579 1.83579 8.25 2.25 8.25H15.75C16.1642 8.25 16.5 8.58579 16.5 9C16.5 9.41421 16.1642 9.75 15.75 9.75H2.25C1.83579 9.75 1.5 9.41421 1.5 9ZM1.5 13.5C1.5 13.0858 1.83579 12.75 2.25 12.75H11.25C11.6642 12.75 12 13.0858 12 13.5C12 13.9142 11.6642 14.25 11.25 14.25H2.25C1.83579 14.25 1.5 13.9142 1.5 13.5Z" fill="#2C2C2C"/>
    </svg> 
    {{ __('Profile Menu') }}
</button>
@php
    $routeName = Route::currentRouteName();
    
    $routes = [
        'site.wishlist' => ['label' => __('Wishlist')],
        'site.review' => ['label' => __('Reviews')],
        'site.userProfile' => ['label' => __('Profile')],
        'site.userSetting' => ['label' => __('Settings')],
        'site.userActivity' => ['label' => __('Activity'), 'previous' => 'site.userSetting'],
        'site.download' => ['label' => __('Downloads')],
        'site.address' => ['label' => __('Addresses')],
        'site.addressCreate' => ['label' => __('Add New Address'), 'previous' => 'site.address'],
        'site.addressEdit' => ['label' => __('Edit Address'), 'previous' => 'site.address'],
        'site.order' => ['label' => __('Orders')],
        'site.orderDetails' => ['label' => __('Order Details'), 'previous' => 'site.order'],
        'site.notifications.index' => ['label' => __('Notifications')],
        'site.refundRequest' => ['label' => __('Refund Request')],
        'site.createRefundRequest' => ['label' => __('Create Refund Request'), 'previous' => 'site.refundRequest'],
        'site.refundDetails' => ['label' => __('Refund Details'), 'previous' => 'site.refundRequest'],
    ];
@endphp
<nav class="xl:mt-12 md:mt-8 mt-6 leading-4 md:mb-5 mb-6" aria-label="Breadcrumb">
    <ol class="list-none inline-flex">
        <li class="flex items-center justify-center">
            <svg class="-mt-0.5" xmlns="http://www.w3.org/2000/svg" width="13" height="15" viewBox="0 0 13 15" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215C2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z" fill="#898989"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z" fill="#898989"></path>
            </svg>
            <a class="text-neutral-500 roboto-medium font-medium md:text-sm text-xs ltr:ml-2 rtl:mr-2" href="{{ route('site.dashboard') }}" previewlistener="true">{{ __("Home") }}</a>
        </li>
        @if (array_key_exists($routeName, $routes))
            @if(isset($routes[$routeName]['previous']))
                <li>
                    <span class="text-neutral-500 roboto-medium font-medium md:text-sm text-xs ltr:ml-2 rtl:mr-2">/ </span>
                    <a href="{{ route($routes[$routeName]['previous']) }}" class="text-neutral-500 md:text-sm text-xs roboto-medium font-medium ltr:ml-2 rtl:mr-2" aria-current="page">{{ $routes[$routes[$routeName]['previous']]['label'] }}</a>
                </li>
            @endif
            <li>
                <span class="text-neutral-500 roboto-medium font-medium md:text-sm text-xs ltr:ml-2 rtl:mr-2">/ </span>
                <span class="text-black md:text-sm text-xs roboto-medium font-medium ltr:ml-2 rtl:mr-2" aria-current="page">{{ $routes[$routeName]['label'] }}</span>
            </li>
        @endif
    </ol>
</nav>
