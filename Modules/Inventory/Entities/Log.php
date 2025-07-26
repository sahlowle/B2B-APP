<?php

namespace Modules\Inventory\Entities;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use ModelTrait;

    protected $fillable = ['location_id', 'purchase_id', 'product_id', 'supplier_id', 'currency_id', 'purchase_detail_id', 'quantity', 'transaction_type', 'price', 'transaction_date', 'note', 'log_type', 'stock_management_id', 'order_id', 'transfer_id'];

    protected $table = 'inventory_logs';

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function stockManagement()
    {
        return $this->belongsTo(StockManagement::class, 'stock_management_id', 'id');
    }

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }

    /**
     * store
     *
     * @return false
     */
    public static function store($request)
    {
        $log = parent::create($request);

        if ($log) {
            return $log;
        }

        return false;
    }
}
