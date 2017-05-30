<?php

namespace Superbalist\LaravelAppboy;

use Illuminate\Support\Facades\Facade;

class AppboyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'appboy';
    }
}
