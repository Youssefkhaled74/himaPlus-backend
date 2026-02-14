<?php

namespace App\Http\Requests\Admin\CouponRequests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
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
        $id = $this->route('id'); // get from route
        // $id = $this->request->get('user_id'); // get from in blade
        return [
            'name' => 'required|string|max:254|unique:coupons,name,' . $id,
            'amount' => 'required|integer',
            'type' => 'required|in:1,2',
        ];
    }
}
