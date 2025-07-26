<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class MultiCurrency extends Model
{
    use ModelTrait;

    protected $fillable = ['currency_id', 'exchange_rate', 'exchange_fee', 'allow_decimal_number', 'custom_symbol'];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }

    public static function store($request)
    {
        if (parent::create($request)) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Status remove
     *
     * @param  null  $id
     * @return array
     */
    public static function remove($id = null)
    {
        $info = parent::find($id);

        if (! empty($info)) {
            $info->delete();
            self::forgetCache();

            return ['status' => true, 'msg' => __('The :x has been successfully deleted.', ['x' => __('Currency')])];
        }

        return ['status' => false, 'msg' => __('The :x can not be deleted, please try again.', ['x' => __('Currency')])];
    }

    /**
     * Status Update
     *
     * @return bool
     */
    public static function currencyUpdate($data, $id)
    {
        if (parent::where('id', $id)->update($data)) {
            self::forgetCache();

            return true;
        }

        return false;
    }
}
