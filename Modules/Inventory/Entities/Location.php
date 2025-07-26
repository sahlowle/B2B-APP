<?php

namespace Modules\Inventory\Entities;

use App\Models\Vendor;
use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\GeoLocale\Entities\Country;
use Modules\GeoLocale\Entities\Division;

class Location extends Model
{
    use ModelTrait;

    protected $fillable = ['name', 'slug', 'shop_id', 'vendor_id', 'parent_id', 'address', 'country', 'state', 'city', 'zip', 'phone', 'email', 'status', 'is_default', 'priority'];

    public function shop()
    {
        return $this->belongsTo('Modules\Shop\Http\Models\Shop', 'shop_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function parent()
    {
        return $this->belongsTo('Modules\Inventory\Entities\Location', 'parent_id');
    }

    public function geoCountry()
    {
        return $this->belongsTo(Country::class, 'country', 'code');
    }

    public function stockManagement()
    {
        return $this->hasMany(StockManagement::class, 'location_id', 'id');
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

    /**
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * @return mixed
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }

    /**
     * get full address
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
        $vendor = Vendor::where('id', $request['vendor_id'])->first();
        $request['shop_id'] = $vendor->shop->id;

        if ($request['is_default'] == 1) {

            if ($request['status'] == 'Inactive') {
                return false;
            }

            parent::where('is_default', 1)->where('shop_id', $request['shop_id'])->update([
                'is_default' => 0,
            ]);
        }

        $location = parent::create($request);

        if ($location) {
            return $location;
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
        $vendor = Vendor::where('id', $request['vendor_id'])->first();
        $request['shop_id'] = $vendor->shop->id;
        $result = parent::where('id', $id)->first();

        if (isActive('Pos') && $request['status'] == 'Inactive' && $result->terminals()->count() > 0) {
            return ['status' => false, 'message' => __('Location has terminals, can not be inactive!')];
        }

        if ($request['is_default'] == 0 && $result->is_default == 1) {
            return ['status' => false, 'message' => __('Default location can not be non-default!')];
        }

        if ($request['status'] == 'Inactive' && $request['is_default'] == 1) {
            return ['status' => false, 'message' => __('Default location can not be inactive!')];
        }

        if ($request['is_default'] == 1 && $result->is_default != 1) {
            parent::where('is_default', 1)->where('shop_id', $request['shop_id'])->update([
                'is_default' => 0,
            ]);
        }

        if ($request['status'] == 'Inactive' && $result->is_default == 1) {
            return ['status' => false, 'message' => __('Default location can not be inactive!')];
        }

        if (! empty($result)) {
            $result->update($request);

            return ['status' => true];
        }

        return ['status' => false, 'message' => __('Something went wrong, please try again.')];
    }

    /**
     * remove
     *
     * @return array
     */
    public static function remove($id = null)
    {
        $data = ['type' => 'fail', 'message' => __('Something went wrong, please try again.')];
        $location = parent::find($id);

        if (Purchase::where('location_id', $id)->exists()) {
            return ['type' => 'fail', 'message' => __('This :x is already used in purchase order.', ['x' => __('Location')])];
        }

        if ($location->is_default == 1) {
            return ['type' => 'fail', 'message' => __('The :x is default, can not be deleted.', ['x' => __('Location')])];
        }

        if (! empty($location)) {
            $location->delete();
            $data = ['type' => 'success', 'message' => __('The :x has been successfully deleted.', ['x' => __('Location')])];
        }

        return $data;
    }
}
