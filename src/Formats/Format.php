<?php


namespace NanBei\Response\Formats;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use NanBei\Response\Facades\Basic;

class Format
{
    public function format($data)
    {
        $formatClass = $this;
        //集合类型处理
        if ($data instanceof ResourceCollection) {
            $formatClass = new ResourceCollectionFormat();
        }
        //jsonResource类型处理
        if ($data instanceof JsonResource) {
            $formatClass = new JsonResourceFormat();
        }
        //分页类型处理
        if ($data instanceof LengthAwarePaginator) {
            $formatClass = new LengthAwarePaginatorFormat();
        }

        return $formatClass->formatData($data);
    }

    public function formatData($data)
    {
        if (is_null($data)) {
            return ['data' => Basic::defaultValue()];
        }
        $data = Collection::make($data);
        $first = $data->first();

        if (is_array($first) || is_object($first)) {
            return [
                'data' => $data->get('data', $data),
                'meta' => $data->get('meta', [])
            ];
        }

        return ['data' => $data];
    }
}
