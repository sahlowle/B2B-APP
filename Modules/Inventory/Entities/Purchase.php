<?php

namespace Modules\Inventory\Entities;

use App\Models\Currency;
use App\Models\Vendor;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use ModelTrait;

    protected $fillable = ['location_id', 'supplier_id', 'currency_id', 'exchange_rate', 'reference',
        'total_quantity', 'shipping_charge', 'payment_type', 'tax_charge', 'shipping_carrier', 'tracking_number', 'note', 'status', 'total_amount', 'adjustment', 'arrival_date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function purchaseDetail()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }

    /**
     * get purchase reference
     *
     * @return string
     */
    public static function getPurchaseReference($typeStr = 'PU')
    {
        $invoice_count = parent::count();

        if ($invoice_count > 0) {
            $invoiceReference = parent::latest('id')
                ->first(['reference']);
            $ref = str_replace($typeStr, '', $invoiceReference->reference);
            $invoice_count = (int) $ref;
        } else {
            $invoice_count = 0;
        }

        $invoice_count = $invoice_count + 1;
        $reference = $typeStr . sprintf('%04d', $invoice_count);

        while (1) {
            $hasOrder = parent::where('reference', $reference);

            if ($hasOrder->exists()) {
                $invoice_count = $invoice_count + 1;
                $reference = $typeStr . sprintf('%04d', $invoice_count);
            } else {
                break;
            }
        }

        return $reference;
    }

    /**
     * store
     *
     * @return false
     */
    public static function store($data)
    {
        $id = parent::insertGetId($data);

        if (! empty($id)) {
            return $id;
        }

        return false;
    }

    /**
     * update purchase
     *
     * @return bool
     */
    public static function updatePurchase($request, $id)
    {
        $result = parent::where('id', $id);

        if ($result->exists()) {
            $result->update($request);

            return true;
        }

        return false;
    }

    /**
     * remove
     *
     * @return array
     */
    public static function remove($id = null)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $result = parent::find($id);

        if (! empty($result)) {
            $result->delete();
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Purchase')])];
        }

        return $data;
    }
}
