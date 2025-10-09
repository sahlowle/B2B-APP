<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;
use Modules\Subscription\Entities\{
    PackageSubscription, PackageSubscriptionMeta
};
class PackageSubscriptionsMetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        $subscription = PackageSubscription::where(['code' => '0QUIWAUF35'])->first();

        if ($subscription) {
            PackageSubscriptionMeta::insertOrIgnore([
                [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'value',
                    'value' => '100',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title',
                    'value' => 'Staff limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'value',
                    'value' => '5',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'value',
                    'value' => '5',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","External/Affiliate Product"]',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'duration',
                    'value' => NULL,
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'trial',
                    'value' => '7',
                ]
            ]);
        }

        $subscription = PackageSubscription::where(['code' => '2T0TW8CJLR'])->first();

        if ($subscription) {
            PackageSubscriptionMeta::insertOrIgnore([
                [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'value',
                    'value' => '200',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'usage',
                    'value' => '6',
                ],[
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title',
                    'value' => 'Staff limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'value',
                    'value' => '10',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'value',
                    'value' => '10',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","External/Affiliate Product"]',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'duration',
                    'value' => NULL,
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'trial',
                    'value' => '15',
                ]
            ]);
        }

        $subscription = PackageSubscription::where(['code' => 'DNQFLN6FWX'])->first();

        if ($subscription) {
            PackageSubscriptionMeta::insertOrIgnore([
                [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'value',
                    'value' => '50',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title',
                    'value' => 'Staff limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'value',
                    'value' => '15',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_staff',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'value',
                    'value' => '15',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_inventory_location',
                    'key' => 'usage',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'usage',
                    'value' => '0',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","External/Affiliate Product"]',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => 'feature_product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'duration',
                    'value' => NULL,
                ], [
                    'package_subscription_id' => $subscription->id,
                    'type' => '',
                    'key' => 'trial',
                    'value' => '0',
                ]
            ]);
        }
    }
}
