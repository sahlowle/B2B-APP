<?php

namespace Modules\Subscription\Entities;

use App\Models\{
    Model, User
};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'unique_code',
        'user_id',
        'package_id',
        'package_subscription_id',
        'activation_date',
        'billing_date',
        'next_billing_date',
        'billing_price',
        'billing_cycle',
        'amount_billed',
        'amount_received',
        'payment_method',
        'features',
        'duration',
        'currency',
        'renewable',
        'is_trial',
        'payment_status',
        'status',
    ];

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
     * Relation with packageSubscription model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(PackageSubscription::class, 'package_subscription_id');
    }

}
