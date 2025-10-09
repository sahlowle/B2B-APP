<?php

/**
 * @package PackageSubscriptionMeta
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

namespace Modules\Subscription\Entities;

use App\Models\MetaData;
use App\Traits\ModelTrait;

class PackageSubscriptionMeta extends MetaData
{
    use ModelTrait;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'package_subscriptions_meta';

    /**
     * timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation with packageSubscription model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(packageSubscription::class);
    }
}
