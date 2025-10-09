<?php
/**
 * @package PackageFilter
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 20-02-2023
 */

namespace Modules\Subscription\Filters;

use App\Filters\Filter;

class PackageFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive,Pending'
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
     * filter visibility  query string
     *
     * @param string $visibility
     * @return query builder
     */
    public function visibility($visibility)
    {
        if ($visibility == '') {
            return;
        }
        
        return $this->query->where('is_private', $visibility);
    }
    
    /**
     * filter billingCycle  query string
     *
     * @param string $billingCycle
     * @return query builder
     */
    public function billingCycle($billingCycle)
    {
        if (empty($billingCycle)) {
            return;
        }
        
        return $this->query->whereLike('billing_cycle', "\"$billingCycle\":" . "\"1\"");
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
                $query->WhereLike('name', $value)
                ->OrWhereLike('code', $value)
                ->OrWhereLike('sale_price', $value)
                ->OrWhereLike('discount_price', $value)
                ->OrWhereLike('billing_cycle', $value)
                ->OrWhereLike('status', $value)
                ->orWhereHas('user', function ($query)use($value) {
                    $query->WhereLike('name', $value);
                });
            });
        }

    }
}
