<?php

namespace Modules\Inventory\Filters;

use App\Filters\Filter;

class PurchaseFilter extends Filter
{
    protected $filterRules = [
        'status' => 'in:Received,Ordered,Partial',
    ];

    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    public function vendor($value)
    {
        return $this->query->where('vendor_id', $value);
    }

    public function location($value)
    {
        return $this->query->where('location_id', $value);
    }

    public function supplier($value)
    {
        return $this->query->where('supplier_id', $value);
    }

    public function search($value)
    {
        $value = xss_clean($value['value']);

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('reference', $value)
                ->OrWhereLike('status', $value)
                ->orWhereHas('vendor', function ($query) use ($value) {
                    $query->whereLike('name', $value);
                });
        });
    }
}
