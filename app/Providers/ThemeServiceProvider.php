<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Themeable\Theme;
use App\Lib\Themeable\ThemeContract;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register bindings or configurations if necessary
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(ThemeContract::class, function ($app) {
            $theme = new Theme(
                $app,
                $app['view']->getFinder(),
                $app['config']
            );
            return $theme;
        });

        $this->app->singleton('theme', function ($app) {
            return $app->make(ThemeContract::class);
        });
    }
}
