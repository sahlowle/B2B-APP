<?php

namespace Modules\Blog\Database\Seeders;

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
            ['id' => 54, 'label' => 'Categories', 'link' => 'blog/category/list', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogCategoryController@index", "route_name":["blog.category.index"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 25, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 55, 'label' => 'Add Post', 'link' => 'blog/create', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogController@create", "route_name":["blog.create"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 23, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 59, 'label' => 'All Posts', 'link' => 'blogs', 'params' => '{"permission":"Modules\\\\Blog\\\\Http\\\\Controllers\\\\BlogController@index", "route_name":["blog.index", "blog.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 56, 'sort' => 24, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 56, 'label' => 'Blogs', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fab fa-blogger-b', 'parent' => 0, 'sort' => 22, 'class' => null, 'menu' => 1, 'depth' => 0],
        ], 'id');

        MenuItems::where('label', 'Categories')->update(['label' => '{"en":"Categories","bn":"বিভাগ","fr":"Catégories","zh":"类别","ar":"فئات","be":"Катэгорыі","bg":"Категории","ca":"Categories","et":"Kategooriad","nl":"Categorieën"}']);
        MenuItems::where('label', 'Add Post')->update(['label' => '{"en":"Add Post","bn":"পোস্ট যোগ করুন","fr":"Ajouter une publication","zh":"添加帖子","ar":"إضافة مشاركة","be":"Дадаць паведамленне","bg":"Добавяне на публикация","ca":"Afegir publicació","et":"Lisa postitus","nl":"Bericht toevoegen"}']);
        MenuItems::where('label', 'All Posts')->update(['label' => '{"en":"All Posts","bn":"সমস্ত পোস্ট","fr":"Tous les articles","zh":"所有帖子","ar":"جميع المشاركات","be":"Усе паведамленні","bg":"Всички публикации","ca":"Totes les publicacions","et":"Kõik postitused","nl":"Alle berichten"}']);
        MenuItems::where('label', 'Blogs')->update(['label' => '{"en":"Blogs","bn":"ব্লগ","fr":"Blogs","zh":"博客","ar":"المدونات","be":"Блогі","bg":"Блогове","ca":"Blogs","et":"Blogid","nl":"Blogs"}']);
    }
}
