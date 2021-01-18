<?php


namespace NanBei\Response\Utils;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
}
