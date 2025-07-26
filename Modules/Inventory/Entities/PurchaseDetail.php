<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
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
    public static function updatePurchaseDetail($request, $id)
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
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Purchase Detail')])];
        }

        return $data;
    }
}
