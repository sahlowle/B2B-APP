<?php

/**
 * @package PackageMeta
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

namespace Modules\Subscription\Entities;

use App\Models\MetaData;
use App\Traits\ModelTrait;

class PackageMeta extends MetaData
{
    use ModelTrait;

     /**
     * table
     *
     * @var string
     */
    protected $table = 'packages_meta';

    /**
     * timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Relation with Package model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
