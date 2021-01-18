<?php


namespace NanBei\Response\Formats;


use NanBei\Response\Facades\PaginateUtil;

class LengthAwarePaginatorFormat
{
    public function formatData($data): array
    {
        $formatData = $data->items();
        $paginate = PaginateUtil::paginates($data);
        return [
            'data' => $formatData,
            'meta' => $paginate
        ];
    }
}
