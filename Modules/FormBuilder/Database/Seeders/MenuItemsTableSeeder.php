<?php

namespace Modules\FormBuilder\Database\Seeders;

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

        /**
         * Auto generated seed file
         *
         * @return void
         */
        DB::table('menu_items')->upsert([
            ['id' => 70, 'label' => 'KYC', 'link' => 'forms/kyc-form', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\KycController@index", "route_name":["formbuilder::kyc.index", "formbuilder::kyc.edit", "formbuilder::kyc.sub-view", "formbuilder::kyc.sub-edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 37, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 71, 'label' => 'KYC', 'link' => 'kyc', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\Vendor\\\\KycController@userKycForm", "route_name":["kyc.user.show"], "menu_level":"3"}', 'is_default' => 1, 'icon' => 'far fa-address-card', 'parent' => 0, 'sort' => 9, 'class' => null, 'menu' => 3, 'depth' => 0],
            ['id' => 68, 'label' => 'All Forms', 'link' => 'forms', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\FormController@index", "route_name":["formbuilder::forms.index", "formbuilder::forms.create", "formbuilder::forms.edit"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 35, 'class' => null, 'menu' => 1, 'depth' => 1],
            ['id' => 67, 'label' => 'Forms', 'link' => null, 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\FormController@index","route_name":["formbuilder::kyc.index", "formbuilder::kyc.edit", "formbuilder::kyc.sub-view", "formbuilder::submissions.all","formbuilder::entry.index","formbuilder::entry.edit", "formbuilder::entry.update", "formbuilder::entry.show", "formbuilder::forms.index", "formbuilder::forms.create", "formbuilder::forms.edit"]}', 'is_default' => 0, 'icon' => 'fas fa-window-restore', 'parent' => 0, 'sort' => 34, 'class' => null, 'menu' => 1, 'depth' => 0],
            ['id' => 69, 'label' => 'All Submissions', 'link' => 'forms/submissions', 'params' => '{"permission":"Modules\\\\FormBuilder\\\\Http\\\\Controllers\\\\SubmissionController@index", "route_name":["formbuilder::submissions.all","formbuilder::entry.index","formbuilder::entry.edit", "formbuilder::entry.update", "formbuilder::entry.show"], "menu_level":"1"}', 'is_default' => 1, 'icon' => null, 'parent' => 67, 'sort' => 36, 'class' => null, 'menu' => 1, 'depth' => 1],
        ], 'id');

        MenuItems::where('label', 'KYC')->update(['label' => '{"en":"KYC","bn":"আইডি প্রমাণিত করুন","fr":"KYC","zh":"KYC","ar":"KYC","be":"KYC","bg":"KYC","ca":"KYC","et":"KYC","nl":"KYC"}']);
        MenuItems::where('label', 'All Forms')->update(['label' => '{"en":"All Forms","bn":"সমস্ত ফর্ম","fr":"Tous les formulaires","zh":"所有表单","ar":"جميع النماذج","be":"Усе формы","bg":"Всички форми","ca":"Tots els formularis","et":"Kõik vormid","nl":"Alle formulieren"}']);
        MenuItems::where('label', 'Forms')->update(['label' => '{"en":"Forms","bn":"ফর্ম","fr":"Formulaires","zh":"表单","ar":"نماذج","be":"Фармы","bg":"Формуляри","ca":"Formularis","et":"Vormid","nl":"Formulieren"}']);
        MenuItems::where('label', 'All Submissions')->update(['label' => '{"en":"All Submissions","bn":"সমস্ত জমা","fr":"Toutes les soumissions","zh":"所有提交","ar":"جميع الإرسالات","be":"Усе дасылкі","bg":"Всички подавания","ca":"Totes les presentacions","et":"Kõik esitused","nl":"Alle inzendingen"}']);

    }
}
