<?php

namespace Modules\Moyasar\Entities;

use Modules\Gateway\Entities\Gateway;
use Illuminate\Database\Eloquent\Builder;

class Moyasar extends Gateway
{
    protected $table = 'gateways';
    

    protected $appends = ['image_url'];

    protected static function booted(): void

    {

        static::addGlobalScope('moyasar', function (Builder $builder) {

            $builder-> where('alias', 'moyasar');

        });

    }
   
}
