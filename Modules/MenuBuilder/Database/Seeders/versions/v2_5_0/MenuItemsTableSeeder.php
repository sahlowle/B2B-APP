<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_5_0;

use Illuminate\Database\Seeder;
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
        $links = [
            'dashboard' => 'overview',
            'refund-request' => 'refunds',
        ];

        foreach ($links as $key => $value) {
            MenuItems::where(['menu' => 2, 'link' => $key])->update(['link' => $value]);
        }

        addMenuItem('user', 'Notifications', [
            'link' => 'notifications',
            'sort' => 7.5,
            'icon' => 'fas fa-bell',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\Site\\\\NotificationController@index", "route_name":["site.notifications.index"], "menu_level":"2"}',
        ]);

        MenuItems::where('label', 'Notifications')->update(['label' => '{"en":"Notifications","bn":"বিজ্ঞপ্তি","fr":"Notifications","zh":"通知","ar":"إشعارات","be":"Апавяшчэнні","bg":"Известия","ca":"Notificacions","et":"Teavitused","nl":"Meldingen"}']);
    }
}
