<?php

namespace App\Http\Resources;

use Illuminate\Support\Arr;

class PaginatedResourceResponse extends \Illuminate\Http\Resources\Json\PaginatedResourceResponse
{
    protected function meta($paginated): array
    {
        return Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
            'links',
        ]);
    }
}
