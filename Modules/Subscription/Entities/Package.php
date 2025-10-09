<?php

/**
 * @package Package
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

namespace Modules\Subscription\Entities;

use App\Models\{
    Model, User
};
use Modules\Subscription\Traits\SubscriptionTrait;

class Package extends Model
{
    use SubscriptionTrait;
    /**
     * timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "name",
        "code",
        "sale_price",
        "discount_price",
        "short_description",
        "sort_order",
        "trial_day",
        "usage_limit",
        "billing_cycle",
        "renewable",
        "status",
        "is_private",
    ];

    /**
     * Cast
     *
     * @var array
     */
    protected $casts = [
        'sale_price' => 'array',
        'discount_price' => 'array',
        'billing_cycle' => 'array'
    ];

    /**
     * Relation with Package model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation with PackageSubscription model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(PackageSubscription::class);
    }

    /**
     * Relation with Package Meta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(PackageMeta::class);
    }
}
