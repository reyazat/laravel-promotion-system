<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use JsonSerializable;

class DummyResource extends AbstractResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return Model|array|JsonSerializable|Arrayable
     */
    public function toArray(Request $request): Model|array|JsonSerializable|Arrayable
    {
        $data = [];

        if (!empty($this->resource) && !is_bool($this->resource)) {
            /** @var Model $model */
            $model = $this->resource;
            $data = is_array($model) ? $model : $model->toArray();
        }

        return $data;
    }
}
