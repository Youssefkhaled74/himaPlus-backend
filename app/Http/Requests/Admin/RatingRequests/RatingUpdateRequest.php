<?php

namespace App\Http\Requests\Admin\RatingRequests;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
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
            'comment' => 'nullable|string|max:2000',
            'rating' => 'required|numeric|min:1|max:5',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
