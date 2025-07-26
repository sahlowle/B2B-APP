<?php

namespace Modules\Inventory\Entities;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\GeoLocale\Entities\Country;
use Modules\GeoLocale\Entities\Division;

class Supplier extends Model
{
    use ModelTrait;

    protected $fillable = ['vendor_id', 'name', 'company_name', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status'];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function geoCountry()
    {
        return $this->belongsTo(Country::class, 'country', 'code');
    }

    /**
     * relation with division
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function geoState()
    {
        return $this->belongsTo(Division::class, 'state', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * supplier full address
     *
     * @return string
     */
    public function fullAddress()
    {
        $address = [];

        if (! empty($this->address)) {
            array_push($address, $this->address);
        }

        if (isset($this->geoCountry)) {
            array_push($address, $this->geoCountry->name);
        }

        if (isset($this->geoState)) {
            array_push($address, $this->geoState->name);
        }

        if (! empty($this->city)) {
            array_push($address, $this->city);
        }

        if (! empty($this->zip)) {
            array_push($address, $this->zip);
        }

        return count($address) > 0 ? implode(',', $address) : '';
    }

    /**
     * store
     *
     * @return false
     */
    public static function store($request)
    {
        $supplier = parent::create($request);

        if ($supplier) {
            return $supplier;
        }

        return false;
    }

    /**
     * update location
     *
     * @return bool
     */
    public static function updateLocation($request, $id)
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

        if (Purchase::where('supplier_id', $id)->count() > 0) {
            return ['type' => 'fail', 'message' => __('This :x is already used in purchase order.', ['x' => __('Supplier')])];
        }

        if (! empty($result)) {
            $result->delete();
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Supplier')])];
        }

        return $data;
    }
}
