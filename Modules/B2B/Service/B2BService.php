<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 01-03-2023
 */

namespace Modules\B2B\Service;

use Cart;

class B2BService
{
    /**
     * get object
     *
     * @return AddToCartService
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new B2BService;
        }

        return self::$instance;
    }

    /**
     * add to cart price customization
     */
    public function addToCartCustomization($product, $variation = null, $price = 0): array
    {
        $cartOldPrice = $price;
        if ($product->isSimpleProduct() && $product->isEnableB2B()) {
            $existCartData = Cart::cartCollection()->where('id', $product->id)->first();
            $qty = request()->qty ?? 1;
            $qty = ! empty($existCartData) ? $qty + $existCartData['quantity'] : $qty;
            $price = self::getB2BPrice($price, $qty, $product->getB2BData(), ! empty($existCartData) ? 1 : 0, $product->id);
            $cartOldPrice = ! empty($existCartData) ? $existCartData['price'] : $cartOldPrice;
        } elseif ($product->isVariableProduct() && $variation->isEnableB2B()) {
            $existCartData = Cart::cartCollection()->where('id', $variation->id)->first();
            $qty = request()->qty ?? 1;
            $qty = ! empty($existCartData) ? $qty + $existCartData['quantity'] : $qty;
            $price = self::getB2BPrice($price, $qty, $variation->getB2BData(), ! empty($existCartData) ? 1 : 0, $variation->id);
            $cartOldPrice = ! empty($existCartData) ? $existCartData['price'] : $cartOldPrice;
        } elseif ($product->isVariableProduct() && $product->isEnableB2B()) {
            $existCartData = Cart::cartCollection()->where('id', $variation->id)->first();
            $qty = request()->qty ?? 1;
            $qty = ! empty($existCartData) ? $qty + $existCartData['quantity'] : $qty;
            $price = self::getB2BPrice($price, $qty, $product->getB2BData(), ! empty($existCartData) ? 1 : 0, $variation->id);
            $cartOldPrice = ! empty($existCartData) ? $existCartData['price'] : $cartOldPrice;
        }

        return [
            'price' => $price,
            'cartOldPrice' => $cartOldPrice,
        ];
    }

    /**
     * check if B2B price active or not
     */
    public function isB2BPriceActive($product, $variation = null, $cartOldPrice = 0): bool
    {
        return $product->isSimpleProduct() && $product->isEnableB2B() ||
        $product->isVariableProduct() && $variation->isEnableB2B() && $this->isB2BPriceApply($variation->id, $cartOldPrice) ||
        $product->isVariableProduct() && $product->isEnableB2B() && $this->isB2BPriceApply($variation->id, $cartOldPrice);
    }

    /**
     * find is b2b price apply or not
     *
     * @param  $productPrice
     * @param  $b2bPrice
     */
    public function isB2BPriceApply($id = null, $oldPrice = 0): bool
    {
        $cartOldPrice = 0;
        $cartNewPrice = 0;
        $cartOld = Cart::cartCollection()->where('id', $id)->first();

        if (! empty($cartOld) && $oldPrice == 0) {
            $cartOldPrice = $cartOld['price'];
            Cart::checkCartData();
        } else {
            $cartOldPrice = $oldPrice;
        }

        $cartNew = Cart::cartCollection()->where('id', $id)->first();

        if (! empty($cartNew)) {
            $cartNewPrice = $cartNew['price'];
        }

        return $cartOldPrice != $cartNewPrice;

    }

    /**
     * get item price when cart checking
     *
     * @return int|mixed
     */
    public function getItemPrice($item, $itemPrice, $qty = 1)
    {
        if ($item->isEnableB2B()) {
            $itemPrice = self::getB2BPrice($itemPrice, $qty, $item->getB2BData(), 1, $item->id);
        } elseif ($item->type == 'Variation' && $item->parentDetail->isEnableB2B()) {
            $itemPrice = self::getB2BPrice($itemPrice, $qty, $item->parentDetail->getB2BData(), 1, $item->id);
        }

        return $itemPrice;
    }

    /**
     * get B2B price by matching B2B condition
     *
     * @return int|mixed
     */
    public static function getB2BPrice($price = 0, $qty = 1, $b2bData = [], $isCartExists = 0, $productId = null)
    {
        foreach ($b2bData as $b2b) {
            if ($qty >= $b2b['min_qty'] && $qty <= $b2b['max_qty'] && ! empty($b2b['price'])) {
                $price = $b2b['price'];
                break;
            }
        }

        if ($isCartExists) {
            Cart::updateCartProperty($productId, 'price', $price);
        }

        return $price;
    }
}
