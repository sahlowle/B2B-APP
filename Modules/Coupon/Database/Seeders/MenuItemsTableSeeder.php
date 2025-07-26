<?php

namespace Modules\Coupon\Database\Seeders;

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
            ['id' => 72, 'label' => 'Add coupon', 'link' => 'coupon/create', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponController@create","route_name":["coupon.create"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 27, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 105, 'label' => 'All Coupons', 'link' => 'coupons', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponController@index","route_name":["coupon.index","coupon.edit","coupon.pdf","coupon.csv","coupon.shop","coupon.item"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 28, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 106, 'label' => 'Coupon Redeems', 'link' => 'coupon-redeems', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\CouponRedeemController@index","route_name":["couponRedeem.index"]}', 'is_default' => 1, 'icon' => null, 'parent' => 73, 'sort' => 29, 'class' => null, 'menu' => 1, 'depth' => 1],

            ['id' => 75, 'label' => 'Coupons', 'link' => 'coupons', 'params' => '{"permission":"Modules\\\\Coupon\\\\Http\\\\Controllers\\\\Vendor\\\\CouponController@index","route_name":["vendor.coupons", "vendor.couponCreate", "vendor.couponEdit", "vendor.couponProduct"]}', 'is_default' => 1, 'icon' => 'fas fa-ticket-alt', 'parent' => 0, 'sort' => 4, 'class' => null, 'menu' => 3, 'depth' => 0],
        ], 'id');

        MenuItems::where('label', 'Add coupon')->update(['label' => '{"en":"Add Coupon","bn":"কুপন যোগ করুন","fr":"Ajouter un coupon","zh":"添加优惠券","ar":"إضافة كوبون","be":"Дадаць купон","bg":"Добавяне на купон","ca":"Afegir un cupó","et":"Lisa kupon","nl":"Coupon toevoegen"}']);
        MenuItems::where('label', 'All Coupons')->update(['label' => '{"en":"All Coupons","bn":"সমস্ত কুপন","fr":"Tous les coupons","zh":"所有优惠券","ar":"جميع الكوبونات","be":"Усе купоны","bg":"Всички купони","ca":"Tots els cupons","et":"Kõik kupongid","nl":"Alle coupons"}']);
        MenuItems::where('label', 'Coupon Redeems')->update(['label' => '{"en":"Coupon Redeems","bn":"কুপন পুনঃপ্রাপ্ত","fr":"Utilisations des coupons","zh":"优惠券兑换","ar":"استرداد الكوبون","be":"Выкарыстанне купонаў","bg":"Откупени купони","ca":"Cupons redimits","et":"Kupongi lunastused","nl":"Couponinlossingen"}']);
        MenuItems::where('label', 'Coupons')->update(['label' => '{"en":"Coupons","bn":"কুপন","fr":"Coupons","zh":"优惠券","ar":"كوبونات","be":"Купоны","bg":"Купони","ca":"Cupons","et":"Kupongid","nl":"Coupons"}']);
    }
}
