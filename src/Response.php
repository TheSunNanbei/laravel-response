<?php

namespace NanBei\Response;

use NanBei\Response\Facades\Basic;
use NanBei\Response\Facades\FormatData;

class Response
{
    //http状态码
    protected $httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_OK;

    //响应回复状态码
    protected $errCode;

    //响应回复信息
    protected $message;

    //响应回复错误内容
    protected $error;

    //响应回复错误堆栈
    protected $debug = [];

    //响应回复数据
    protected $responseData = [];

    //响应回复主体数据
    protected $data = [];

    //响应回复meta数据
    protected $meta = [];

    /**
     * 请求成功
     * http-status: 200
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data, $message = null, $code = null): \Illuminate\Http\JsonResponse
    {
        //格式化响应数据
        $formatData = FormatData::format($data);

        $this->responseData = $formatData;
        $this->data = $formatData['data'] ?? [];
        $this->meta = $formatData['meta'] ?? [];

        $this->errCode = (int)($code ?? config('laravel-response.code.success'));
        $this->message = $message ?? config('laravel-response.message.success');

        return $this->response();
    }

    /**
     * 请求失败
     * http-status: 200
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function fail($code = null, $message = null): \Illuminate\Http\JsonResponse
    {
        $this->data = null;
        $this->errCode = (int)($code ?? config('laravel-response.code.fail'));
        $this->message = $message ?? config('laravel-response.message.fail');
        return $this->response();
    }

    /**
     * 系统故障
     * http-status: 500
     * @param int $code
     * @param string $message
     * @param string $error
     * @param array $debug
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($code = null, $message = null, $error = null, $debug = []): \Illuminate\Http\JsonResponse
    {
        $this->data = null;
        $this->errCode = (int)($code ?? config('laravel-response.code.error'));
        $this->message = $message ?? config('laravel-response.message.error');
        $this->error = $error;
        $this->debug = $debug;
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
        return $this->response();
    }

    /**
     * 操作成功
     * http-status: 201
     * @param int $code
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function created($code = null, $message = null, $data = []): \Illuminate\Http\JsonResponse
    {
        //格式化响应数据
        $formatData = FormatData::format($data);

        $this->responseData = $formatData;
        $this->data = $formatData['data'] ?? [];
        $this->meta = $formatData['meta'] ?? [];

        $this->errCode = (int)($code ?? config('laravel-response.code.created'));
        $this->message = $message ?? config('laravel-response.message.created');
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_CREATED;
        return $this->response();
    }

    /**
     * 无内容
     * http-status: 204
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent(): \Illuminate\Http\JsonResponse
    {
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT;
        return $this->response();
    }

    /**
     * 授权失败
     * http-status: 401
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorized($code = null, $message = null): \Illuminate\Http\JsonResponse
    {
        $this->data = null;
        $this->errCode = (int)($code ?? config('laravel-response.code.unauthorized'));
        $this->message = $message ?? config('laravel-response.message.unauthorized');
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED;
        return $this->response();
    }

    /**
     * 请求权限不足
     * http-status: 403
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbidden($code = null, $message = null): \Illuminate\Http\JsonResponse
    {
        $this->errCode = (int)($code ?? config('laravel-response.code.forbidden'));
        $this->message = $message ?? config('laravel-response.message.forbidden');
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN;
        return $this->response();
    }

    /**
     * 请求资源不存在
     * http-status: 404
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($code = null, $message = null): \Illuminate\Http\JsonResponse
    {
        $this->data = null;
        $this->errCode = (int)($code ?? config('laravel-response.code.not_found'));
        $this->message = $message ?? config('laravel-response.message.not_found');
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND;
        return $this->response();
    }

    /**
     * 请求参数错误
     * http-status: 422
     * @param int $code
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateFail($code = null, $message = null): \Illuminate\Http\JsonResponse
    {
        $this->data = null;
        $this->errCode = (int)($code ?? config('laravel-response.code.validate_fail'));
        $this->message = $message ?? config('laravel-response.message.validate_fail');
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY;
        return $this->response();
    }


    private function response(): \Illuminate\Http\JsonResponse
    {
        //组装返回内容
        $responseData = [
            'error_code' => $this->errCode,
            'message' => $this->message
        ];

        if (!is_null($this->data)){
            $responseData['data'] = $this->data;
            $responseData['meta'] = empty($this->meta) ? Basic::defaultValue() : $this->meta;
        }

        //如果开启debug，则返回错误内容，供开发者查阅
        if (config('app.debug', true)) {
            $responseData['error'] = $this->error;
            $responseData['debug'] = $this->debug;
        }

        return \Illuminate\Support\Facades\Response::json($responseData, $this->httpStatus);
    }
}
