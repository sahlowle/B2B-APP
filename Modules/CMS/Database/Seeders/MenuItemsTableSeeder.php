<?php

namespace Modules\CMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->upsert([
            ['id' => 57, 'label' => 'Website Setup', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fas fa-globe', 'parent' => 0, 'sort' => 39, 'class' => null, 'menu' => 1, 'depth' => 0],
            ['id' => 58, 'label' => 'All Sliders', 'link' => 'sliders', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\SliderController@index", "route_name":["slider.index", "slide.create", "slide.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 39, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 60, 'label' => 'Pages', 'link' => 'page/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\CMSController@index", "route_name":["page.index", "page.create", "page.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 41, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 92, 'label' => 'Appearance', 'link' => 'theme/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\ThemeOptionController@list", "route_name":["theme.index", "theme.store"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 42, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 93, 'label' => 'Home Pages', 'link' => 'page/home/list', 'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\CMSController@index", "route_name":["page.home", "builder.edit", "page.home.create", "page.home.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 57, 'sort' => 40, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');

        MenuItems::where('label', 'Website Setup')->update(['label' => '{"en":"Website Setup","bn":"ওয়েবসাইট সেটআপ","fr":"Configuration du site web","zh":"网站设置","ar":"إعداد الموقع الإلكتروني","be":"Налада сайту","bg":"Настройка на уебсайта","ca":"Configuració del lloc web","et":"Veebisaidi seadistamine","nl":"Website-instellingen"}']);
        MenuItems::where('label', 'All Sliders')->update(['label' => '{"en":"All Sliders","bn":"সমস্ত স্লাইডার","fr":"Tous les curseurs","zh":"所有幻灯片","ar":"جميع المنزلقات","be":"Усе слайдеры","bg":"Всички слайдшоу","ca":"Tots els sliders","et":"Kõik liugureid","nl":"Alle sliders"}']);
        MenuItems::where('label', 'Pages')->update(['label' => '{"en":"Pages","bn":"পৃষ্ঠা","fr":"Pages","zh":"页面","ar":"الصفحات","be":"Старонкі","bg":"Страници","ca":"Pàgines","et":"Leheküljed","nl":"Pagina\'s"}']);
        MenuItems::where('label', 'Appearance')->update(['label' => '{"en":"Appearance","bn":"চেহারা","fr":"Apparence","zh":"外观","ar":"مظهر","be":"Знешні выгляд","bg":"Изглед","ca":"Aparença","et":"Välimus","nl":"Uiterlijk"}']);
        MenuItems::where('label', 'Home Pages')->update(['label' => '{"en":"Home Pages","bn":"হোম পেজ","fr":"Pages d\'accueil","zh":"主页","ar":"الصفحات الرئيسية","be":"Дамашнія старонкі","bg":"Начални страници","ca":"Pàgines d\'inici","et":"Avalehed","nl":"Startpagina\'s"}']);
    }
}
