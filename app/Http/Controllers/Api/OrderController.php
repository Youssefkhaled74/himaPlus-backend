<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\InfoRepository;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\Eloquent\Admin\ProductRepository;
use App\Jobs\NewOrderMailJob;
use App\Jobs\OrderUpdatesMailJob;
use App\Mail\NewOrderMail;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
// use App\Http\ServicesLayer\FairbaseServices\FairbaseService;
use App\Http\ServicesLayer\PaymobServices\PaymobService;
use App\Http\ServicesLayer\ArbServices\ArbPaymentService;
use App\Traits\PushNotificationsTrait;

class OrderController extends Controller
{

    use PushNotificationsTrait;

    public $order;
    public $orderItem;
    public $product;
    public $coupon;
    public $productRepository;
    public $infoRepository;
    public $offer;
    public $notification;
    // public $fairbaseService;
    public $paymobService;
    public $arbPaymentService;

    public function __construct(
        Order $order, OrderItem $orderItem, Product $product, ProductRepository $productRepository, InfoRepository $infoRepository,
        Coupon $coupon, Offer $offer, Notification $notification, PaymobService $paymobService, ArbPaymentService $arbPaymentService
    ){
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->product = $product;
        $this->coupon = $coupon;
        $this->notification = $notification;
        $this->productRepository = $productRepository;
        $this->infoRepository = $infoRepository;
        // $this->fairbaseService = $fairbaseService;
        $this->offer = $offer;
        $this->paymobService = $paymobService;
        $this->arbPaymentService = $arbPaymentService;
        $this->middleware('auth:api', ['except' => []]);
    }

    private function resolveVatRate($info): int
    {
        // VAT is a percentage; keep it in a safe DB range.
        $rawVat = (int)($info?->vat ?? 10);
        return max(0, min(100, $rawVat));
    }

    public function myOrders(Request $request, $offset, $limit)
    {
        $user = auth()->user();
        $orders = $user->orders()->when($request->orders_type, function($q) use($request){
            $q->where('order_type', $request->orders_type);
        })->when($request->schedule_requests, function($qq) use($request){
            $qq->where('request_type', (int)$request->schedule_requests);
        })->with([
            'items.product', 'timeline', 'provider', 'offers', 'offer'
        ])->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, __('messages.success'), $orders);
    }
    
    public function randomOrders(Request $request, $offset, $limit)
    {
        $user = auth()->user();
        if ((int) $user->user_type !== 2) {
            return responseJson(403, __('messages.unauthorized'));
        }
        $orders = $this->order::whereNull('provider_id')
        ->when($request->orders_type, function($q) use($request){
            $q->where('order_type', $request->orders_type);
        })->when($request->schedule_requests, function($qq) use($request){
            $qq->where('request_type', (int)$request->schedule_requests);
        })->with([
            'items.product', 'timeline', 'user', 'offers', 'offer'
        ])->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, __('messages.success'), $orders);
    }

    public function providerOrders(Request $request, $offset, $limit)
    {
        $user = auth()->user();
        $orders = $user->provider_orders()->when($request->orders_type, function($q) use($request){
            $q->where('order_type', $request->orders_type);
        })->when($request->schedule_requests, function($qq) use($request){
            $qq->where('request_type', (int)$request->schedule_requests);
        })->with([
            'items.product', 'timeline', 'provider', 'offers', 'offer'
        ])->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, __('messages.success'), $orders);
    }

    public function order($id)
    {
        $user = auth()->user();
        $order = $this->order->where('id', $id)->where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('provider_id', $user->id);
        })->with([
            'items.product', 'timeline', 'provider', 'user', 'offer.provider', 'offers.provider', 'partial_receive'
        ])->first();
        if (is_null($order)) {
            return responseJson(404, __('messages.not_found', ['item' => 'Order']));
        }
        return responseJson(200, __('messages.success'), $order);
    }

    public function updateOrder(Request $request, $id)
    {
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline', 'partial_receive'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, __('messages.deleted_order'));
            }
            if ($order) {
                $data = [];
                if (isset($request->issue) && !is_null($request->issue)) {
                    $data['issue_description'] = is_null($order->issue_description) ? $request->issue : $order->issue_description .' / '. $request->issue;
                }
                $order->update($data);
            } else {
                return responseJson(500, __('messages.not_found', ['item' => 'Order']));
            }

            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function checkCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|exists:coupons,name',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        return responseJson(200, __('messages.success'), $this->coupon->where('name', $request->coupon)->active()->unArchive()->first());
    }

    public function makeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'coupon' => 'nullable|exists:coupons,name',
            'shipping_method_id' => 'nullable|exists:shipping_methods,id',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            $coupon = null;
            $coupon_id = null;
            $orderItems = [];
            $user = auth()->user();
            $info = $this->infoRepository->getfirst();
            $vatRate = $this->resolveVatRate($info);
            $cartItems = $user->cart()->with('product')->get();
            if ($cartItems->isEmpty()) {
                return responseJson(400, __('messages.bad_request'), __('messages.cart_empty'));
            }
            $byProviders = $cartItems->groupBy(fn ($row) => optional($row->product)->provider_id);
            if (isset($request->coupon) && !is_null($request->coupon)) {
                $coupon = $this->coupon->where('name', $request->coupon)->active()->unArchive()->first();
            }

            DB::beginTransaction();
            foreach ($byProviders as $providerItems) {
                
                $itemsCost = [];
                $orderItems = [];
                $provider_id = null;
                foreach ($providerItems as $i => $item) {
                    $orderItems [] = [
                        'quantity' => $item->quantity,
                        'product_id' => $item->product_id,
                        'item_price' => $item->product?->price,
                        'total_price' => $item->product?->price * $item->quantity,
                    ];
                    $provider_id = $item->product?->provider_id ?? null;
                    $itemCost = (int)$item->quantity * (float)$item->product?->price;
                    $itemsCost [] = $itemCost;
                }
                $grandTotal = array_sum($itemsCost);
                $vatAmount = $grandTotal * ($vatRate / 100);
                $discount = 0;
                $totalBeforeDiscount = $grandTotal + $vatAmount;

                if (!is_null($coupon)) {
                    if ($coupon && !is_null($coupon)) {
                        $coupon_id = $coupon->id;
                        if((int)$coupon->type == 1) {
                            $discount = (float)$coupon->amount;
                        }else if((int)$coupon->type == 2) {
                            $rate = max(0, min(100, (float) $coupon->amount));
                            $discount = round($grandTotal * ($rate / 100), 2);
                        }
                    }
                }
                $discount = max(0, min((float)$discount, (float)$totalBeforeDiscount));
                
                $order = $this->order->create([
                    'user_id' => $user->id, 
                    'coupon_id' => $coupon_id, 
                    'discount' => $discount, 
                    'provider_id' => $provider_id ?? null, 
                    'order_type' => 1, 
                    'address' => $request->address, 
                    'vat' => $vatRate, 
                    'vat_amount' => $vatAmount, 
                    'items_cost' => $grandTotal, 
                    'total_before_discount' => $totalBeforeDiscount, 
                    'total_cost' => $totalBeforeDiscount - $discount, 
                    'shipping_method_id' => $request->shipping_method_id ?? null,
                ]);
                $order->timeline()->create([
                    'timeline_no' => 1,
                    'action_at' => now(),
                    'user_id' => $user->id,
                ]);
                if (count($orderItems) > 0) {
                    $order->items()->createMany($orderItems);
                }

                $notificationArr[0] = [
                    'title' => __('messages.new_order_received'), 'content' => __('messages.order_sent_to_provider'), 'user_id' => $user->id, 
                    'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                    'created_at' => now(), 'updated_at' => now()
                ];
                
                if (!is_null($order->provider_id)) {
                    $notificationArr[1] = [
                        'title' => __('messages.new_order_received'), 'content' => __('messages.new_order_received'), 'user_id' => $order->provider_id, 
                        'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                        'created_at' => now(), 'updated_at' => now()
                    ];
                    $provider = $order->provider;
                    $this->targetNewOrderMailJob($provider?->email, $order->id);
                    $this->targetFairbaseServicePushNotification(
                        $provider?->fcm_token, $notificationArr[1]['title'], $notificationArr[1]['content'], 1, $order->id
                    );
                }
                $this->notification->query()->insert($notificationArr);
                
                try {
                    $this->targetNewOrderMailJob($user?->email, $order->id);
                    // $this->targetFairbaseServicePushNotification(
                    //     $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
                    // );
                } catch (\Throwable $notificationEx) {
                    report($notificationEx);
                }

            }
            if (count($orderItems) > 0) {
                $user->cart()->delete();
            }
            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Throwable $e){
            DB::rollBack();
            report($e);
            $errorMessage = $e->getMessage() ?: 'Unknown error';
            $errorDetails = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            return responseJson(500, $errorMessage, $errorDetails);
        }
    }

    public function makeQuotation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'nullable|string',
            'provider_id' => 'nullable|exists:users,id',
            'request_type' => 'nullable|in:1,2',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'notes' => 'nullable|string|max:1255',
            'budget' => 'nullable|integer',
            'date_time_picker' => 'nullable|date_format:Y-m-d H:i:s',
            'frequency' => 'required_if:request_type,2|string|max:255',
            'delivery_duration' => 'required_if:request_type,2|string|max:255',
            'schedule_start_date' => 'required_if:request_type,2|date_format:Y-m-d H:i:s',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            
            DB::beginTransaction();
            $order = $this->order->create([
                'user_id' => $user->id, 
                'order_type' => 2,
                'provider_id' => $request->provider_id ?? null,
                'address' => $request->address ?? null,
                'request_type' => $request->request_type ?? null,
                'files' => $request->hasFile('files') ? uploadIamges($request->file('files'), "quotations") : null,
                'notes' => $request->notes ?? null,
                'budget' => $request->budget ?? null,
                'date_time_picker' => $request->date_time_picker ?? null,

                'frequency' => $request->frequency ?? null,
                'delivery_duration' => $request->delivery_duration ?? null,
                'schedule_start_date' => $request->schedule_start_date ?? null,
            ]);
            $order->timeline()->create([
                'timeline_no' => 1,
                'action_at' => now(),
                'user_id' => $user->id,
            ]);
            
            $notificationArr[0] = [
                'title' => __('messages.new_order_received'), 'content' => __('messages.order_sent_to_provider'), 'user_id' => $user->id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = [
                    'title' => __('messages.new_order_received'), 'content' => __('messages.new_order_received'), 'user_id' => $order->provider_id, 
                    'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                    'created_at' => now(), 'updated_at' => now()
                ];
                $provider = $order->provider;
                $this->targetNewOrderMailJob($provider?->email, $order->id);
                $this->targetFairbaseServicePushNotification(
                    $provider?->fcm_token, $notificationArr[1]['title'], $notificationArr[1]['content'], 1, $order->id
                );
            }
            $this->notification->query()->insert($notificationArr);
            
            $this->targetNewOrderMailJob($user?->email, $order->id);
            // $this->targetFairbaseServicePushNotification(
            //     $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
            // );

            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function makeMaintenance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_category_id' => 'nullable|exists:categories,id',
            'provider_id' => 'nullable|exists:users,id',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'device_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'nullable|string|max:255',
            'preferred_service_time' => 'nullable|date_format:Y-m-d H:i:s',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            
            DB::beginTransaction();
            $order = $this->order->create([
                'user_id' => $user->id, 
                'order_type' => 3,
                'provider_id' => $request->provider_id ?? null,
                'device_category_id' => $request->device_category_id,
                'files' => $request->hasFile('files') ? uploadIamges($request->file('files'), "quotations") : null,
                'address' => $request->address,
                'device_name' => $request->device_name,
                'serial_number' => $request->serial_number,
                'issue_description' => $request->issue_description,
                'preferred_service_time' => $request->preferred_service_time,
            ]);
            $order->timeline()->create([
                'timeline_no' => 1,
                'action_at' => now(),
                'user_id' => $user->id,
            ]);
            
            $notificationArr[0] = [
                'title' => __('messages.new_order_received'), 'content' => __('messages.order_sent_to_provider'), 'user_id' => $user->id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = ['title' => __('messages.new_order_received'), 'content' => __('messages.new_order_received'), 'user_id' => $order->provider_id, 
                    'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                    'created_at' => now(), 'updated_at' => now()
                ];
                $provider = $order->provider;
                $this->targetNewOrderMailJob($provider?->email, $order->id);
                $this->targetFairbaseServicePushNotification(
                    $provider?->fcm_token, $notificationArr[1]['title'], $notificationArr[1]['content'], 1, $order->id
                );
            }
            $this->notification->query()->insert($notificationArr);
            
            try {
                $this->targetNewOrderMailJob($user?->email, $order->id);
                // $this->targetFairbaseServicePushNotification(
                //     $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
                // );
            } catch (\Throwable $notificationEx) {
                report($notificationEx);
            }

            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            report($e);
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function orderPartialReceive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'offer_id' => 'nullable|exists:offers,id',
            'order_id' => 'required|exists:orders,id',
            'received_quantity' => 'nullable|integer',
            'received_all_quantity' => 'nullable|in:1',
            'reason_for_partial' => 'nullable|string|max:1255',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $request->order_id)->where('user_id', $user->id)->with(['timeline', 'partial_receive'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, __('messages.deleted_order'));
            }
            if ($order) {
                $order->partial_receive()->create([
                    'user_id' => $user->id, 
                    'order_id' => $request->order_id, 
                    'offer_id' => $request->offer_id ?? null, 
                    'files' => $request->hasFile('files') ? uploadIamges($request->file('files'), "orders") : null,
                    'received_quantity' => $request->received_quantity ?? null, 
                    'received_all_quantity' => $request->received_all_quantity ?? 0, 
                    'reason_for_partial' => $request->reason_for_partial ?? null,
                ]);
            } else {
                return responseJson(500, __('messages.not_found', ['item' => 'Order']));
            }

            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function orderTimeline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_type' => 'required|in:1,2,3',
            'timeline_no' => 'required|in:2,3,4,5,6,7,8,9,10,11,12',
            'order_id' => 'required|exists:orders,id',
            'delivery_fee' => ['nullable', 'numeric', 'min:0',
                Rule::requiredIf(fn () =>
                    (int)$request->timeline_no === 2 && (int)$request->order_type === 1
                ),
            ],
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        
        try{
            
            $user = auth()->user();
            if (!(int)$request->timeline_no == 6) {
                if (!(int)$user->user_type == 2) {
                    flash()->error(__('messages.this_action_providers_only'));
                    return back();
                }
            }

            // 1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 
            // 5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected, 
            // 9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier
            DB::beginTransaction();
            $order = $this->order->where('id', $request->order_id)->whereAny(['user_id', 'provider_id'], $user->id)->with(['timeline', 'user'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            $timeline_no = (int)$request->timeline_no;
            $pre_timeline_no = $timeline_no - 1;
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, __('messages.deleted_order'));
            }
            // if (in_array($pre_timeline_no, $timeline_no_arr)) {
                if (!in_array($timeline_no, $timeline_no_arr)) {
                    
                    $order->timeline()->create([
                        'action_at' => now(),
                        'user_id' => $user->id,
                        'timeline_no' => $timeline_no,
                    ]);
                    
                    $step = timelineName($timeline_no);
                    $this->notification->query()->insert([
                        'title' => __('messages.order_status_update', ['step' => $step]), 'content' => __('messages.order_status_update_content', ['id' => $order->id, 'step' => $step]), 'user_id' => $order->user_id, 
                        'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                        'created_at' => now(), 'updated_at' => now()
                    ]);

                    $client = $order->user;
                    $this->targetOrderUpdatesMailJob($client?->email, __('messages.order_status_update_content', ['id' => $order->id, 'step' => $step]));
                    $this->targetFairbaseServicePushNotification(
                        $client?->fcm_token, __('messages.order_status_update', ['step' => $step]), __('messages.order_status_update_content', ['id' => $order->id, 'step' => $step]), 1, $order->id
                    );

                    $provider = $user;
                    $this->targetOrderUpdatesMailJob($provider?->email, __('messages.order_status_update_content', ['id' => $order->id, 'step' => $step]));
                    $this->targetFairbaseServicePushNotification(
                        $provider?->fcm_token, __('messages.order_status_update', ['step' => $step]), __('messages.order_status_update_content', ['id' => $order->id, 'step' => $step]), 1, $order->id
                    );
                }
            // }else {
            //     return responseJson(500, "there is some steps before this step , please contact technical support");
            // }

            if ((int)$request->timeline_no == 2 && (int)$request->order_type == 1 && isset($request->delivery_fee) && !is_null($request->delivery_fee)) {
                $order->update([
                    'delivery_fee' => $request->delivery_fee,
                ]);
            }

            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function cancelOrder($id)
    {
        try{

            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline', 'provider'])->first();
            DB::beginTransaction();
            if ($order) {
                $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
                if (in_array(2, $timeline_no_arr)) {
                    return responseJson(500, __('messages.cant_cancel_processing'));
                } elseif (in_array(12, $timeline_no_arr)) {
                    return responseJson(500, __('messages.deleted_order'));
                } else {
                    // $order->items()->delete();
                    // $order->timeline()->delete();
                    // $order->delete();
                    $order->timeline()->create([
                        'action_at' => now(),
                        'user_id' => $user->id,
                        'timeline_no' => 12,
                    ]);
                }
            } else {
                return responseJson(500, __('messages.not_found', ['item' => 'Order']));
            }

            $notificationArr[0] = [
                'title' => __('messages.order_canceled_title'), 'content' => __('messages.order_canceled_content', ['id' => $order->id]), 'user_id' => $order->user_id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = [
                    'title' => __('messages.order_canceled_title'), 'content' => __('messages.order_canceled_content', ['id' => $order->id]), 'user_id' => $order->provider_id, 
                    'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                    'created_at' => now(), 'updated_at' => now()
                ];
                $provider = $order->provider;
                $this->targetOrderUpdatesMailJob($provider?->email, __('messages.order_canceled_content', ['id' => $order->id]));
                $this->targetFairbaseServicePushNotification(
                    $provider?->fcm_token, __('messages.order_canceled_title'), __('messages.order_canceled_content', ['id' => $order->id]), 1, $order->id
                );
            }
            $this->notification->query()->insert($notificationArr);

            $this->targetOrderUpdatesMailJob($user?->email, __('messages.order_canceled_content', ['id' => $order->id]));
            $this->targetFairbaseServicePushNotification(
                $user?->fcm_token, __('messages.order_canceled_title'), __('messages.order_canceled_content', ['id' => $order->id]), 1, $order->id
            );

            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function onlinePayment($id)
    {
        try {
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline'])->first();
            if (is_null($order)) {
                return responseJson(404, __('messages.not_found', ['item' => 'Order']));
            }
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, __('messages.deleted_order'));
            }
            if ((int) $order->payment_status === 1) {
                return responseJson(200, __('messages.this_order_already_paid'), [
                    'gateway' => 'arb',
                    'order_id' => $order->id,
                ]);
            }

            $device_type = 'mobile';
            $errorDetails = null;
            $payment = $this->arbPaymentService->generatePaymentUrl($order, $user, $device_type, request(), $errorDetails);
            if (!$payment) {
                return responseJson(500, __('messages.arb_link_failed'), $errorDetails);
            }
            return responseJson(200, __('messages.success'), [
                'payment_url' => $payment['payment_url'] ?? null,
                'payment_id' => $payment['payment_id'] ?? null,
                'track_id' => $payment['track_id'] ?? null,
                'gateway' => $payment['gateway'] ?? 'arb',
                'redirect_method' => $payment['redirect_method'] ?? 'get',
                'redirect_fields' => $payment['redirect_fields'] ?? null,
            ]);
        } catch (\Exception $ex) {
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function offersActions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:2,3',
            'rejected_reson' => 'required_if:action,3|string|max:1255',
            'offer_id' => 'required|exists:offers,id',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            
            $user = auth()->user();

            // 2 => accepted, 3 => rejected
            DB::beginTransaction();
            $offer = $this->offer->where('id', $request->offer_id)->with(['order', 'provider'])->first();
            if (is_null($offer) || is_null($offer->order) || (int) $offer->order->user_id !== (int) $user->id) {
                return responseJson(403, __('messages.unauthorized'));
            }
            if ($offer->status == 1) {

                $action = (int)$request->action;
                $updateArr['status'] = $action;
                if ($action == 3) {
                    $updateArr['rejected_reson'] = $request->rejected_reson;
                }
                $offer->update($updateArr);
                if ($offer->order && !is_null($offer->order) && $action == 2) {
                    
                    $info = $this->infoRepository->getfirst();
                    $vatRate = $this->resolveVatRate($info);
                    $grandTotal = $offer->cost;
                    $vatAmount = $grandTotal * ($vatRate / 100);
                    $offer->order->update([
                        'vat' => $vatRate, 
                        'vat_amount' => $vatAmount, 
                        'items_cost' => $grandTotal, 
                        'total_before_discount' => $grandTotal + ($vatAmount), 
                        'total_cost' => ($grandTotal + ($vatAmount)), 
                        'offer_id' => $offer->id,
                        'provider_id' => $offer->provider_id,
                    ]);                
                    $offer->order->timeline()->create([
                        'action_at' => now(),
                        'user_id' => $user->id,
                        'timeline_no' => 9,
                    ]);
                }
            }else {
                return responseJson(500, __('messages.this_offer_has_actions'));
            }
            
            $offetAction = '';
            if ($request->action == 2) {
                $offetAction = __('messages.offer_created');
            }elseif ($request->action == 3) {
                $offetAction = __('messages.notification_type_offer_rejected');
            }
            $this->notification->query()->insert([
                'title' => __('messages.offer_updates'), 'content' => __('messages.offer_updated_content', ['id' => $offer->id, 'action' => $offetAction]), 'user_id' => $offer->provider_id, 
                'order_id' => $offer->order_id, 'serviceable_id' => $offer->order_id, 'serviceable_type' => 'App\Models\Order', 
                'created_at' => now(), 'updated_at' => now(), 
            ]);
            $this->targetOrderUpdatesMailJob($user?->email, __('messages.offer_updated_content', ['id' => $offer->id, 'action' => $offetAction]));  
            $this->targetOrderUpdatesMailJob($offer->provider?->email, __('messages.offer_updated_content', ['id' => $offer->id, 'action' => $offetAction]));

            DB::commit();
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function makeOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'cost' => 'required|integer',
            'delivery_time' => 'required|string|max:255',
            // 'delivery_time' => 'required|date_format:Y-m-d H:i:s',
            'warranty' => 'required|string|max:1255',
            'order_id' => 'required|exists:orders,id',
            'notes' => 'nullable|string|max:1255',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            if ((int) $user->user_type !== 2) {
                return responseJson(403, __('messages.unauthorized'));
            }
            
            DB::beginTransaction();
            $offer = $this->offer->create([
                'status' => 1, 
                'provider_id' => $user->id,
                'cost' => $request->cost ?? null, 
                'notes' => $request->notes ?? null, 
                'warranty' => $request->warranty ?? null, 
                'order_id' => $request->order_id ?? null, 
                'delivery_time' => $request->delivery_time ?? null, 
                'files' => $request->hasFile('files') ? uploadIamges($request->file('files'), "quotations") : null,
            ]);
            if (!is_null($offer->order)) {
                $offer->order->timeline()->create([
                    'action_at' => now(),
                    'user_id' => $user->id,
                    'timeline_no' => 7,
                ]);
            }
            DB::commit();

            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function editOffer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'cost' => 'required|integer',
            'delivery_time' => 'required|string|max:255',
            // 'delivery_time' => 'required|date_format:Y-m-d H:i:s',
            'warranty' => 'required|string|max:1255',
            'notes' => 'nullable|string|max:1255',
        ]);
        if ($validator->fails()) {
            return responseJson(400, __('messages.bad_request'), $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            if ((int) $user->user_type !== 2) {
                return responseJson(403, __('messages.unauthorized'));
            }
            
            DB::beginTransaction();
            $offer = $this->offer->where('provider_id', $user->id)->where('id', $id)->first();
            $offer->update([
                'cost' => $request->cost ?? $offer->cost, 
                'notes' => $request->notes ?? $offer->notes, 
                'warranty' => $request->warranty ?? $offer->warranty, 
                'delivery_time' => $request->delivery_time ?? $offer->delivery_time, 
            ]);
            if($request->hasFile('files')){
                $offer->update([
                    'files' => uploadIamges($request->file('files'), "quotations")
                ]);
            }
            DB::commit();

            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }

    public function deleteOffer($id)
    {
        try{
            $user = auth()->user();
            if ((int) $user->user_type !== 2) {
                return responseJson(403, __('messages.unauthorized'));
            }

            $offer = $this->offer->where('provider_id', $user->id)->where('id', $id)->first();
            if((int)$offer->status == 1){
                $offer->delete();
            }else {
                return responseJson(500, __('messages.cant_remove_offer_actions'));
            }
            return responseJson(200, __('messages.success'));
        }catch(\Exception $e){
            return responseJson(500, __('messages.something_went_wrong'));
        }
    }


}
