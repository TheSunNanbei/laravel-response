<?php


namespace NanBei\Response\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * @method static array paginates(object |array $data = [])
 * @method static array simplePagenates(object |array $data = [])
 */
class PaginateUtil extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \NanBei\Response\Utils\PaginateUtil::class;
    }
}
