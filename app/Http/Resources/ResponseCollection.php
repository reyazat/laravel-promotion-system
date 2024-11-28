<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResponseCollection extends ResourceCollection
{
    protected $preserveAllQueryParameters = true;

    /**
     * ResponseCollection constructor.
     */
    public function __construct(string $collects, $resource)
    {
        $this->collects = $collects;
        if (($resource instanceof EloquentBuilder || $resource instanceof QueryBuilder)) {
            if (\request()->has('paginate')) {
                $resource = $resource->paginate((int)\request('per-page', 10));
            } else {
                if (!\request()->has('limit') && !\request()->has('count')) {
                    \request()->instance()->query->add(['limit' => 100]);
                }
                $resource = $resource->get();
            }
        }
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $request->has('count') ? $this->collection->count() : $this->collection,
        ];
    }

    protected function preparePaginatedResponse($request): JsonResponse
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (!is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }
}
