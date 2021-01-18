<?php

namespace NanBei\Response;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use NanBei\Response\Facades\FormatData;

class Response
{
    //http状态码
    protected $httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_OK;

    //响应回复状态码
    protected $errCode = 0;

    //响应回复信息
    protected $message = '请求成功';

    //响应回复错误内容
    protected $error = '';

    //响应回复错误堆栈
    protected $debug = [];

    //响应回复数据
    protected $responseData = [];

    //响应回复主体数据
    protected $data = [];

    //响应回复meta数据
    protected $meta = [];

    public function success($data, $message = '请求成功.', $code = 0): \Illuminate\Http\JsonResponse
    {
        //格式化响应数据
        $formatData = FormatData::format($data);

        $this->responseData = $formatData;
        $this->data = $formatData['data'] ?? [];
        $this->meta = $formatData['meta'] ?? [];

        $this->errCode = $code;
        $this->message = $message;

        return $this->response();
    }

    public function fail(int $code = -1, $message = '请求失败.'): \Illuminate\Http\JsonResponse
    {
        $this->errCode = $code;
        $this->message = $message;
        return $this->response();
    }

    //500
    public function error(int $code = -1, $message = '系统故障.'): \Illuminate\Http\JsonResponse
    {
        $this->errCode = $code;
        $this->message = $message;
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR;
        return $this->response();
    }

    //201
    public function created(int $code = 0, $message = '操作成功.'): \Illuminate\Http\JsonResponse
    {
        $this->errCode = $code;
        $this->message = $message;
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_CREATED;
        return $this->response();
    }

    //204
    public function noContent(): \Illuminate\Http\JsonResponse
    {
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT;
        return $this->response();
    }

    //403
    public function forbidden(int $code = 0, $message = '请求权限不足.'): \Illuminate\Http\JsonResponse
    {
        $this->errCode = $code;
        $this->message = $message;
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN;
        return $this->response();
    }

    //404
    public function notFound(int $code = 0, $message = '请求资源不存在.'): \Illuminate\Http\JsonResponse
    {
        $this->errCode = $code;
        $this->message = $message;
        $this->httpStatus = \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND;
        return $this->response();
    }


    private function response(): \Illuminate\Http\JsonResponse
    {
        //组装返回内容
        $responseData = [
            'error_code' => $this->errCode,
            'message' => $this->message,
            'data' => $this->responseData,
        ];

        //如果meta数据为空，则不返回。
        $data = Collection::make($this->data);
        $meta = Collection::make($this->meta);
        if ($data->isNotEmpty() && $meta->isEmpty()) {
            $responseData['data'] = ['data' => $this->data];
        }

        //如果开启debug，则返回错误内容，供开发者查阅
        if (config('app.debug', true)) {
            $responseData['error'] = $this->error;
            $responseData['debug'] = $this->debug;
        }

        return \Illuminate\Support\Facades\Response::json($responseData, $this->httpStatus);
    }
}
