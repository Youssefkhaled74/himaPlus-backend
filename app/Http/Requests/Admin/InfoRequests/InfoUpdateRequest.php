<?php

namespace App\Http\Requests\Admin\InfoRequests;

use Illuminate\Foundation\Http\FormRequest;

class InfoUpdateRequest extends FormRequest
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
        // $id = $this->route('id'); // get from route
        // $id = $this->request->get('user_id'); // get from in blade
        return [
            'mobile' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facebook' => 'required|string|url',
            'instagram' => 'required|string|url',
            'twitter' => 'required|string|url',
            'snapchat' => 'required|string|url',
            'tiktok' => 'required|string|url',
            'vat' => 'required|string',
            'desc' => 'nullable|string',
            'message' => 'nullable|string',
            'vision' => 'nullable|string',

            'asks' => 'nullable|array',
            'asks.*.head' => 'required|string',
            'asks.*.body' => 'required|string',
            
            'abouts' => 'nullable|array',
            'abouts.*.head' => 'required|string',
            'abouts.*.body' => 'required|string',
            
            'privacy_policies' => 'nullable|array',
            'privacy_policies.*.head' => 'required|string',
            'privacy_policies.*.body' => 'required|string',
            
            'terms' => 'nullable|array',
            'terms.*.head' => 'required|string',
            'terms.*.body' => 'required|string',
        ];
    }
}
