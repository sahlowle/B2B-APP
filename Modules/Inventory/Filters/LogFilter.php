<?php

namespace Modules\Inventory\Filters;

use App\Filters\Filter;

class LogFilter extends Filter
{
    protected $filterRules = [
        'log_type' => 'in:purchase,order,adjust,stock_in',
    ];

    public function status($value)
    {
        return $this->query->where('log_type', $value);
    }

    public function search($value)
    {
        $value = xss_clean($value['value']);

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('note', $value)
                ->OrWhereLike('log_type', $value)
                ->OrWhereLike('transaction_type', $value);
        });
    }
}
