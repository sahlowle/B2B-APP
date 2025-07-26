<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-02-2024
 */

namespace App\Filters;

class CustomFieldFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'status' => 'in:Active,Inactive',
    ];

    /**
     * filter status  query string
     *
     * @param  string  $status
     * @return query builder
     */
    public function status($status)
    {
        $statusLabels = [
            'Inactive' => 0,
            'Active' => 1,
        ];

        return $this->query->where('status', $statusLabels[$status]);
    }

    /**
     * filter field_to  query string
     *
     * @param  string  $fieldTo
     * @return query builder
     */
    public function fieldBelongs($fieldTo)
    {
        return $this->query->where('field_to', $fieldTo);
    }

    /**
     * filter type  query string
     *
     * @param  string  $type
     * @return query builder
     */
    public function types($type)
    {
        return $this->query->where('type', $type);
    }

    /**
     * filter by search query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function search($value)
    {
        $value = $value['value'];

        return $this->query->where(function ($query) use ($value) {
            $query->whereLike('name', $value)
                ->OrWhereLike('field_to', $value)
                ->OrWhereLike('type', $value)
                ->OrWhereLike('status', $value);
        });
    }
}
