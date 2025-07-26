<?php

namespace Modules\Inventory\Filters;

use App\Filters\Filter;

class LocationFilter extends Filter
{
    protected $filterRules = [
        'status' => 'in:Active,Inactive',
    ];

    /**
     * filter status  query string
     *
     * @param string $status
     * @return query builder
     */
    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    public function vendor($value)
    {
        return $this->query->WhereHas('vendor', function($query) use($value) {
                 $query->where('id', $value);
            });
    }

    public function search($value)
    {
        $value = xss_clean($value['value']);

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('name', $value)
                ->OrWhereLike('status', $value)
                ->orWhereHas('vendor', function($query) use($value) {
                    $query->whereLike('name', $value);
                });
        });
    }
}
