<?php

namespace App\Http\Requests\Admin\ProductRequests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'           => ['required', 'string', 'min:2', 'unique:products,name', 'max:255'],
            'provider_id'    => ['required', 'integer', 'exists:users,id'],
            'category_id'    => ['required', 'integer', 'exists:categories,id'],
            'desc'           => ['required', 'string', 'max:1255'],
            'price'          => ['required', 'numeric', 'min:0', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],

            'file'            => ['required', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],
            'files'           => ['nullable', 'array', 'max:10'],
            'files.*'         => ['file', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120'],

            'imaging_type'     => ['nullable', 'string', 'max:255'],
            'power'            => ['nullable', 'string', 'max:255'],
            'manufacture_date' => ['nullable', 'date', 'before_or_equal:today'],
            'production_date'  => ['nullable', 'date', 'before_or_equal:today'],
            'expiry_date'      => ['nullable', 'date', 'after:manufacture_date'],
            'weight'        => ['nullable', 'string', 'max:255'],
            'dimensions'    => ['nullable', 'string', 'max:255'],
            'warranty'      => ['nullable', 'string', 'max:255'],
            'origin_id'     => ['nullable', 'integer', 'exists:countries,id'],
            'is_offer'     => ['nullable', 'in:1,0'],
            'is_special'     => ['nullable', 'in:1,0'],
        ];
    }
}
