<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 05-09-2022
 */

namespace App\Traits\Order;

use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Resources\ProductDetailResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderMeta;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Services\Actions\Facades\ProductActionFacade as ProductAction;
use App\Services\Product\AddToCartService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\Coupon\Http\Models\Coupon;
use Modules\Coupon\Http\Models\CouponRedeem;

trait OrderTrait
{
    /**
     * Access meta data directly from the model object
     *
     * OVERRIDING 'Model' default '__get()' method
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes['id'])) {
            return parent::__get($name);
        }
        $val = parent::__get($name);

        if ($val != null) {
            return $val;
        }

        if (! $this->metaFetched) {
            $this->getMeta();
        }
        if (isset($this->metaArray[$name])) {
            return $this->metaArray[$name];
        }
        if (isset($this->metaArray['meta_' . $name])) {
            return $this->metaArray['meta_' . $name];
        }

        return null;
    }

    /**
     * Get value attribute mutator
     *
     * @return array|string $value
     */
    public function getValueAttribute()
    {
        $value = $this->attributes['value'];
        if ($this->attributes['type'] == 'array') {
            return json_decode($value, 1);
        }

        return $value;
    }

    /**
     * Get metadata array
     *
     * @return array
     */
    public function getMeta()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->getMetaCollection();
        }
        $this->metaArray = $this->relations['metadata']->pluck('value', 'key')->toArray();
        $this->metaFetched = true;

        return $this->metaArray;
    }

    /**
     * Return metadata collection of the product
     *
     * @return Collection
     */
    public function getMetaCollection()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->metadata()->get();
        }

        return $this->relations['metadata'];
    }

    /**
     * Format order address
     *
     * @param  object  $order
     * @param  string  $prefix
     * @return object address
     */
    private function formatAddress($prefix)
    {
        return $this->metadata()->where('key', 'like', $prefix . '%')
            ->get()
            ->map(function ($order) use ($prefix) {
                $order->key = str_replace($prefix, '', $order->key);

                return $order;
            })->pluck('value', 'key');
    }

    /**
     * Get specific order shipping address
     *
     * @return collection
     */
    public function getShippingAddress()
    {
        return miniCollection($this->formatAddress('shipping_address_')->toArray());
    }

    /**
     * Get specific order billing address
     *
     * @return collection
     */
    public function getBillingAddress()
    {
        return miniCollection($this->formatAddress('billing_address_')->toArray());
    }

    public function updateOrderDownloadData($data = [])
    {
        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'download_data'],
            ['type' => 'array', 'value' => $data]
        );
    }

    /**
     * grant access
     *
     * @return array|int[]
     */
    public function grantAccess($request = null)
    {
        $downloadData = $this->download_data;
        $orderDownloadData = [];
        $lastId = 1;

        if (! empty($downloadData)) {
            foreach ($downloadData as $data) {
                $orderDownloadData[] = [
                    'id' => $data['id'],
                    'download_limit' => $data['download_limit'],
                    'download_expiry' => $data['download_expiry'],
                    'link' => $data['link'],
                    'download_times' => $data['download_times'],
                    'is_accessible' => $data['is_accessible'],
                    'vendor_id' => $data['vendor_id'],
                    'name' => $data['name'],
                    'f_name' => $data['f_name'],
                ];
                $lastId = (int) $data['id'];
            }
        }

        if (isset($request->product_ids) && is_array($request->product_ids)) {
            foreach ($request->product_ids as $productId) {
                $product = Product::where('id', $productId)->first();
                $downloadable = [];
                $downloadableJs = [];
                if ($product->meta_downloadable == 1) {
                    foreach ($product->meta_downloadable_files as $files) {
                        if (isset($files['url']) && ! empty($files['url'])) {
                            $url = urlSlashReplace($files['url'], ['\/', '\\']);
                            $lastId++;
                            $downloadable[] = [
                                'id' => $lastId,
                                'download_limit' => $product->meta_download_limit,
                                'download_expiry' => $product->meta_download_expiry,
                                'link' => $url,
                                'download_times' => 0,
                                'is_accessible' => 1,
                                'vendor_id' => $product->vendor_id,
                                'name' => $product->name,
                                'f_name' => $files['name'],
                            ];
                            $downloadableJs[] = [
                                'id' => $lastId,
                                'download_limit' => $product->meta_download_limit,
                                'download_expiry' => $product->meta_download_expiry,
                                'link' => route('site.downloadProduct', ['link' => \Crypt::encrypt($url), 'file' => $lastId . ',' . $this->id]),
                                'download_times' => 0,
                                'is_accessible' => 1,
                                'vendor_id' => $product->vendor_id,
                                'name' => $product->name,
                                'f_name' => $files['name'],
                            ];
                        }
                    }
                }

                $downloadable = (array_merge($orderDownloadData, $downloadable));
                $downloadableJs = (array_merge($orderDownloadData, $downloadableJs));

                $this->updateOrderDownloadData($downloadable);
            }
        }

        if (isset($downloadableJs)) {
            return ['status' => 1, 'data' => $downloadableJs];
        }

        return ['status' => 0];
    }

    /**
     * revoke access
     *
     * @return mixed
     */
    public function revokeAccess($request = null)
    {
        $orderMeta = $this->metadata->where('key', 'download_data')->first();

        if (! empty($orderMeta)) {
            $data['status'] = 1;
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Data')]);
            $downloadArray = [];

            foreach ($orderMeta->value as $download) {
                $isAccessible = $download['is_accessible'];
                if ($download['id'] == $request->data['file_id']) {
                    $isAccessible = 0;
                }
                $downloadArray[] = [
                    'id' => $download['id'],
                    'download_limit' => $download['download_limit'],
                    'download_expiry' => $download['download_expiry'],
                    'link' => $download['link'],
                    'download_times' => $download['download_times'],
                    'is_accessible' => $isAccessible,
                    'vendor_id' => $download['vendor_id'],
                    'name' => $download['name'],
                    'f_name' => $download['f_name'],
                ];
            }

            $this->updateOrderDownloadData($downloadArray);
        }

        return $data;
    }

    /**
     * merge data
     *
     * @return void
     */
    public function downloadDataMerge($ajaxData = [], $vendorId = null)
    {
        $downloadArray = [];
        $downloadData = $this->download_data;
        $orderDownloadData = [];

        foreach ($ajaxData as $key => $download) {
            $downloadArray[$download[0]->id] = [
                'id' => $download[0]->id,
                'download_limit' => $download[1]->download_limit,
                'download_expiry' => $download[2]->download_expiry,
                'link' => $download[3]->link,
                'download_times' => $download[4]->download_times,
                'is_accessible' => $download[5]->is_accessible,
                'vendor_id' => $download[6]->vendor_id,
                'name' => $download[7]->name,
                'f_name' => $download[8]->f_name,
            ];
        }

        if (! empty($downloadData)) {
            foreach ($downloadData as $data) {
                $orderDownloadData[] = [
                    'id' => $data['id'],
                    'download_limit' => isset($downloadArray[$data['id']]) ? $downloadArray[$data['id']]['download_limit'] : $data['download_limit'],
                    'download_expiry' => isset($downloadArray[$data['id']]) ? $downloadArray[$data['id']]['download_expiry'] : $data['download_expiry'],
                    'link' => $data['link'],
                    'download_times' => $data['download_times'],
                    'is_accessible' => $data['is_accessible'],
                    'vendor_id' => $data['vendor_id'],
                    'name' => $data['name'],
                    'f_name' => $data['f_name'],
                ];
            }
        }

        $this->updateOrderDownloadData($orderDownloadData);
    }

    /**
     * check valid file
     *
     * @return bool
     */
    public function checkValidFile($data = [])
    {
        $flag = false;
        $daysAfterCreate = $this->created_at->diffInDays(\Carbon\Carbon::now());

        if (
            $data['download_times'] < $data['download_limit'] && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '' && $daysAfterCreate <= $data['download_expiry']
            || $data['download_times'] < $data['download_limit'] && $data['download_expiry'] == ''
            || $data['download_times'] < $data['download_limit'] && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '' && $data['download_expiry'] == ''
            || $data['download_limit'] == '' && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '-1' && $data['download_expiry'] == ''
            || $data['download_limit'] == '-1' && $daysAfterCreate <= $data['download_expiry']
        ) {
            $flag = true;
        }

        return $flag;
    }

    public function updateBillingData($data)
    {
        foreach ($data as $key => $value) {
            OrderMeta::updateOrCreate(
                ['order_id' => $this->id, 'key' => 'billing_address_' . $key],
                ['type' => 'string', 'value' => $value]
            );
        }
    }

    public function updateShippingData($data)
    {
        foreach ($data as $key => $value) {
            OrderMeta::updateOrCreate(
                ['order_id' => $this->id, 'key' => $key],
                ['type' => 'string', 'value' => $value]
            );
        }
    }

    /**
     * add product
     */
    public function orderCustomization($request)
    {
        $existsProducts = $this->orderDetails->pluck('product_id')->toArray();
        $detailData = [];

        try {
            \DB::beginTransaction();
            foreach ($request->product_id as $index => $productId) {
                $orderStatus = OrderStatus::getAll()->where('slug', 'pending-payment')->first();
                if (! in_array($productId, $existsProducts)) {
                    $request['id'] = $productId;

                    $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);

                    if ($product->type == 'Variation') {
                        $request['variation_id'] = $product->id;
                        $request['id'] = $product->parentDetail->id;
                        $product = ProductAction::execute('getProductWithAttributeAndVariations', $request);
                    }

                    $data = (new ProductDetailResource($product))->toArray(null);
                    $variation = null;

                    if ($product->isVariableProduct()) {
                        $variation = $data['variations']->where('id', $request->variation_id)->first();
                    }

                    $salePrice = $product->isVariableProduct() ? $variation->sale_price : $product->sale_price;
                    $regularPrice = $product->isVariableProduct() ? $variation->regular_price : $product->regular_price;

                    $offerFlag = $product->isVariableProduct() ? $variation->offerCheck() : $product->offerCheck();
                    $price = $offerFlag ? $salePrice : $regularPrice;
                    $cartService = new AddToCartService();
                    $this->total = $this->total + ($price * $request->product_qty[$index]);
                    $this->save();

                    if (is_null($price)) {
                        \DB::rollBack();

                        return ['status' => false, 'message' => __('Nullable product price will not added.')];
                    }

                    if (! $product->checkInventory($request->product_qty[$index], $product->meta_backorder, $orderStatus->slug)) {
                        if (! isset($request->enable_quote_stock_out) || $request->enable_quote_stock_out != 1) {
                            \DB::rollBack();

                            return ['status' => false, 'message' => __('Product stock is not available!')];
                        }
                    }

                    $detailData[] = [
                        'product_id' => $product->isVariableProduct() ? $variation->id : $data['id'],
                        'parent_id' => $product->isVariableProduct() ? $variation->parent_id : null,
                        'order_id' => $this->id,
                        'vendor_id' => isset($product->vendor) ? $data['vendor_id'] : null,
                        'shop_id' => $data['shop_id'],
                        'product_name' => $data['name'],
                        'price' => $price,
                        'quantity_sent' => 0,
                        'quantity' => $request->product_qty[$index],
                        'order_status_id' => $orderStatus->id,
                        'payloads' => $product->isVariableProduct() ? $cartService->getAttributeWithValue($variation, $product->getVariationAttributes(), $data['attribute_values']) : null,
                        'order_by' => $productId,
                        'shipping_charge' => null,
                        'tax_charge' => 0,
                        'is_stock_reduce' => $product->isStockReduce($orderStatus->slug),
                        'estimate_delivery' => $product->type == 'Variation' ? $product->parentDetail->estimated_delivery : $product->estimated_delivery,
                    ];
                } elseif (in_array($productId, $existsProducts)) {
                    $updateQty = OrderDetail::where('order_id', $this->id)->where('product_id', $productId)->first();
                    $productDetail = $updateQty->product;

                    if (! $productDetail->checkInventory($request->product_qty[$index], $productDetail->meta_backorder, $orderStatus->slug)) {
                        if (! isset($request->enable_quote_stock_out) || $request->enable_quote_stock_out != 1) {
                            \DB::rollBack();

                            return ['status' => false, 'message' => __('Product stock is not available!')];
                        }
                    }

                    $qty = $request->product_qty[$index] + $updateQty->quantity;
                    $updateQty->quantity = $qty;
                    $updateQty->save();

                    $this->total = $this->total + ($updateQty->price * $request->product_qty[$index]);
                    $this->save();
                }

            }

            (new OrderDetail())->store($detailData);

            if (isset($product)) {
                $this->customizeCustomTax($this, $product->isVariableProduct() ? $variation->id : $data['id']);
            }
            \DB::commit();

            return ['status' => true, 'message' => __('Saved Successfully.')];
        } catch (\Exception $e) {
            \DB::rollBack();

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    protected function customizeCustomTax($order, $newProductId)
    {
        $orderMeta = $order->metadata->where('key', 'meta_custom_tax')->first();
        $productIds = $order->orderDetails->pluck('product_id')->toArray();
        $key = 0;
        $data = [];
        $innerData = [];
        $feeInnerData = [];
        $existsData = [];
        $data1 = [];
        $data2 = [];
        $lastKey = 0;

        if (! empty($orderMeta)) {

            $taxData = json_decode($orderMeta->value);

            foreach ($taxData->product as $key1 => $products) {
                $innerData = [];
                foreach ($products as $key3 => $product) {
                    $innerData[$key3] = [
                        'product_id' => $product->product_id,
                        'tax' => $product->tax,
                    ];

                    $lastKey = $key3;
                }

                $innerData[isset($key3) ? $key3 + 1 : $lastKey++] = [
                    'product_id' => $newProductId,
                    'tax' => 0,
                ];

                $key = $key1;
                $data1[$key1] = $innerData;
            }

            if (isset($taxData->fee)) {
                foreach ($taxData->fee as $key2 => $fees) {
                    $feeInnerData = [];
                    foreach ($fees as $key4 => $fee) {
                        $feeInnerData[$key4] = [
                            'key' => $fee->key,
                            'tax' => $fee->tax,
                        ];
                    }

                    $data2[$key2] = $feeInnerData;
                }
            }
        }

        $data = [
            'product' =>  $data1,
            'fee' => $data2,
        ];

        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
            ['type' => 'string', 'value' => json_encode($data)]
        );

        return true;
    }

    /**
     * delete product
     */
    public function deleteProductFromOrder($request): bool
    {
        $orderDetails = OrderDetail::where('order_id', $this->id)->where('product_id', $request->delete_id)->first();
        $price = $orderDetails->price * $orderDetails->quantity;
        $taxCharge = $orderDetails->tax_charge;

        $this->tax_charge = $this->tax_charge - $taxCharge;
        $this->total = $this->total - ($price + $taxCharge);

        if ($orderDetails->is_stock_reduce == 1) {
            $orderDetails->product->incrementTotalStocks($orderDetails->quantity);
        }

        $this->save();
        $orderDetails->delete();

        $this->updatedCustomTaxFee($this);

        return true;

    }

    /**
     * update custom tax for product & fee
     *
     * @return true|void
     */
    public function updatedCustomTaxFee($order, $taxCalculations = false, $vendorOnly = false, $vendorId = null)
    {
        $order = Order::find($order->id);
        $orderMeta = $order->metadata->where('key', 'meta_custom_tax')->first();
        $customFee = $order->metadata->where('key', 'meta_custom_fee')->first();
        $customFee = collect(json_decode($customFee->value ?? null, true));
        $customFeeKey = $customFee->pluck('key')->toArray();

        if ($vendorOnly) {

            if (! is_null($vendorId)) {
                $productIds = $order->orderDetails->where('vendor_id', $vendorId)->pluck('product_id')->toArray();
            } else {
                $productIds = $order->orderDetails->where('vendor_id', session()->get('vendorId'))->pluck('product_id')->toArray();
            }

        } else {
            $productIds = $order->orderDetails->pluck('product_id')->toArray();
        }

        $data2 = [];
        $count = 0;
        $data1 = [];
        $totalCustomTax = 0;

        if (! empty($orderMeta)) {
            $taxData = json_decode($orderMeta->value);

            if (isset($taxData->fee)) {
                foreach ($taxData->fee as $key2 => $fees) {
                    $feeInnerData = [];
                    foreach ($fees as $key334 => $fee) {
                        if (in_array($fee->key, $customFeeKey)) {
                            $totalCustomTax += $fee->tax;
                            $feeInnerData[] = [
                                'key' => $fee->key,
                                'tax' => $fee->tax,
                            ];
                        }
                    }

                    $data2[$key2] = $feeInnerData;
                }
            }

            $innerData = [];

            foreach ($taxData->product as $key1 => $products) {
                $innerData = [];
                foreach ($products as $productKey => $product) {
                    if (in_array($product->product_id, $productIds)) {
                        $totalCustomTax += $product->tax;
                        $innerData[] = [
                            'product_id' => $product->product_id,
                            'tax' => $product->tax,
                        ];
                    }
                }

                $data1[$key1] = $innerData;
            }

            if (! $taxCalculations) {
                $data = [
                    'product' =>  $data1,
                    'fee' => $data2,
                ];

                OrderMeta::updateOrCreate(
                    ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
                    ['type' => 'string', 'value' => json_encode($data)]
                );

                return true;
            }

            return $totalCustomTax;
        }
    }

    /**
     * product price, qty, tax update
     * order recalculate
     *
     * @return true
     */
    public function updateProductValueFromOrder($request, $inputData)
    {
        $totalPrice = 0;
        $totalQty = 0;
        $totalTax = 0;

        try {
            \DB::beginTransaction();
            if (isset($inputData['product_price'])) {
                foreach ($inputData['product_price'] as $key => $price) {
                    $orderDetails = OrderDetail::where('order_id', $this->id)->where('product_id', $key)->first();
                    $oldQty = $orderDetails->quantity;
                    $orderDetails->price = $price;
                    $orderDetails->tax_charge = $inputData['product_tax'][$key];
                    $orderDetails->quantity = $inputData['product_qty'][$key];

                    if ($orderDetails->is_stock_reduce == 1 && $oldQty > $inputData['product_qty'][$key]) {
                        $orderDetails->product->incrementTotalStocks($oldQty - $inputData['product_qty'][$key]);
                    } elseif ($orderDetails->is_stock_reduce == 1 && $inputData['product_qty'][$key] > $oldQty) {
                        $orderQty = $inputData['product_qty'][$key] - $oldQty;

                        if ($orderDetails->product->getStockQuantity() >= $orderQty) {
                            $orderDetails->product->decrementTotalStocks($orderQty);
                        } else {
                            return ['status' => false, 'message' => __('Product stock is not available!')];
                        }
                    }

                    $orderDetails->save();

                }

                foreach ($this->orderDetails as $data) {
                    $totalPrice += ($data->price * $data->quantity);
                    $totalQty += $data->quantity;
                    $totalTax += $data->tax_charge;
                }
                $couponAmount = $this->couponRedeems->sum('discount_amount');
                $this->total = $totalPrice + $totalTax - $couponAmount;
                $this->total_quantity = $totalQty;
                $this->tax_charge = $totalTax;
                $this->save();
            }

            $this->editFee($this, $inputData);
            $this->editProductCustomTax($this, $inputData);
            (new VendorOrderController())->statusUpdate($inputData['status'] ?? null);
            \DB::commit();

            return ['status' => true, 'message' => __('Saved Successfully.')];
        } catch (\Exception $e) {
            \DB::rollBack();

            return ['status' => false, 'message' => $e->getMessage()];
        }

    }

    /**
     * edit product custom tax
     *
     * @return true|void
     */
    protected function editProductCustomTax($order, $inputData)
    {
        if (isset($inputData['custom_tax']) || isset($inputData['custom_tax_fee'])) {

            $orderMeta = $order->metadata->where('key', 'meta_custom_tax')->first();
            $customFee = $order->metadata->where('key', 'meta_custom_fee')->first();
            $customFee = ! empty($customFee->value) ? collect(json_decode($customFee->value, true)) : [];
            $customFeeKey = ! empty($customFee) ? $customFee->pluck('key')->toArray() : [];
            $productIds = $order->orderDetails->pluck('product_id')->toArray();
            $key = 0;
            $data = [];
            $innerData = [];
            $feeInnerData = [];
            $data1 = [];
            $data2 = [];
            $exceptData = [];
            $exceptDataFee = [];

            if (! empty($orderMeta)) {

                $taxData = json_decode($orderMeta->value);

                foreach ($taxData->product as $key1 => $products) {
                    $innerData = [];
                    $oldKey = [];
                    $oldKey[] = $key1;
                    foreach ($products as $productKey => $product) {
                        if (isset($inputData['custom_tax'][$product->product_id])) {

                            foreach ($inputData['custom_tax'][$product->product_id] as $updateProductKey => $updateProductTax) {
                                if ($updateProductKey == $key1) {
                                    $exceptData[] = $product->product_id;
                                    $innerData[$productKey] = [
                                        'product_id' => $product->product_id,
                                        'tax' => $inputData['custom_tax'][$product->product_id][$key1] ?? $product->tax,
                                    ];
                                }
                            }
                        }
                    }

                    $key = $key1;
                    $data1[$key1] = $innerData;

                    if (isset($taxData->fee)) {
                        foreach ($taxData->fee as $key2 => $fees) {//$key2 main key index
                            $feeInnerData = [];
                            foreach ($fees as $key334 => $fee) {// key335 sequence
                                if (isset($inputData['custom_tax_fee'][$fee->key])) {
                                    $feeInnerData[$key334] = [
                                        'key' => $fee->key,
                                        'tax' => $inputData['custom_tax_fee'][$fee->key][$key2],
                                    ];
                                } elseif (in_array($fee->key, $customFeeKey)) {
                                    $feeInnerData[$key334] = [
                                        'key' => $fee->key,
                                        'tax' => $fee->tax,
                                    ];
                                }

                                $data2[$key2] = $feeInnerData;
                            }
                        }
                    }

                }

                foreach ($taxData->product as $key1 => $products) {
                    $innerData = [];
                    foreach ($products as $productKey => $product) {
                        if (! in_array($product->product_id, $exceptData) && in_array($product->product_id, $productIds)) {

                            $innerData[$productKey] = [
                                'product_id' => $product->product_id,
                                'tax' => $product->tax,
                            ];

                            $data1[$key1] = array_merge($data1[$key1], $innerData);
                            $innerData = [];
                        }
                    }
                }

            }

            $data = [
                'product' =>  $data1,
                'fee' => $data2,
            ];

            OrderMeta::updateOrCreate(
                ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
                ['type' => 'string', 'value' => json_encode($data)]
            );

            return true;

        }
    }

    /**
     * edit fee
     *
     * @return true
     */
    public function editFee($order, $inputData)
    {
        $orderMeta = $order->metadata->where('key', 'meta_custom_fee')->first();
        $data = [];
        $key = [];

        if (isset($inputData['order_fee']) && ! empty($orderMeta)) {
            $feeData = json_decode($orderMeta->value);

            foreach ($feeData as $fee) {

                foreach ($inputData['order_fee'] as $key2 => $orderFee) {
                    if ($key2 == $fee->key) {
                        $key[] = $key2;
                        $data[] = [
                            'key' => $fee->key,
                            'amount' => $fee->amount,
                            'label' => $inputData['order_fee_lbl'][$key2],
                            'tax' => $inputData['order_fee_tax'][$key2],
                            'calculated_amount' => $orderFee,
                            'type' => $fee->type,
                        ];
                    }
                }
            }

            foreach ($feeData as $fee) {
                if (! in_array($fee->key, $key)) {
                    $data[] = [
                        'key' => $fee->key,
                        'amount' => $fee->amount,
                        'label' => $fee->label,
                        'tax' => $fee->tax,
                        'calculated_amount' => $fee->calculated_amount,
                        'type' => $fee->type,
                    ];
                }
            }

            OrderMeta::updateOrCreate(
                ['order_id' => $order->id, 'key' => 'meta_custom_fee'],
                ['type' => 'string', 'value' => json_encode($data)]
            );
        }

        return true;
    }

    /**
     * add fee
     *
     * @return true
     */
    public function addFeeInOrder($request)
    {
        $orderMeta = $this->metadata->where('key', 'meta_custom_fee')->first();
        $key = 1;
        $data = [];

        if (! empty($orderMeta)) {

            $feeData = json_decode($orderMeta->value);

            if (is_array($feeData) && count($feeData) > 0) {

                foreach ($feeData as $fee) {
                    $key = $fee->key;
                    $data[] = [
                        'key' => $fee->key,
                        'amount' => $fee->amount,
                        'label' => $fee->label,
                        'tax' => $fee->tax,
                        'calculated_amount' => $fee->calculated_amount,
                        'type' => $fee->type,
                    ];
                    $key++;
                }
            }
        }

        if ($request->fee_type == 'percent') {
            $total = ($request->amount * $this->total) / 100;
        } else {
            $total = $request->amount;
        }

        $data[] = [
            'key' => $key,
            'amount' => $request->amount,
            'label' => ! empty($request->remarks) ? $request->remarks : 'Fee',
            'tax' => 0,
            'calculated_amount' => $total,
            'type' => $request->fee_type,
        ];

        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'meta_custom_fee'],
            ['type' => 'string', 'value' => json_encode($data)]
        );

        $this->AddCustomTaxFeeInOrder($this, $key);

        return true;
    }

    protected function AddCustomTaxFeeInOrder($order, $lastInsertKey)
    {
        $orderMeta = $order->metadata->where('key', 'meta_custom_tax')->first();
        $productIds = $order->orderDetails->pluck('product_id')->toArray();
        $key = 0;
        $data = [];
        $innerData = [];
        $feeInnerData = [];
        $existsData = [];
        $data1 = [];
        $data2 = [];
        $lastKey = 0;

        if (! empty($orderMeta)) {

            $taxData = json_decode($orderMeta->value);

            $innerData = [];

            foreach ($taxData->product as $key1 => $products) {
                $innerData = [];
                foreach ($products as $productKey => $product) {
                    if (in_array($product->product_id, $productIds)) {
                        $innerData[] = [
                            'product_id' => $product->product_id,
                            'tax' => $product->tax,
                        ];
                    }
                }

                $data1[$key1] = $innerData;
            }

            if (isset($taxData->fee)) {
                foreach ($taxData->fee as $key2 => $fees) {
                    $feeInnerData = [];
                    foreach ($fees as $key4 => $fee) {
                        $feeInnerData[$key4] = [
                            'key' => $fee->key,
                            'tax' => $fee->tax,
                        ];
                    }

                    $feeInnerData[isset($key4) ? $key4 + 1 : $lastKey++] = [
                        'key' => $lastInsertKey,
                        'tax' => 0,
                    ];

                    $data2[$key2] = $feeInnerData;
                }
            }
        }

        $data = [
            'product' =>  $data1,
            'fee' => $data2,
        ];

        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
            ['type' => 'string', 'value' => json_encode($data)]
        );

        return true;
    }

    /**
     * delete feee
     *
     * @return true|void
     */
    public function deleteFeeFromOrder($request)
    {
        $orderMeta = $this->metadata->where('key', 'meta_custom_fee')->first();
        $data = [];

        if (! empty($orderMeta)) {
            $feeData = json_decode($orderMeta->value);

            if (is_array($feeData) && count($feeData) > 0) {
                foreach ($feeData as $fee) {
                    $key = $fee->key;
                    if ($key != $request->delete_id) {
                        $data[] = [
                            'key' => $fee->key,
                            'amount' => $fee->amount,
                            'label' => $fee->label,
                            'tax' => $fee->tax,
                            'calculated_amount' => $fee->calculated_amount,
                            'type' => $fee->type,
                        ];
                    }
                }
            }

            OrderMeta::updateOrCreate(
                ['order_id' => $this->id, 'key' => 'meta_custom_fee'],
                ['type' => 'string', 'value' => json_encode($data)]
            );

            $this->updatedCustomTaxFee($this);

            return true;
        }
    }

    /**
     * added custom tax
     *
     * @return true
     */
    public function addCustomTaxInOrder($request)
    {
        $orderMeta = $this->metadata->where('key', 'meta_custom_tax')->first();
        $orderMetaFee = $this->metadata->where('key', 'meta_custom_fee')->first();
        $orderMetaFee = ! empty($orderMetaFee->value) ? json_decode($orderMetaFee->value) : [];
        $productIds = $this->orderDetails->pluck('product_id')->toArray();
        $key = 0;
        $data = [];
        $innerData = [];
        $feeInnerData = [];
        $data1 = [];
        $data2 = [];

        if (! empty($orderMeta)) {

            $taxData = json_decode($orderMeta->value);

            foreach ($taxData->product as $key1 => $products) {
                $innerData = [];
                foreach ($products as $key3 => $product) {
                    $innerData[$key3] = [
                        'product_id' => $product->product_id,
                        'tax' => $product->tax,
                    ];
                }

                $key = $key1;
                $data1[$key1] = $innerData;
            }

            $key++;

            if (isset($taxData->fee)) {
                foreach ($taxData->fee as $key2 => $fees) {
                    $feeInnerData = [];
                    foreach ($fees as $key4 => $fee) {
                        $feeInnerData[$key4] = [
                            'key' => $fee->key,
                            'tax' => $fee->tax,
                        ];
                    }

                    $data2[$key2] = $feeInnerData;
                }
            }
        }

        $innerData = [];
        foreach ($productIds as $id) {
            $innerData[] = [
                'product_id' => $id,
                'tax' => 0,
            ];
        }
        $feeInnerData = [];

        if (! empty($orderMetaFee)) {
            foreach ($orderMetaFee as $fee) {
                $feeInnerData[] = [
                    'key' => $fee->key,
                    'tax' => 0,
                ];
            }
        }

        $data = [
            'product' =>  array_merge($data1, [
                $key => $innerData,
            ]),
            'fee' => array_merge($data2, [
                $key => $feeInnerData,
            ]),
        ];

        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
            ['type' => 'string', 'value' => json_encode($data)]
        );

        return true;
    }

    public function deleteCustomTaxFromOrder($request)
    {
        $orderMeta = $this->metadata->where('key', 'meta_custom_tax')->first();
        $key = 0;
        $data = [];
        $innerData = [];
        $feeInnerData = [];
        $data1 = [];
        $data2 = [];

        if (! empty($orderMeta)) {

            $taxData = json_decode($orderMeta->value);
            foreach ($taxData->product as $key1 => $products) {
                if ($key1 != $request->delete_id) {
                    $innerData = [];
                    foreach ($products as $key3 => $product) {
                        $innerData[$key3] = [
                            'product_id' => $product->product_id,
                            'tax' => $product->tax,
                        ];
                    }

                    $data1[$key] = $innerData;
                    $key++;
                }
            }

            if (isset($taxData->fee)) {
                $key = 0;
                foreach ($taxData->fee as $key2 => $fees) {
                    if ($key2 != $request->delete_id) {
                        $feeInnerData = [];
                        foreach ($fees as $key4 => $fee) {
                            $feeInnerData[$key4] = [
                                'key' => $fee->key,
                                'tax' => $fee->tax,
                            ];
                        }

                        $data2[$key] = $feeInnerData;
                        $key++;
                    }
                }
            }
        }

        $data = [
            'product' =>  $data1,
            'fee' => $data2,
        ];

        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'meta_custom_tax'],
            ['type' => 'string', 'value' => json_encode($data)]
        );

        return true;
    }

    public function addCouponInOrder(Request $request)
    {
        $cartService = new AddToCartService();
        $cartService->deleteAll(null);
        $productIds = $this->orderDetails->pluck('product_id', 'quantity')->toArray();

        foreach ($productIds as $key => $productId) {
            $product = Product::find($productId);

            $request['id'] = $productId;
            $request['qty'] = (int) $key;
            $request['variation_id'] = null;

            if ($product->type == 'Variation') {
                $request['variation_id'] = $product->id;
                $request['id'] = $product->parentDetail->id;
            }
            $request['manual_order'] = true;
            $response = $cartService->add($request);
            if (isset($response['status']) && $response['status'] == 1) {
                continue;
            } else {
                return false;
            }
        }

        $request['discount_code'] = $request->coupon;
        $request['select'] = 'all';
        \App\Cart\Cart::checkCartData();
        $coupon = $cartService->checkCoupon($request);
        $couponData = Coupon::where('code', $request->coupon)->first();

        if ($request->request_user == 'vendor' && ! empty($couponData)) {
            if ($couponData->vendor_id != auth()->user()->vendor()->vendor_id) {
                return ['message' => __('Invalid Coupon!')];
            }
        }

        if (! empty($couponData) && isset($this->couponRedeems)) {
            $existsOrderCoupon = $this->couponRedeems->where('coupon_id', $couponData->id)->first();

            if (! empty($existsOrderCoupon)) {
                return ['message' => __('This coupon has already been applied.')];
            }
        }

        if (! empty($coupon) && isset($coupon['status']) && isset($coupon['data'][$couponData->id]) && $coupon['status'] == 1) {
            $coupon = $coupon['data'][$couponData->id];
            $this->total = $this->total - $coupon['calculated_discount'];
            $this->save();

            $couponRedem[] = [
                'coupon_id' => $coupon['id'],
                'coupon_code' => $coupon['code'],
                'user_id' => $this->user_id,
                'user_name' => $this->user?->name,
                'order_id' => $this->id,
                'order_code' => $this->reference,
                'discount_amount' => $coupon['calculated_discount'],
            ];

            (new \Modules\Coupon\Http\Models\CouponRedeem())->store($couponRedem);

            $cartService->deleteAll(null);

            return true;
        }

        return ['message' => $coupon['message'] ?? __('Invalid Coupon!')];

    }

    /**
     * coupon delete
     *
     * @return bool
     */
    public function deleteCouponFromOrder($request)
    {
        $coupon = CouponRedeem::where('id', $request->delete_id)->first();

        if (! empty($coupon)) {
            $discountAmount = $coupon->discount_amount;
            $coupon->delete();
            $this->total = $this->total + $discountAmount;
            $this->save();

            return true;
        }

        return false;
    }

    public function customFeeCalculations()
    {
        $customFee = $this->metadata->where('key', 'meta_custom_fee')->first();
        $feeTotal = 0;
        $customTaxTotal = 0;
        if (! empty($customFee)) {
            $feeData = json_decode($customFee->value);
            foreach ($feeData as $feeKey => $fee) {
                $feeTotal += $fee->calculated_amount;
                $customTaxTotal += $fee->tax;
            }
        }

        return [
            'feeTotal' => $feeTotal,
            'customTaxTotal' => $customTaxTotal,
        ];
    }

    public function showBillingAddress()
    {
        return preference('address_first_name_visible', 1) ||
        preference('address_last_name_visible', 1) ||
        preference('address_email_address_visible', 1) ||
        preference('address_phone_visible', 1) ||
        preference('address_street_address_1_visible', 1) ||
        preference('address_street_address_2_visible', 1) ||
        preference('address_city_visible', 1) ||
        preference('address_zip_visible', 1) ||
        preference('address_state_visible', 1) ||
        preference('address_country_visible', 1);
    }

    /**
     * check if payment link workable or not
     *
     * @return bool
     */
    public function isPayable()
    {
        return $this->paymentMethod?->status == 'pending' && $this->orderStatus?->slug != 'cancelled' && $this->paymentMethod?->gateway != 'CashOnDelivery' && $this->payment_status != 'Partial';
    }
}
