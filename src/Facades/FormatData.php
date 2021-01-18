<?php


namespace NanBei\Response\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static array format(object |array $data = [])
 * @method static array formatData(object |array $data = [])
 */
class FormatData extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \NanBei\Response\Formats\Format::class;
    }
}
