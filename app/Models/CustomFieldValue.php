<?php

namespace App\Models;

use App\Traits\ModelTrait;

class CustomFieldValue extends Model
{
    use ModelTrait;

    /**
     * Timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Foreign key with Category model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customField()
    {
        return $this->belongsTo(CustomField::class, 'field_id');
    }
}
