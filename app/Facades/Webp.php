<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Webp extends Facade
{
    /**
     * Return facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'webp';
    }
}
