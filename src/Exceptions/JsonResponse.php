<?php


namespace NanBei\Response\Exceptions;


use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use NanBei\Response\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

trait JsonResponse
{
    public function unauthenticated($request, $e)
    {
        $message = $e->getMessage();
        return Response::unauthorized(null, $message);
    }

    public function invalidJson($request, $e)
    {
        $message = $e->getMessage();
        $debug = $e instanceof ValidationException ? $e->errors() : [];
        return Response::validateFail(null, $message, null, $debug);
    }

    public function prepareJsonResponse($request, $e)
    {
        try {
            $code = $this->isHttpException($e) ? $e->getStatusCode() : 500;
            switch ($code) {
                //未授权
                case HttpResponse::HTTP_UNAUTHORIZED:
                    $response = $this->unauthenticated($request, $e);
                    break;
                //参数错误
                case HttpResponse::HTTP_UNPROCESSABLE_ENTITY:
                    $response = $this->invalidJson($request, $e);
                    break;
                //没有权限
                case HttpResponse::HTTP_FORBIDDEN:
                    $response = Response::forbidden(null, $e->getMessage());
                    break;
                //资源不存在
                case HttpResponse::HTTP_NOT_FOUND:
                    $message = $e->getMessage();
                    $response = Response::notFound(null, empty($message) ? null : $message);
                    break;
                default:
                    $response = $this->error($request, $e);
                    break;
            }
        } catch (\Exception $e) {
            $response = $this->error($request, $e);
        } catch (\Error $e) {
            $response = $this->error($request, $e);
        }
        return $response;
    }

    private function error($request, $e)
    {
        return Response::error(
            null,
            null,
            $e->getMessage(),
            $this->debug($request, $e)
        );
    }

    private function debug($request, $exception): array
    {
        return [
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => collect($exception->getTrace())->map(
                static function ($trace) {
                    return Arr::except($trace, ['args']);
                }
            )->all()
        ];
    }
}
