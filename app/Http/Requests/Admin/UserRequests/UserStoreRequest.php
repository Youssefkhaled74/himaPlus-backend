<?php

namespace App\Http\Requests\Admin\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'branch' => 'nullable|string|max:100',
            'email' => 'required|string|max:255|unique:users,email',
            'mobile' => 'required|string|max:255|unique:users,mobile',
            'file' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'password' => 'required|confirmed|max:30',
            'tax_number' => 'nullable|string|max:30',
            'cr_number' => 'nullable|string|max:30',
            'cr_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'location' => 'nullable|string|max:255',
            'user_type' => 'required|in:1,2,3',
        ];
    }
}
