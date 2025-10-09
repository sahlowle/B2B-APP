<?php

/**
 * @package PackageService
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

 namespace Modules\Subscription\Services;

use Modules\Subscription\Traits\SubscriptionTrait;
use Modules\Subscription\Entities\{
    Package, PackageMeta
};

 class PackageService
 {
    use SubscriptionTrait;

    /**
     * service name
     * @var string
     */
    public string|null $service;

    /**
     * Initialize
     *
     * @param string $service
     * @return void
     */
    public function __construct($service = null)
    {
        $this->service = $service;

        if (is_null($service)) {
            $this->service = __('Plan');
        }
    }

    /**
     * Store Package
     *
     * @param array $data
     * @return array
     */
     public function store(array $data): array
     {
        try {
            \DB::beginTransaction();
            if ($package = Package::create($data)) {
                $this->storeMeta($data['meta'], $package->id);
                \DB::commit();

                return $this->saveSuccessResponse();
            }
        } catch (\Exception $e) {
            \DB::rollback();

            return ['status' => $this->failStatus, 'message' => $e->getMessage()];
        }

        return $this->saveFailResponse();
     }

    /**
     * Update Package
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(array $data, int $id): array
    {
        $package = Package::find($id);

        if (is_null($package)) {
            return $this->notFoundResponse();
        }

        try {
            \DB::beginTransaction();

            if ($package->update($data)) {
                $package->metaData()->delete();

                $this->storeMeta($data['meta'], $package->id);
                \DB::commit();

                return $this->saveSuccessResponse();
            }
        } catch (\Exception $e) {
            \DB::rollback();

            return ['status' => $this->failStatus, 'message' => $e->getMessage()];
        }

        return $this->saveFailResponse();
    }

    /**
     * Delete Package
     *
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        $package = Package::find($id);

        if (is_null($package)) {
            return $this->notFoundResponse();
        }

        if ($package->delete()) {
            return $this->deleteSuccessResponse();
        }

        return $this->deleteFailResponse();
    }

    /**
     * Package Features
     *
     * @return array
     */
    public static function features(): array
    {
        /**
         * Type will be number, bool, text, select, multi-select
         * Type radio will show as a switch
         * Value for select or multi-select => ['a' => 'A', 'b' => 'B']
         * title_position will be before, after
         * When added new key and value it may need to add in blade file
         */
        $data = [
            "product" => [
                "type" => "number",
                "value" => preference('demo_product_limit', 50),
                "is_value_fixed" => 1,
                "title" => __("Product limit"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "product_variation" => [
                "type" => "multi-select",
                "value" => [
                    'Simple Product' => 'Simple Product',
                    'Variable Product' => 'Variable Product',
                    'Grouped Product' => 'Grouped Product',
                    'External/Affiliate Product' => 'External/Affiliate Product',
                ],
                "is_value_fixed" => 1,
                "title" => __("Product variation"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "import_product" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Import Product Service"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "export_product" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Export Product Service"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "staff" => [
                "type" => "number",
                "value" => preference('demo_product_limit', 5),
                "is_value_fixed" => 1,
                "title" => __("Vendor Staff limit"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],

            // "inventory_location" => [
            //     "type" => "number",
            //     "value" => preference('location_limit', 5),
            //     "is_value_fixed" => 1,
            //     "title" => __("Inventory Location limit"),
            //     "title_position" => "before",
            //     "is_visible" => 1,
            //     "usage" => 0
            // ],
        
            // 👇 الميزات الجديدة
            "show_company_description" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Show company description"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "show_visit_stats" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Show visit stats"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "show_profile" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Show profile"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "upload_catalog" => [
                "type" => "number",
                "value" => 10,
                "is_value_fixed" => 1,
                "title" => __("Upload catalog"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "seo_optimization" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("SEO optimization"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "post_news" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Post news inside the platform"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "rfq_priority" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("RFQ priority"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ],
            "buyer_direct_chat" => [
                "type" => "bool",
                "value" => 1,
                "is_value_fixed" => 1,
                "title" => __("Buyer direct chat"),
                "title_position" => "before",
                "is_visible" => 1,
                "usage" => 0
            ]
        ];
        

        return apply_filters('add_plan_feature', $data);
    }

    /**
     * Edit Feature
     *
     * @param Package $package
     * @param bool $option
     * @return \App\Lib\MiniCollection
     */
    public static function editFeature(Package $package, $option = true)
    {
        $features = $package->metaData()->whereNot('feature', '')->get();

        $formatFeature = [];

        foreach ($features as $data) {
            $formatFeature[$data->feature][$data->key] = $data->value;
        }

        if (!$option) {
            return $formatFeature;
        }

        return miniCollection($formatFeature, $option);
    }

    /**
     * Store meta data
     *
     * @param array $data
     * @param int $package_id
     * @return void
     */
    private function storeMeta($data, $package_id): void
    {
        $meta = [];
        foreach ($data as $key => $metaData) {
            foreach ($metaData as $k => $value) {
                $value = !is_array($value) ? $value : json_encode($value);

                $meta[] = [
                    'package_id' => $package_id,
                    'feature' => is_int($key) ? null : $key,
                    'key' => $k,
                    'value' => $value == 0 || !empty($value) ? $value : static::features()[$key][$k]
                ];
            }
        }

        PackageMeta::upsert($meta, ['package_id', 'features', 'key']);
    }

    /**
     * Package status list
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            'Active', 'Pending', 'Inactive', 'Expired', 'Paused', 'Cancel'
        ];
    }
 }

