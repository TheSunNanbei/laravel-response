<?php


namespace NanBei\Response\Formats;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use NanBei\Response\Facades\Basic;

class JsonResourceFormat
{
    public function formatData(JsonResource $data): array
    {
        $resource = $data->resource;

        //处理分页数据
        if ($resource instanceof LengthAwarePaginator){
            $lengthAwarePaginatorFormat = new LengthAwarePaginatorFormat();
            return $lengthAwarePaginatorFormat->formatData($resource);
        }

        return [
            'data' => $resource ?? Basic::defaultValue()
        ];
    }
}
