<?php

namespace Modules\Inventory\Entities;

use App\Models\Vendor;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use ModelTrait;

    protected $fillable = ['reference', 'vendor_id', 'from_location_id', 'to_location_id', 'quantity', 'shipping_carrier', 'tracking_number', 'note', 'status'];

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id', 'id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function transferDetail()
    {
        return $this->hasMany(TransferDetail::class, 'transfer_id', 'id');
    }

    public static function getTransferReference($typeStr = 'TR')
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
    public static function updateTransfer($request, $id)
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
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Transfer')])];
        }

        return $data;
    }
}
