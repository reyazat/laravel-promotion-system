<?php

namespace App\Http\Resources\Promotion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $code
 * @property mixed $is_available
 * @property mixed $discount
 * @property mixed $usage_limit
 * @property mixed $limit_num
 * @property mixed $have_dates
 * @property mixed $dates
 * @property mixed $usage_count
 * @property mixed $created_at
 */
class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'is_available' => $this->is_available,
            'discount' => $this->discount,
            'usage_limit' => $this->usage_limit,
            'limit_num' => $this->limit_num,
            'have_dates' => $this->have_dates,
            'dates' => $this->dates,
            'usage_count' => $this->usage_count,
            'created_at' => $this->created_at,
        ];
    }
}
