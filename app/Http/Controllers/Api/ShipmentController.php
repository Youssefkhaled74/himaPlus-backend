<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentImage;
use App\Models\ShippingMethod;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request, int $orderId): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $order = Order::where('id', $orderId)
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('provider_id', $user->id);
            })
            ->first();

        if (!$order) {
            return responseJson(404, __('messages.not_found', ['item' => 'Order']));
        }

        $shipments = Shipment::where('order_id', $orderId)
            ->with(['images', 'shippingMethod'])
            ->orderByDesc('id')
            ->get()
            ->map(function (Shipment $shipment) {
                return [
                    'id' => $shipment->id,
                    'order_id' => $shipment->order_id,
                    'tracking_number' => $shipment->tracking_number,
                    'status' => $shipment->status,
                    'status_label' => $shipment->status_label,
                    'shipped_at' => $shipment->shipped_at?->toDateTimeString(),
                    'delivered_at' => $shipment->delivered_at?->toDateTimeString(),
                    'notes' => $shipment->notes,
                    'shipping_method' => $shipment->shippingMethod ? [
                        'id' => $shipment->shippingMethod->id,
                        'name' => $shipment->shippingMethod->name,
                    ] : null,
                    'images' => $shipment->images->map(fn (ShipmentImage $img) => [
                        'id' => $img->id,
                        'image_path' => $img->image_path,
                        'image_url' => $img->image_url,
                        'caption' => $img->caption,
                    ]),
                    'created_at' => $shipment->created_at?->toDateTimeString(),
                ];
            });

        return responseJson(200, __('messages.success'), $shipments);
    }

    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();

        $shipment = Shipment::with(['images', 'shippingMethod', 'order'])
            ->find($id);

        if (!$shipment) {
            return responseJson(404, __('messages.not_found', ['item' => 'Shipment']));
        }

        $order = $shipment->order;
        if ((int) $order->user_id !== (int) $user->id && (int) $order->provider_id !== (int) $user->id) {
            return responseJson(403, __('messages.unauthorized'));
        }

        return responseJson(200, __('messages.success'), [
            'id' => $shipment->id,
            'order_id' => $shipment->order_id,
            'tracking_number' => $shipment->tracking_number,
            'status' => $shipment->status,
            'status_label' => $shipment->status_label,
            'shipped_at' => $shipment->shipped_at?->toDateTimeString(),
            'delivered_at' => $shipment->delivered_at?->toDateTimeString(),
            'notes' => $shipment->notes,
            'shipping_method' => $shipment->shippingMethod ? [
                'id' => $shipment->shippingMethod->id,
                'name' => $shipment->shippingMethod->name,
                'description' => $shipment->shippingMethod->description,
            ] : null,
            'images' => $shipment->images->map(fn (ShipmentImage $img) => [
                'id' => $img->id,
                'image_path' => $img->image_path,
                'image_url' => $img->image_url,
                'caption' => $img->caption,
                'sort_order' => $img->sort_order,
            ]),
            'created_at' => $shipment->created_at?->toDateTimeString(),
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'shipping_method_id' => 'nullable|exists:shipping_methods,id',
            'tracking_number' => 'nullable|string|max:255',
            'status' => 'nullable|in:1,2,3,4,5',
            'notes' => 'nullable|string|max:2000',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|file|mimes:jpeg,png,jpg,webp,pdf|max:10240',
            'caption' => 'nullable|array',
            'caption.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }

        $user = auth()->user();

        $order = Order::where('id', $request->order_id)
            ->where('provider_id', $user->id)
            ->first();

        if (!$order) {
            return responseJson(403, __('messages.unauthorized'));
        }

        try {
            DB::beginTransaction();

            $shipment = Shipment::create([
                'order_id' => $request->order_id,
                'shipping_method_id' => $request->shipping_method_id ?? null,
                'tracking_number' => $request->tracking_number ?? null,
                'status' => $request->status ?? Shipment::STATUS_SHIPPED,
                'shipped_at' => now(),
                'notes' => $request->notes ?? null,
            ]);

            if ($request->hasFile('images')) {
                $captions = $request->caption ?? [];
                foreach ($request->file('images') as $index => $file) {
                    $imagePath = uploadIamge($file, 'shipments');
                    ShipmentImage::create([
                        'shipment_id' => $shipment->id,
                        'image_path' => $imagePath,
                        'caption' => $captions[$index] ?? null,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            $shipment->load(['images', 'shippingMethod']);

            return responseJson(200, __('messages.success'), [
                'id' => $shipment->id,
                'order_id' => $shipment->order_id,
                'tracking_number' => $shipment->tracking_number,
                'status' => $shipment->status,
                'status_label' => $shipment->status_label,
                'shipping_method' => $shipment->shippingMethod ? [
                    'id' => $shipment->shippingMethod->id,
                    'name' => $shipment->shippingMethod->name,
                ] : null,
                'images' => $shipment->images->map(fn (ShipmentImage $img) => [
                    'id' => $img->id,
                    'image_path' => $img->image_path,
                    'image_url' => $img->image_url,
                    'caption' => $img->caption,
                ]),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }
}
