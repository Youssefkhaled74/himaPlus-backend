<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;

class ShippingMethodController extends Controller
{
    public function index(): JsonResponse
    {
        $methods = ShippingMethod::active()
            ->ordered()
            ->get()
            ->map(fn (ShippingMethod $method) => [
                'id' => $method->id,
                'name' => $method->name,
                'description' => $method->description,
                'base_price' => (float) $method->base_price,
                'price_per_kg' => (float) $method->price_per_kg,
                'icon' => $method->icon,
            ]);

        return responseJson(200, __('messages.success'), $methods);
    }
}
