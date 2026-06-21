<?php

namespace App\Http\Requests\Admin\OrderRequests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'provider_id' => ['nullable', 'integer', 'exists:users,id'],
            'device_category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'coupon_id' => ['nullable', 'integer', 'exists:coupons,id'],
            'offer_id' => ['nullable', 'integer', 'exists:offers,id'],
            'order_type' => ['nullable', 'integer', 'in:1,2,3'],
            'request_type' => ['nullable', 'integer', 'in:1,2'],
            'payment_type' => ['nullable', 'string', 'max:50'],
            'payment_status' => ['nullable', 'integer', 'in:0,1'],
            'vat' => ['nullable', 'numeric', 'min:0'],
            'vat_amount' => ['nullable', 'numeric', 'min:0'],
            'delivery_fee' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'items_cost' => ['nullable', 'numeric', 'min:0'],
            'total_before_discount' => ['nullable', 'numeric', 'min:0'],
            'total_cost' => ['nullable', 'numeric', 'min:0'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'device_name' => ['nullable', 'string', 'max:200'],
            'budget' => ['nullable', 'string', 'max:100'],
            'quotation_type' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:200'],
            'issue_description' => ['nullable', 'string', 'max:1000'],
            'date_time_picker' => ['nullable', 'string', 'max:100'],
            'preferred_service_time' => ['nullable', 'string', 'max:100'],
            'delivery_duration' => ['nullable', 'string', 'max:100'],
            'frequency' => ['nullable', 'string', 'max:100'],
            'schedule_start_date' => ['nullable', 'date'],
            'gateway_name' => ['nullable', 'string', 'max:50'],
            'gateway_payment_id' => ['nullable', 'string', 'max:100'],
            'gateway_track_id' => ['nullable', 'string', 'max:100'],
            'getway_transaction_id' => ['nullable', 'string', 'max:100'],
        ];
    }
}
