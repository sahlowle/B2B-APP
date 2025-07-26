<?php

namespace App\Models;

use App\Traits\ModelTrait;

class CustomFieldMeta extends Model
{
    use ModelTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_field_metas';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
