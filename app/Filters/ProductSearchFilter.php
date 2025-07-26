<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor AH Millat <[millat.techvill@gmail.com]>
 * @contributor Sakawat Hossain <[sakawat.techvill@gmail.com]>
 *
 * @created 20-08-2022
 */

namespace App\Filters;

use App\Models\Category;
use App\Models\Language;
use App\Models\Tag;

class ProductSearchFilter extends Filter
{
    /**
     * set the rules of query string
     *
     * @var array
     */
    protected $filterRules = [
        'brands' => 'string',
        'categories' => 'string',
        'rating' => 'int',
        'keyword' => 'string',
    ];

    /**
     * filter by brand  query string
     *
     * @param  int  $id
     * @return query builder
     */
    public function brands($value)
    {
        $brandArray = explode(',', $value);

        return $this->query->whereHas('brand', function ($q) use ($brandArray) {
            return $q->whereIn('name', $brandArray);
        });
    }

    /**
     * filter by rating  query string
     *
     * @param  int  $value
     * @return query builder
     */
    public function rating($value)
    {
        return $this->query->where('review_average', '>=', $value);
    }

    /**
     * filter by rating  query string
     *
     * @param  int  $value
     * @return query builder
     */
    public function vendorId($value)
    {
        return $this->query->where('vendor_id', $value);
    }

    /**
     * filter by category  query string
     *
     * @param  int  $id
     * @return query builder
     */
    public function categories($value)
    {
        $languages = Language::getAll()->where('status', 'Active');
        $categoryArray = explode(',', $value);

        try {
            $category = Category::where('slug->' . config('app.locale'), $value)->first();
            if (is_null($category)) {
                Category::checkCategorySlugJson();
                $category = Category::where('slug->' . config('app.locale'), $value)->first();
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            Category::checkCategorySlugJson();
            $category = Category::where('slug->' . config('app.locale'), $value)->first();
        }

        if (empty($category)) {
            foreach ($languages as $language) {
                $category = Category::where('slug->' . $language->short_name, $value)->first();
                if (! empty($category)) {
                    break;
                }
            }
        }

        if (isset($category->childrenCategories)) {
            $children = $category->childrenCategories->pluck('slug', 'id')->toArray();
            $categoryArray = array_merge($categoryArray, $children);
            $childTwo = Category::whereIn('parent_id', array_keys($children))->pluck('slug')->toArray();

            if (count($childTwo) > 0) {
                $categoryArray = array_merge($categoryArray, $childTwo);
            }
        }

        return $this->query->whereHas('category', function ($q) use ($categoryArray, $languages) {
            $q->whereIn('slug->' . config('app.locale'), $categoryArray);

            foreach ($languages as $language) {
                $q->orWhereIn('slug->' . $language->short_name, $categoryArray);
            }

            return $q;

        });
    }

    /**
     * filter using attributes
     *
     * @return mixed
     */
    public function attributes($value)
    {
        $formattedAttribute = [];
        $attributes = explode(';', $value);

        foreach ($attributes as $attribute) {
            $attr = explode(':', $attribute);

            if (isset($attr[0]) && isset($attr[1])) {
                $formattedAttribute[$attr[0]] = explode('_', $attr[1]);
            }
        }

        return $this->query->whereHas('metadata', function ($q) use ($formattedAttribute) {

            foreach ($formattedAttribute as $data) {
                $data = implode(';', $data);
                $q->where('key', 'attributes')->where('value', 'LIKE', "%{$data}%");
            }
        });
    }

    /**
     * filter using price range
     *
     * @param  mixed  $value
     * @return void
     */
    public function priceRange($value)
    {
        $priceRange = explode(',', xss_clean($value));

        if (isset($priceRange[0])) {
            $min = $priceRange[0];
            $this->query->where('regular_price', '>=', $min);
        }

        if (isset($priceRange[1])) {
            $max = $priceRange[1];
            $this->query->where('regular_price', '<=', $max);
        }

        return $this->query;
    }

    public function b2b($value)
    {
        return $this->query->whereHas('metadata', function ($query) use ($value) {
            $query->where('key', 'meta_enable_b2b')->where('value', $value);
        });
    }

    /**
     * filter using sort by
     *
     * @return mixed
     */
    public function sortBy($value)
    {
        if ($value == 'Price High to Low') {
            return $this->query->orderBy('regular_price', 'DESC');
        } elseif ($value == 'Avg. Ratting') {
            return $this->query->orderBy('review_average', 'DESC');
        } else {
            return $this->query->orderBy('regular_price', 'ASC');
        }
    }

    /**
     * filter by keyword  query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function keyword($value)
    {
        $value = xss_clean($value);
        if (empty($value)) {
            return $this->query;
        }

        $tags = Tag::getAll()->filter(function ($tagName) use ($value) {
            // replace stristr with choice of matching function
            return stristr($tagName->name, $value) !== false;
        })->pluck('id')->toArray();

        return $this->query->where(function ($query) use ($value, $tags) {
            $query->WhereLike('name', $value)
                ->OrWhereLike('code', $value)
                ->OrWhereLike('sku', $value)
                ->orWhereHas('productTag', function ($query) use ($tags) {
                    $query->whereIn('tag_id', $tags);
                });
        });
    }

    /**
     * filter by product id  query string
     *
     * @return query builder
     */
    public function filterVariations()
    {
        $this->query->where('parent_id', null)->where('status', 'Published');
    }

    /**
     * filter by product id  query string
     *
     * @return query builder
     */
    public function filterProductId()
    {
        if (! request()->product_ids) {
            return $this->query;
        }
        $ids = explode(',', request()->product_ids);

        $ids = array_filter($ids, function ($item) {
            return is_numeric($item);
        });

        return $this->query->whereIn('id', $ids);
    }

    /**
     * filter by location  query string
     *
     * @param  string  $value
     * @return query builder
     */
    public function locationId($id)
    {
        return $this->query->where(function ($q) use ($id) {
            $q->whereHas('stocks', function ($q) use ($id) {
                $q->where('location_id', $id);
            })->orWhereDoesntHave('stocks');
        });
    }
}
