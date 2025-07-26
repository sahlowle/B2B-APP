<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Lib\Themeable\ThemeContract;

class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeContract::class;
    }
}
