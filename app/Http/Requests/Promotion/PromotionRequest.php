<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'discount' => 'required|array',
            'is_available' => 'nullable|boolean',
            'avb_days' => 'nullable|array',
            'times' => 'nullable|array',
            'usage_limit' => 'nullable|array',
            'limit_num' => 'nullable|integer',
            'have_dates' => 'nullable|boolean',
            'dates' => 'nullable|array',
        ];
    }
}
