<?php


namespace NanBei\Response\Utils;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PaginateUtil
{
    public function paginates(LengthAwarePaginator $data): array
    {
        return [
            'total' => $data->total(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'per_page' => $data->perPage(),
        ];
    }

    public function simplePagenates(Paginator $data)
    {
        return [
            'has_more' => $data->hasMorePages(),
            'per_page' => $data->perPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'current_page' => $data->currentPage(),
        ];
    }
}
