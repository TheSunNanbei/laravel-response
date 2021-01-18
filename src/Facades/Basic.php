<?php


namespace NanBei\Response\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static object|array|string|null defaultValue()
 */
class Basic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \NanBei\Response\Utils\Basic::class;
    }
}
