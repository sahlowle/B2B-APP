<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 19-02-2025
 */

namespace App\Http\Resources;

use App\Enums\ProductType;
use Illuminate\Http\Resources\Json\JsonResource;

class PosProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        $salePrice = $this->getSalePrice();
        $regularPrice = $this->getPrice();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'type' => $this->type,
            'available_from' => $this->available_from,
            'available_to' => $this->available_to,
            'manage_stocks'  => $this->isStockManageable(),
            'stock_quantity' => $this->getStockQuantity(),
            'stock_status' => $this->getStockStatus(),
            'stock_hide' => $this->meta_hide_stock,
            'is_show_stock_status' => $this->isShowStockStatus(),
            'is_show_stock_quantity' => $this->type == ProductType::$Variable ? false : $this->isShowStockQuantity(),
            'backorders' => $this->isAllowBackorder(),
            'critical_stock_quantity' => $this->meta_stock_threshold,
            'featured_image_medium' =>  $this->getFeaturedImage('medium'),
            'sale_price' => $salePrice,
            'sale_price_formatted' => $this->displayPrice($salePrice),
            'sale_from' => $this->sale_from,
            'sale_to' => $this->sale_to,
            'status' => $this->status,
            'regular_price' => $regularPrice,
            'regular_price_formatted' => $this->displayPrice($regularPrice),
        ];
    }

    /**
     * Display price
     *
     * @param  mixed  $price
     * @return string|null
     */
    private function displayPrice($price)
    {
        if (is_array($price)) {
            return formatNumber($price[0]) . ' - ' . formatNumber($price[1]);
        }

        if ($price) {
            return formatNumber($price);
        }

        return null;
    }
}
