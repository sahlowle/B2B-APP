<?php

namespace Modules\GeoLocale\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\GeoLocale\Repositories\{
    CountryRepository,
    StateRepository,
    CityRepository
};
use Modules\GeoLocale\Repositories\Interfaces\{
    CountryRepositoryInterface,
    StateRepositoryInterface,
    CityRepositoryInterface
};

class GeoLocaleServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        add_action('admin_add_import_data_card', function () {
            echo view('geolocale::import-data-card');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    }
}
