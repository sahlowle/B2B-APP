<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('impersonated', function () {
            return session()->has('impersonator');
        });

        Blade::if('ifSettings', function ($name) {
            $val = preference($name);
            $args = func_get_args();

            return count($args) == 1 ? ($val ? true : false) : $args[1] == $val;
        });

        Blade::directive('preference', function ($name) {
            return "{{ preference($name); }}";
        });

        Blade::if('hasPermission', function ($permission) {
            return auth()->user()?->hasPermission($permission);
        });

        Blade::if('hasAnyPermission', function ($permissions) {
            return auth()->user()?->hasAnyPermission($permissions);
        });

        Blade::if('hasAllPermissions', function ($permissions) {
            return auth()->user()?->hasAllPermissions($permissions);
        });
    }
}
