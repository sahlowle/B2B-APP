<?php

namespace Modules\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Theme;

class CMSServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Theme::add('default', [
            'thumbnail' => 'Modules/CMS/Resources/assets/img/default-theme.png',
            'title' => 'Default Theme',
            'description' => 'Martvill - A Global Multivendor Ecommerce Platform to Sell Anything',
            'author' => 'Techvillage',
            'author_url' => 'https://codecanyon.net/user/techvillage1',
            'customize_url' => url('admin/theme/list'),
            'version' => '2.0.0',
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}
}
