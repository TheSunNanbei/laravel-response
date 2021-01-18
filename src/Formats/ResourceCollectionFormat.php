<?php


namespace NanBei\Response\Formats;


use Illuminate\Http\Resources\Json\ResourceCollection;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResourceCollectionFormat
{
    public function formatData(ResourceCollection $data): array
    {
        $resource = $data->resource;

        //处理分页数据
        if ($resource instanceof LengthAwarePaginator){
            $lengthAwarePaginatorFormat = new LengthAwarePaginatorFormat();
            return $lengthAwarePaginatorFormat->formatData($resource);
        }

        return [
            'data' => $resource
        ];
    }
}
