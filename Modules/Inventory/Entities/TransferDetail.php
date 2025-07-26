<?php

namespace Modules\Inventory\Entities;

use App\Models\Product;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    use ModelTrait;

    protected $fillable = ['transfer_id', 'product_id', 'quantity', 'quantity_receive', 'quantity_reject'];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function incrementReceive($value = 0): void
    {
        $this->increment('quantity_receive', $value);
    }

    public function incrementReject($value = 0): void
    {
        $this->increment('quantity_reject', $value);
    }

    /**
     * store
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
     * update purchase detail
     *
     * @return bool
     */
    public static function updateTransferDetail($request, $id)
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
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Transfer Details')])];
        }

        return $data;
    }
}
