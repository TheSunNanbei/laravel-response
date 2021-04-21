<?php
/**
 * Created by PhpStorm.
 * Author: xinu x-php@outlook.com
 * Coding Standard: PSR2
 * DateTime: 2021-04-21 16:41
 */


namespace NanBei\Response\Formats;


use NanBei\Response\Facades\PaginateUtil;

class PaginatorFormat
{
    public function formatData($data): array
    {
        $formatData = $data->items();
        $pagination = PaginateUtil::simplePagenates($data);
        return [
            'data' => $formatData,
            'meta' => ['pagination' => $pagination]
        ];
    }
}
