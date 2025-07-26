<?php

namespace Modules\Inventory\Entities;

use App\Models\Order;
use App\Models\Product;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use DB;

class StockManagement extends Model
{
    use ModelTrait;

    protected $fillable = ['location_id', 'product_id', 'quantity', 'type', 'date', 'note', 'status'];

    protected $table = 'stock_managements';

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function scopeApprove($query)
    {
        return $query->where('status', 'approve');
    }

    /**
     * store stock data
     *
     * @return bool
     */
    public static function store($data = [])
    {
        if (parent::insert($data)) {
            return true;
        }

        return false;
    }

    /**
     * stock update while stock increase or decrease
     * action will hit by mutator
     *
     * @return true|void
     */
    public static function stockUpdate($stock, $product)
    {
        if (! isset($product->id)) {
            return 0;
        }

        if (isset(request()->action) && request()->action == 'save_product_variation') {
            return;
        }

        $adjust = 0;
        $isDecrease = false;

        // stock increment
        if ($stock > $product->total_stocks) {
            $adjust = $stock - $product->total_stocks;
        }

        // stock decrement
        if ($stock < $product->total_stocks) {
            $isDecrease = true;
            $adjust = -($product->total_stocks - $stock);
        }

        $orderFulfill = 'default';
        $orderFulfill = preference('order_fulfill', '') ?? $orderFulfill;

        if ($orderFulfill == 'default' || ! $isDecrease) {
            $location = Location::where('vendor_id', $product->vendor_id)->default()->first();

            if (empty($location)) {
                $location = Location::where('vendor_id', $product->vendor_id)->orderBy('id', 'ASC')->first();
            }

            if (empty($location)) {
                return false;
            }

            return self::productStockOrder($location->id, $product, $adjust, $isDecrease);

        } elseif ($orderFulfill == 'highest') {
            $vendorId = $product->vendor_id;
            $locations = StockManagement::select('*', DB::raw('sum(quantity) as available'))
                ->where('product_id', $product->id)
                ->whereHas('location', function ($q) use ($vendorId) {
                    $q->where('vendor_id', $vendorId);
                })->with('location')
                ->whereIn('type', stockKeyword())
                ->groupBy('location_id');

            if ($isDecrease) {
                $locations->orderBy('available', 'DESC');
            } else {
                $locations->orderBy('available', 'ASC');
            }

            $locations = $locations->get();

            foreach ($locations as $location) {

                $positiveAdjust = abs($adjust);

                if ($positiveAdjust <= $location->available) {
                    self::productStockOrder($location->location_id, $product, $adjust, $isDecrease);

                    return;
                } elseif ($positiveAdjust > $location->available) {

                    if ($isDecrease) {
                        $adjust += $location->available;
                        $available = -($location->available);
                    } else {
                        $available = $positiveAdjust;
                        $adjust -= $available;
                    }

                    self::productStockOrder($location->location_id, $product, $available, $isDecrease);
                }
            }

        }
    }

    /**
     * sotck record store with log
     *
     * @return true
     */
    public static function productStockOrder($locationId, $product, $adjust, $isDecrease = true)
    {
        $stockData = [
            'location_id' => $locationId,
            'product_id' => $product->id,
            'quantity' => $adjust,
            'type' => $isDecrease ? 'order' : 'refund',
            'status' => $isDecrease ? 'committed' : 'approve',
            'date' => DbDateFormat(date('Y-m-d')),
        ];

        $stockId = parent::insertGetId($stockData);
        $order = Order::latest()->first();

        $logs = [
            'location_id' => $locationId,
            'product_id' => $product->id,
            'log_type' => 'order',
            'stock_management_id' => $stockId,
            'transaction_type' => $isDecrease ? 'order_create' : 'refund',
            'order_id' => $order->id,
            'quantity' => $adjust,
            'transaction_date' => DbDateFormat(date('Y-m-d')),
        ];

        Log::store($logs);

        return true;
    }

    /**
     * store inital stock from product update/store
     *
     * @return array|false
     */
    public static function productInitialStock($request, $product)
    {
        $productId = $product->id;
        $locationData = [];
        $locationsStock = $request['location'] ?? [];

        foreach ($locationsStock as $location) {
            $locationData[] = [
                'location_id' => $location['id'],
                'product_id' => $productId,
                'quantity' => $location['qty'],
                'type' => 'stock_in_initial',
                'status' => 'approve',
                'date' => DbDateFormat(date('Y-m-d')),
            ];

            $logs = [
                'location_id' => $location['id'],
                'product_id' => $productId,
                'log_type' => 'stock_in',
                'transaction_type' => 'initial',
                'quantity' => $location['qty'],
                'transaction_date' => DbDateFormat(date('Y-m-d')),
            ];

            Log::store($logs);

        }

        if (parent::store($locationData)) {

            if (isset($request['temp_vendor_id'])) {
                $productUpdate = Product::find($productId)->update(['vendor_id' => $request['temp_vendor_id'], 'manage_stocks' => 1]);
            } else {
                $request['temp_vendor_id'] = $product->vendor_id;
            }

            return self::getVendorLocationStock($productId, $request['temp_vendor_id'], true);
        }

        return false;
    }

    /**
     * vendor location stock
     *
     * @return array
     */
    public static function getVendorLocationStock($productId = null, $vendorId = null, $isAjax = false, $option = [])
    {
        $variationData = [];
        $stock['stocks'] = self::getStock($productId, $vendorId, $option['locationId'] ?? null);
        if ($isAjax || count($stock['stocks']) > 0) {
            $product = Product::find($productId);
            if ($product->variations && $isAjax) {
                foreach ($product->variations as $variation) {
                    $variationStock = self::getStock($variation->id, $vendorId);
                    $variationLocationIds = collect($variationStock)->pluck('location_id')->toArray();
                    $variationData[] = [
                        'variation_id' => $variation->id,
                        'variations' => $variationStock,
                        'locations' => Location::where('vendor_id', $vendorId)->whereNotIn('id', $variationLocationIds)->active()->get(),
                    ];
                }
            }
        }

        $locationIds = collect($stock['stocks'])->pluck('location_id')->toArray();

        $productUpdate = Product::find($productId)->update(['vendor_id' => $vendorId]);

        $stock['locations'] = Location::where('vendor_id', $vendorId)->whereNotIn('id', $locationIds)->active()->get();
        $stock['variations'] = $variationData;
        $stock['rowId'] = $option['rowId'] ?? '';

        return $stock;
    }

    /**
     * get stock by location wise or specific location
     *
     * @return mixed
     */
    protected static function getStock($productId = null, $vendorId = null, $locationId = null)
    {

        $response = StockManagement::select('*', DB::raw('sum(quantity) as available'))
            ->where('product_id', $productId)
            ->whereHas('location', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('location')
            ->whereIn('type', stockKeyword());

        if (! is_null($locationId)) {
            $response->where('location_id', $locationId);
        } else {
            $response->groupBy('location_id');
        }

        return $response->get();
    }

    /**
     * product stock
     *
     * @return int
     */
    protected static function productStock($productId = null, $vendorId = null)
    {
        $response = StockManagement::select('*', DB::raw('sum(quantity) as available'))
            ->where('product_id', $productId)
            ->whereHas('location', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId)->active();
                if (isset(request()->location_id)) {
                    $q->where('id', request()->location_id);
                }
            })->with('location')
            ->whereIn('type', stockKeyword())
            ->first();

        return isset($response->available) ? intval($response->available) : 0;
    }

    /**
     * stock adjust
     *
     * @return array
     */
    public static function adjust($request, $product, $needStock = true)
    {
        if ($request['adjust_by'] != 0) {
            $stockManagement[] = [
                'location_id' => $request['location_id'],
                'product_id' => $request['product_id'],
                'quantity' => $request['adjust_by'],
                'type' => ! $needStock && isset($request['adjust_type']) ? $request['adjust_type'] : 'adjust',
                'date' => DbDateFormat(date('Y-m-d')),
                'status' => 'approve',
            ];

            StockManagement::store($stockManagement);

            $logs = [
                'location_id' => $request['location_id'],
                'product_id' => $request['product_id'],
                'log_type' => ! $needStock && isset($request['adjust_type']) ? $request['adjust_type'] : 'adjust',
                'transaction_type' => $request['reason'],
                'quantity' => $request['adjust_by'],
                'transaction_date' => DbDateFormat(date('Y-m-d')),
            ];

            Log::store($logs);
        }

        if ($needStock) {
            return self::getVendorLocationStock($product->id, $product->vendor_id, true, ['locationId' => $request['location_id'], 'rowId' => $request['row_id']]);
        } else {
            return true;
        }
    }

    /**
     * stock adjust for variation
     *
     * @return bool
     */
    public static function adjustVariation($data)
    {
        $stockManagement = [];

        foreach ($data as $request) {

            if ($request['adjust_by'] != 0) {

                $stockManagement[] = [
                    'location_id' => $request['location_id'],
                    'product_id' => $request['product_id'],
                    'quantity' => $request['adjust_by'],
                    'type' => 'adjust',
                    'date' => DbDateFormat(date('Y-m-d')),
                    'status' => 'approve',
                ];

                $logs = [
                    'location_id' => $request['location_id'],
                    'product_id' => $request['product_id'],
                    'log_type' => 'adjust',
                    'transaction_type' => $request['reason'],
                    'quantity' => $request['adjust_by'],
                    'transaction_date' => DbDateFormat(date('Y-m-d')),
                ];

                Log::store($logs);

            }
        }

        if (count($stockManagement) > 0) {
            return StockManagement::store($stockManagement);
        }

        return false;

    }

    /**
     * while delivery complete
     *
     * @return true
     */
    public static function completeDelivery($orderDetail)
    {
        $inventoryLogs = Log::where('order_id', $orderDetail->order_id)->where('product_id', $orderDetail->product_id)->get();
        foreach ($inventoryLogs as $log) {
            $data = StockManagement::where('id', $log->stock_management_id)->first();
            $data->status = 'approve';
            $data->save();
        }

        return true;
    }

    /**
     * committed calculation
     *
     * @return mixed
     */
    public function commited()
    {
        $committed = parent::where('product_id', $this->product_id)
            ->where('type', 'order')
            ->where('status', 'committed');

        if (isset(request()->location)) {
            $committed->where('location_id', $this->location_id);
        }

        $committed = $committed->sum('quantity');

        return $committed;
    }

    /**
     * unavailable calculation
     *
     * @return mixed
     */
    public function unAvailable()
    {
        $unavailable =  parent::where('product_id', $this->product_id)
            ->where('type', 'unavailable')
            ->where('status', 'approve');

        if (isset(request()->location) || \Request::route()->getName() == 'vendor.inventory.adjust' || \Request::route()->getName() == 'inventory.adjust') {
            $unavailable->where('location_id', $this->location_id);
        }

        $unavailable = $unavailable->sum('quantity');

        $available = parent::where('product_id', $this->product_id)
            ->where('type', 'available')
            ->where('status', 'approve');

        if (isset(request()->location) || \Request::route()->getName() == 'vendor.inventory.adjust' || \Request::route()->getName() == 'inventory.adjust') {
            $available->where('location_id', $this->location_id);
        }

        $available = $available->sum('quantity');

        return ['unavailable' => $unavailable, 'available' => $available, 'total_unavailable' => $unavailable + $available];
    }

    /**
     * incoming calculation
     *
     * @return mixed
     */
    public function incoming()
    {
        $locationId = $this->location_id;

        $purchase = PurchaseDetail::select(DB::raw('SUM(quantity - (quantity_receive + quantity_reject)) as incoming'))
            ->where('product_id', $this->product_id);

        if (isset(request()->location)) {
            $purchase->WhereHas('purchase', function ($query) use ($locationId) {
                $query->where('location_id', $locationId)->where('status', '!=', 'Received');
            });
        } else {
            $purchase->WhereHas('purchase', function ($query) {
                $query->where('status', '!=', 'Received');
            });
        }

        $purchase = $purchase->first()->incoming;

        $transfer = TransferDetail::select(DB::raw('SUM(quantity - (quantity_receive + quantity_reject)) as incoming'))
            ->where('product_id', $this->product_id);

        if (isset(request()->location)) {
            $transfer->WhereHas('transfer', function ($query) use ($locationId) {
                $query->where('to_location_id', $locationId)->where('status', '!=', 'Received');
            });
        } else {
            $transfer->WhereHas('transfer', function ($query) {
                $query->where('status', '!=', 'Received');
            });
        }

        $transfer = $transfer->first()->incoming;

        return $purchase + $transfer;
    }
}
