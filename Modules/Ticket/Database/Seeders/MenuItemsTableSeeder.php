<?php

namespace Modules\Ticket\Database\Seeders;

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
            ['id' => 130, 'label' => 'Tickets', 'link' => 'ticket/list', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\Vendor\\\\TicketController@index", "route_name":["vendor.threads", "vendor.threadAdd", "vendor.threadReply", "vendor.threadPdf", "vendor.threadCsv"]}', 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 11, 'class' => null, 'menu' => 3, 'depth' => 0],

            ['id' => 103, 'label' => 'Add Ticket', 'link' => 'ticket/add', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@add", "route_name":["admin.threadAdd"]}', 'is_default' => 1, 'icon' => null, 'parent' => 90, 'sort' => 45, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 104, 'label' => 'All Tickets', 'link' => 'ticket/list', 'params' => '{"permission":"Modules\\\\Ticket\\\\Http\\\\Controllers\\\\TicketController@index", "route_name":["admin.tickets", "admin.threadReply", "admin.threadEdit", "admin.threadPdf", "admin.changePriority"]}', 'is_default' => 1, 'icon' => null, 'parent' => 90, 'sort' => 46, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 90, 'label' => 'Support Tickets', 'link' => null, 'params' => null, 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 44, 'class' => null, 'menu' => 1, 'depth' => 0],

        ], 'id');

        MenuItems::where('label', 'Tickets')->update(['label' => '{"en":"Tickets","bn":"টিকিট","fr":"Tickets","zh":"票","ar":"تذاكر","be":"Квіткі","bg":"Билети","ca":"Tiquets","et":"Piletid","nl":"Tickets"}']);
        MenuItems::where('label', 'Add Ticket')->update(['label' => '{"en":"Add Ticket","bn":"টিকেট যোগ করুন","fr":"Ajouter un ticket","zh":"添加工单","ar":"إضافة تذكرة","be":"Дадаць квіток","bg":"Добавяне на билет","ca":"Afegir un tiquet","et":"Lisa pilet","nl":"Ticket toevoegen"}']);
        MenuItems::where('label', 'All Tickets')->update(['label' => '{"en":"All Tickets","bn":"সমস্ত টিকিট","fr":"Tous les tickets","zh":"所有工单","ar":"جميع التذاكر","be":"Усе квіткі","bg":"Всички билети","ca":"Tots els tiquets","et":"Kõik piletid","nl":"Alle tickets"}']);
        MenuItems::where('label', 'Support Tickets')->update(['label' => '{"en":"Support Tickets","bn":"সমর্থন টিকেট","fr":"Tickets de support","zh":"支持票","ar":"تذاكر الدعم","be":"Квіткі падтрымкі","bg":"Билети за поддръжка","ca":"Tiquets de suport","et":"Toetuse piletid","nl":"Ondersteuningstickets"}']);
    }
}
