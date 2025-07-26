<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Schema;
use App\Models\{
     Preference
};
use Illuminate\Contracts\Auth\Guard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Check boot method is loaded or not.
     *
     * @var bool
     */
    public $isBooted;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        Schema::defaultStringLength(191);
        error_reporting(E_ALL);

        // Check if the app is installed or not & if the request is not from console
        if (config('martvill.app_install') == true) {
            View::composer('*', function ($view) {
                $data['prms'] = auth()->user()?->permissions();
                $data['view_name'] = $view->getName();
                $view->with($data);
                $this->isBooted = true;
            });
        }

        $this->app->bind(config('cache.prefix') . '.' . 'preferences', function () {
            return \Cache::rememberForever(config('cache.prefix') . '.' . 'preferences', function () {
                return Preference::pluck('value', 'field');
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('all-image', function () {
            return \Storage::disk()->allFiles('public/uploads');
        });

        $this->app->singleton('image-directories', function () {
            return \Storage::disk()->allDirectories('public');
        });
    }
}
