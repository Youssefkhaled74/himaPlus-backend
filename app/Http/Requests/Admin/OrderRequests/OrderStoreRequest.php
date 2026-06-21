<?php

namespace App\Http\Requests\Admin\OrderRequests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'provider_id' => ['nullable', 'integer', 'exists:users,id'],
            'device_category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'order_type' => ['required', 'integer', 'in:1,2,3'],
            'items_cost' => ['nullable', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
