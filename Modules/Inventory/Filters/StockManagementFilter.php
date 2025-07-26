<?php

namespace Modules\Inventory\Filters;

use App\Filters\Filter;

class StockManagementFilter extends Filter
{
    protected $filterRules = [
        'status' => 'in:approve,reject',
    ];

    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    public function location($value)
    {
        return $this->query->where('location_id', $value);
    }

    public function vendor($value)
    {
        return $this->query->whereHas('location', function ($q) use ($value) {
            $q->where('vendor_id', $value);
        });
    }

    public function search($value)
    {
        $value = xss_clean($value['value']);

        if (! empty($value)) {
            return $this->query->where(function ($query) use ($value) {
                $query->WhereLike('status', $value)
                    ->orWhereHas('product', function ($q) use ($value) {
                        $q->whereLike('name', $value);
                    });
            });
        }
    }
}
