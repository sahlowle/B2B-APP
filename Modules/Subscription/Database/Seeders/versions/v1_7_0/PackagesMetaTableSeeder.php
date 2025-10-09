<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use Illuminate\Database\Seeder;
use Modules\Subscription\Entities\{
    Package, PackageMeta
};

class PackagesMetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $package = Package::where(['code' => 'p-free'])->first();

        if ($package) {
            PackageMeta::insertOrIgnore([
                [
                    'package_id' => $package->id,
                    'feature' => '',
                    'key' => 'duration',
                    'value' => NULL
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title',
                    'value' => 'Product limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'value',
                    'value' => '10'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'description',
                    'value' => 'Product description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title',
                    'value' => 'Staff limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'value',
                    'value' => '5'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'value',
                    'value' => '5'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","Grouped Product","External/Affiliate Product"]',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ]
            ]);
        }

        $package = Package::where(['code' => 'p-starter'])->first();

        if ($package) {
            PackageMeta::insertOrIgnore([
                [
                    'package_id' => $package->id,
                    'feature' => '',
                    'key' => 'duration',
                    'value' => NULL,
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'value',
                    'value' => '50',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title',
                    'value' => 'Staff limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'value',
                    'value' => '10'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'value',
                    'value' => '10'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","Grouped Product","External/Affiliate Product"]',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ]
            ]);
        }

        $package = Package::where(['code' => 'p-premium'])->first();

        if ($package) {
            PackageMeta::insertOrIgnore([
                [
                    'package_id' => $package->id,
                    'feature' => '',
                    'key' => 'duration',
                    'value' => 3,
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'value',
                    'value' => '100',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title',
                    'value' => 'Staff limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'value',
                    'value' => '15'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'value',
                    'value' => '15'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","Grouped Product","External/Affiliate Product"]',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ]
            ]);
        }

        $package = Package::where(['code' => 'p-platinum'])->first();

        if ($package) {
            PackageMeta::insertOrIgnore([
                [
                    'package_id' => $package->id,
                    'feature' => '',
                    'key' => 'duration',
                    'value' => 3,
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'type',
                    'value' => 'number',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_value_fixed',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title',
                    'value' => 'Product limit',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'title_position',
                    'value' => 'before',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'value',
                    'value' => '200',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'description',
                    'value' => 'Product description will be here',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title',
                    'value' => 'Staff limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'value',
                    'value' => '20'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'description',
                    'value' => 'Staff description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'staff',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'type',
                    'value' => 'number'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_value_fixed',
                    'value' => '0'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title',
                    'value' => 'Location limit'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'title_position',
                    'value' => 'before'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'value',
                    'value' => '20'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'description',
                    'value' => 'Location description will be here'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'is_visible',
                    'value' => '1'
                ], [
                    'package_id' => $package->id,
                    'feature' => 'inventory_location',
                    'key' => 'status',
                    'value' => 'Active',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'value',
                    'value' => '0',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'title',
                    'value' => 'Report Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'report',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'title',
                    'value' => 'Ticket Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'ticket',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'title',
                    'value' => 'Coupon Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'coupon',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'title',
                    'value' => 'Export Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'export_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'value',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'title',
                    'value' => 'Import Product Service',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'import_product',
                    'key' => 'type',
                    'value' => 'bool',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_visible',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'value',
                    'value' => '["Simple Product","Variable Product","Grouped Product","External/Affiliate Product"]',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'title',
                    'value' => 'Product variation',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'is_value_fixed',
                    'value' => '1',
                ], [
                    'package_id' => $package->id,
                    'feature' => 'product_variation',
                    'key' => 'type',
                    'value' => 'multi-select',
                ]
            ]);
        }
    }
}
