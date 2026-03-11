<?php

namespace App\Http\Requests\Admin\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
        $authAdmin = auth()->guard('admin')->user();
        $targetId = (int) ($this->route('id') ?? ($authAdmin->id ?? 0));
        return [
            'name' => 'nullable|string|max:60',
            'password' => 'nullable|confirmed|max:30',
            'file' => 'nullable|mimes:jpeg,png,jpg,webp,webm|max:2048',
            'email' => 'nullable|string|max:60|unique:admins,email,' . $targetId,
            'phone' => 'nullable|max:60|unique:admins,phone,' . $targetId,
        ];
    }
}
