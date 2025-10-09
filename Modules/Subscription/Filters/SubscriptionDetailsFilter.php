<?php
/**
 * @package SubscriptionDetailsFilter
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-05-2023
 */

namespace Modules\Subscription\Filters;

use App\Filters\Filter;

class SubscriptionDetailsFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive,Pending,Expired,Paused'
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

    /**
     * filter by search query string
     *
     * @param string $value
     * @return query builder
     */
    public function search($value)
    {
        $value = $value['value'];
        if (!empty($value)) {
            return $this->query->where(function ($query) use ($value) {
                $query->WhereLike('billing_cycle', $value)
                ->OrWhereLike('payment_status', $value)
                ->OrWhereLike('status', $value)
                ->orWhereHas('package', function ($query) use ($value) {
                    $query->WhereLike('name', $value);
                })
                ->orWhereHas('user', function ($query) use ($value) {
                    $query->WhereLike('name', $value);
                });
            });
        }

    }
}
