<?php

/**
 * @package PackageSubscription
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

namespace Modules\Subscription\Entities;

use App\Models\Model;
use App\Models\User;
use Modules\Subscription\Traits\SubscriptionTrait;

class PackageSubscription extends Model
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
        'code',
        'user_id',
        'package_id',
        'activation_date',
        'billing_date',
        'next_billing_date',
        'billing_price',
        'billing_cycle',
        'amount_billed',
        'amount_received',
        'amount_due',
        'is_customized',
        'renewable',
        'payment_status',
        'status',
    ];

    /**
     * Relation with PackageSubscriptionMeta model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metadata()
    {
        return $this->hasMany(PackageSubscriptionMeta::class);
    }

    /**
     * Relation with Package model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

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
     * Relation with SubscriptionDetails model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(SubscriptionDetails::class);
    }

    /**
     * Get Active detail
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function activeDetail()
    {
        return $this->details()->where('status', 'Active')->first();
    }
}
