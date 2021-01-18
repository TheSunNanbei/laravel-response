<?php

namespace NanBei\Response\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse success(object |array $data = [], string $message = '请求成功.', int $code = 0)
 * @method static \Illuminate\Http\JsonResponse fail(int $code = -1, string $message = '请求失败.')
 * @method static \Illuminate\Http\JsonResponse error(int $code = -1, string $message = '系统故障.')
 * @method static \Illuminate\Http\JsonResponse created(int $code = 0, string $message = '操作成功.', object|array $data = [])
 * @method static \Illuminate\Http\JsonResponse noContent()
 * @method static \Illuminate\Http\JsonResponse unauthorized(int $code = 0, string $message = '未授权.')
 * @method static \Illuminate\Http\JsonResponse forbidden(int $code = 0, string $message = '请求权限不足.')
 * @method static \Illuminate\Http\JsonResponse notFound(int $code = 0, string $message = '请求资源不存在.')
 * @method static \Illuminate\Http\JsonResponse validateFail(int $code = 0, string $message = '请求参数错误.')
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \NanBei\Response\Response::class;
    }
}
