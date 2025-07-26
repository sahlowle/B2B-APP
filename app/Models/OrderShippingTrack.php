<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Modules\Shipping\Entities\ShippingProvider;

class OrderShippingTrack extends Model
{
    use ModelTrait;

    protected $guarded = ['id'];

    /**
     * Store Order Shipping Track
     *
     * @param  array  $data
     * @return bool|object
     */
    public function storeData($data = [])
    {
        try {

            $attributes = [
                'shipping_provider_id' => $data['shipping_provider_id'],
                'provider_name' => $data['provider_name'],
                'order_id' => $data['order_id'],
                'tracking_link' => $data['tracking_link'],
                'tracking_no' => $data['tracking_no'],
                'order_shipped_date' => $data['order_shipped_date'],
                'track_type' => $data['track_type'],
            ];

            $uniqueAttributes = ['order_id' => $data['order_id'], 'track_type' => $data['track_type']];
            if ($data['track_type'] == 'product') {
                $uniqueAttributes['product_id'] = $data['product_id'];
            }

            // Perform the update or create operation
            return parent::updateOrCreate($uniqueAttributes, $attributes);

        } catch (\Throwable $th) {

            return false;
        }
    }

    /**
     * Relation with Order Shipping Track
     */
    public function shippingProvider()
    {
        return $this->belongsTo(ShippingProvider::class, 'shipping_provider_id', 'id');
    }
}
