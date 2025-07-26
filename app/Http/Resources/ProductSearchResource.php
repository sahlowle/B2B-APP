<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Md Abdur Rahaman Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 28-10-2021
 */

namespace App\Http\Resources;

use App\Enums\ProductType;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        $userId = null;
        if (! isset($request->user_id) && isset(auth()->guard('api')->user()->id)) {
            $userId = auth()->guard('api')->user()->id;
        } elseif (isset($request->user_id)) {
            $userId = $request->user_id;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'type' => $this->type,
            'summary' => $this->summary,
            'categories' => $this->getCategoryName(),
            'featured' => $this->featured,
            'featured_image_on_settings' =>  $this->getFeaturedImage(preference('front_image_resolution', 'medium')),
            'review_average' => $this->review_average,
            'offerCheck' => $this->offerCheck(),
            'discountPercent' => $this->getDiscountAmount(),
            'is_wishlisted' => $this->isWishlist($this->id, $userId),
            'is_compared' => isCompared($this->id, $userId),
            'isOutOfStock' => $this->isOutOfStock(),
            'prices' => $this->filterPriceRange(),
            'stock_quantity' => $this->getStockQuantity(),
            'stock_status' => $this->getStockStatus(),
            'is_show_stock_status' => $this->isShowStockStatus(),
            'is_show_stock_quantity' => $this->type == ProductType::$Variable ? false : $this->isShowStockQuantity(),
        ];
    }

    /**
     * filterPriceRange
     */
    protected function filterPriceRange(): array
    {
        // Step 1: Fetch all product IDs, including variations & grouped products
        $allProductIds = $this->getAllRelatedProductIds();

        // Step 2: Fetch only necessary product data (avoid fetching entire model)
        $products = \DB::table('products')
            ->whereIn('id', $allProductIds)
            ->select('id', 'regular_price', 'sale_price', 'sale_from', 'sale_to', 'available_from', 'available_to')
            ->get();
        $currentDate = Carbon::now();

        $prices = [];
        // Step 3: Process pricing logic in a single loop
        foreach ($products as $product) {
            $regularPrice = $product->regular_price;
            $salePrice = $product->sale_price;
            $saleFrom = $product->sale_from ? Carbon::parse($product->sale_from) : null;
            $saleTo = $product->sale_to ? Carbon::parse($product->sale_to) : null;
            $availableFrom = $product->available_from ? Carbon::parse($product->available_from) : null;
            $availableTo = $product->available_to ? Carbon::parse($product->available_to) : null;

            // Skip products outside the availability period
            if (($availableFrom && $currentDate < $availableFrom) || ($availableTo && $currentDate > $availableTo)) {
                continue;
            }

            // Use sale price if it's within the sale period and not zero

            if ($salePrice > 0 && (! $saleFrom || $currentDate >= $saleFrom) && (! $saleTo || $currentDate <= $saleTo)) {
                $prices[] = $salePrice;
                if (! in_array($this->type, [ProductType::$Simple, ProductType::$External])) {
                    continue;
                }
            }

            // Fallback to regular price if sale price isn't valid
            if ($regularPrice > 0) {
                $prices[] = $regularPrice;
            }
        }

        if (count($prices) == 0) {
            $prices[] = 0;
        }

        // Step 4: Store min/max price range (avoid returning zero)
        return [min($prices), max($prices)];
    }

    /**
     * Optimized method to get all related product IDs efficiently
     */
    protected function getAllRelatedProductIds()
    {
        $processedGroupIds = [];
        $allProductIds = [$this->id];

        do {
            // Fetch products and variations in one query
            $column = ($this->type == ProductType::$Variable) ? 'parent_id' : 'id';

            $query = \DB::table('products')
                ->select('id', 'parent_id', 'type')
                ->whereIn($column, $allProductIds);

            if ($this->type !== ProductType::$Variable) {
                $query->orWhereIn('parent_id', $allProductIds);
            }

            $query->get();

            $newProductIds = $query->pluck('id')->toArray();

            // Find grouped product IDs
            $groupProductIds = $query->where('type', 'Grouped Product')->pluck('id')->toArray();

            // Fetch grouped products from product_meta in a single query
            if (! empty($groupProductIds)) {
                $groupedProductIds = \DB::table('products_meta')
                    ->whereIn('product_id', $groupProductIds)
                    ->where('key', 'meta_grouped_products')
                    ->pluck('value')
                    ->toArray();

                // Convert comma-separated or JSON values into arrays
                $groupedProductIds = array_unique(array_merge([], ...array_map(fn ($v) => json_decode($v, true) ?: explode(',', $v), $groupedProductIds)));

                $allProductIds = array_diff(array_merge($newProductIds, $groupedProductIds), $processedGroupIds);
            } else {
                $allProductIds = array_diff($newProductIds, $processedGroupIds);
            }

            $processedGroupIds = array_merge($processedGroupIds, $allProductIds);
        } while (! empty($allProductIds));

        return $processedGroupIds;
    }
}
