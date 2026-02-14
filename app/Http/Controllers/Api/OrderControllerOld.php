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

    public function __construct(
        Order $order, OrderItem $orderItem, Product $product, ProductRepository $productRepository, InfoRepository $infoRepository,
        Coupon $coupon, Offer $offer, Notification $notification, PaymobService $paymobService
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
        $this->middleware('auth:api', ['except' => []]);
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
        return responseJson(200, "success", $orders);
    }
    
    public function randomOrders(Request $request, $offset, $limit)
    {
        $orders = $this->order::whereNull('provider_id')
        ->when($request->orders_type, function($q) use($request){
            $q->where('order_type', $request->orders_type);
        })->when($request->schedule_requests, function($qq) use($request){
            $qq->where('request_type', (int)$request->schedule_requests);
        })->with([
            'items.product', 'timeline', 'user', 'offers', 'offer'
        ])->offset($offset)->limit(PAGINATION_COUNT)->get();
        return responseJson(200, "success", $orders);
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
        return responseJson(200, "success", $orders);
    }

    public function order($id)
    {
        $order = $this->order->where('id', $id)->with([
            'items.product', 'timeline', 'provider', 'user', 'offer.provider', 'offers.provider', 'partial_receive'
        ])->first();
        return responseJson(200, "success", $order);
    }

    public function updateOrder(Request $request, $id)
    {
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline', 'partial_receive'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, "this order was deleted.");
            }
            if ($order) {
                $data = [];
                if (isset($request->issue) && !is_null($request->issue)) {
                    $data['issue_description'] = is_null($order->issue_description) ? $request->issue : $order->issue_description .' / '. $request->issue;
                }
                $order->update($data);
            } else {
                return responseJson(500, "not found");
            }

            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, "there is some thing wrong , please contact technical support");
        }
    }

    public function checkCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|exists:coupons,name',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        return responseJson(200, "success", $this->coupon->where('name', $request->coupon)->active()->unArchive()->first());
    }

    public function makeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'coupon' => 'nullable|exists:coupons,name',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try{
            $discount = 0;
            $itemsCost = [];
            $orderItems = [];
            $coupon_id = null;
            $provider_id = null;
            $user = auth()->user();
            $info = $this->infoRepository->getfirst();
            $cartItems = $user->cart()->with('product')->get();

            foreach ($cartItems as $i => $item) {
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
            $vatAmount = $grandTotal * (((int)$info?->vat ?? 10) / 100);

            if (isset($request->coupon) && !is_null($request->coupon)) {

                // "id": 3, "name": "Ava Battle 22", amount": 12, type": 2,
                $coupon = $this->coupon->where('name', $request->coupon)->active()->unArchive()->first();
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
            
            DB::beginTransaction();
            $order = $this->order->create([
                'user_id' => $user->id, 
                'coupon_id' => $coupon_id, 
                'discount' => $discount, 
                'provider_id' => $provider_id ?? null, 
                'order_type' => 1, 
                'address' => $request->address, 
		        'vat' => (int)$info->vat, 
                'vat_amount' => $vatAmount, 
                'items_cost' => $grandTotal, 
                'total_before_discount' => $grandTotal + ($vatAmount), 
                'total_cost' => ($grandTotal + ($vatAmount)) - $discount, 
            ]);
            if (count($orderItems) > 0) {
                $order->items()->createMany($orderItems);
                $user->cart()->delete();
            }
            $order->timeline()->create([
                'timeline_no' => 1,
                'action_at' => now(),
                'user_id' => $user->id,
            ]);

            $notificationArr[0] = [
                'title' => 'new order.', 'content' => "your order sended to the provider", 'user_id' => $user->id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = [
                    'title' => 'new order.', 'content' => "you have new order", 'user_id' => $order->provider_id, 
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
            $this->targetFairbaseServicePushNotification(
                $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
            );

            DB::commit();
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
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
                'title' => 'new order.', 'content' => "your order sended to the provider", 'user_id' => $user->id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = [
                    'title' => 'new order.', 'content' => "you have new order", 'user_id' => $order->provider_id, 
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
            $this->targetFairbaseServicePushNotification(
                $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
            );

            DB::commit();
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            'issue_description' => 'nullable|string|max:1255',
            'preferred_service_time' => 'nullable|date_format:Y-m-d H:i:s',
        ]);
        if ($validator->fails()) {
            return responseJson(400, "Bad Request", $validator->errors()->first());
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
                'title' => 'new order.', 'content' => "your order sended to the provider", 'user_id' => $user->id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = ['title' => 'new order.', 'content' => "you have new order", 'user_id' => $order->provider_id, 
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
            $this->targetFairbaseServicePushNotification(
                $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
            );
            // try {
            //     $ddd = $this->targetFairbaseServicePushNotification(
            //         $user?->fcm_token, $notificationArr[0]['title'], $notificationArr[0]['content'], 1, $order->id
            //     );
            //     dd($ddd);
            // } catch (\Exception $e) { dd($e); }

            DB::commit();
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $request->order_id)->where('user_id', $user->id)->with(['timeline', 'partial_receive'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, "this order was deleted.");
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
                return responseJson(500, "not found");
            }

            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        
        try{
            
            $user = auth()->user();
            if (!(int)$request->timeline_no == 6) {
                if (!(int)$user->user_type == 2) {
                    flash()->error("this action for the providers only");
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
                return responseJson(500, "this order was deleted.");
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
                        'title' => "your order has been $step.", 'content' => "your order #$order->id has been $step.", 'user_id' => $order->user_id, 
                        'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                        'created_at' => now(), 'updated_at' => now()
                    ]);

                    $client = $order->user;
                    $this->targetOrderUpdatesMailJob($client?->email, "your order #$order->id has been $step.");
                    $this->targetFairbaseServicePushNotification(
                        $client?->fcm_token, "your order has been $step.", "your order #$order->id has been $step.", 1, $order->id
                    );

                    $provider = $user;
                    $this->targetOrderUpdatesMailJob($provider?->email, "your order #$order->id has been $step.");
                    $this->targetFairbaseServicePushNotification(
                        $provider?->fcm_token, "your order has been $step.", "your order #$order->id has been $step.", 1, $order->id
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
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
                    return responseJson(500, "can’t cancel because this order is already being processed.");
                } elseif (in_array(12, $timeline_no_arr)) {
                    return responseJson(500, "this order was deleted.");
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
                return responseJson(500, "not found");
            }

            $notificationArr[0] = [
                'title' => "order canceled.", 'content' => "the order no #$order->id has been canceled.", 'user_id' => $order->user_id, 
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                'created_at' => now(), 'updated_at' => now()
            ];
            if (!is_null($order->provider_id)) {
                $notificationArr[1] = [
                    'title' => "order canceled.", 'content' => "the order no #$order->id has been canceled.", 'user_id' => $order->provider_id, 
                    'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
                    'created_at' => now(), 'updated_at' => now()
                ];
                $provider = $order->provider;
                $this->targetOrderUpdatesMailJob($provider?->email, "the order no #$order->id has been canceled.");
                $this->targetFairbaseServicePushNotification(
                    $provider?->fcm_token, "order canceled.", "the order no #$order->id has been canceled.", 1, $order->id
                );
            }
            $this->notification->query()->insert($notificationArr);

            $this->targetOrderUpdatesMailJob($user?->email, "the order no #$order->id has been canceled.");
            $this->targetFairbaseServicePushNotification(
                $user?->fcm_token, "order canceled.", "the order no #$order->id has been canceled.", 1, $order->id
            );

            DB::commit();
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
        }
    }

    public function onlinePayment($id)
    {
        try {
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline'])->first();
            if (is_null($order)) {
                return responseJson(404, "not found");
            }
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                return responseJson(500, "this order was deleted.");
            }
            $device_type = 'mobile';
            $total_cost = $order->total_cost + $order->delivery_fee;
            $data['paymob_url'] = $this->paymobService->generatePaymentUrl($total_cost ?? 0, $order->id, $user, $device_type);
            return responseJson(200, "success", $data);
        } catch (\Exception $ex) {
            return responseJson(500, "there is something wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try{
            
            $user = auth()->user();

            // 2 => accepted, 3 => rejected
            DB::beginTransaction();
            $offer = $this->offer->where('id', $request->offer_id)->with(['order', 'provider'])->first();
            if ($offer->status == 1) {

                $action = (int)$request->action;
                $updateArr['status'] = $action;
                if ($action == 3) {
                    $updateArr['rejected_reson'] = $request->rejected_reson;
                }
                $offer->update($updateArr);
                if ($offer->order && !is_null($offer->order) && $action == 2) {
                    
                    $info = $this->infoRepository->getfirst();
                    $grandTotal = $offer->cost;
                    $vatAmount = $grandTotal * (((int)$info?->vat ?? 10) / 100);
                    $offer->order->update([
                        'vat' => (int)$info->vat, 
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
                return responseJson(500, "this offer has actions");
            }
            
            $offetAction = '';
            if ($request->action == 2) {
                $offetAction = 'accepted';
            }elseif ($request->action == 3) {
                $offetAction = 'rejected';
            }
            $this->notification->query()->insert([
                'title' => "offer updates.", 'content' => "the offer no #$offer->id has been $offetAction.", 'user_id' => $offer->provider_id, 
                'order_id' => $offer->order_id, 'serviceable_id' => $offer->order_id, 'serviceable_type' => 'App\Models\Order', 
                'created_at' => now(), 'updated_at' => now(), 
            ]);
            $this->targetOrderUpdatesMailJob($user?->email, "the offer no #$offer->id has been $offetAction.");  
            $this->targetOrderUpdatesMailJob($offer->provider?->email, "the offer no #$offer->id has been $offetAction.");

            DB::commit();
            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            
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

            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
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
            return responseJson(400, "Bad Request", $validator->errors()->first());
        }
        try{
            $user = auth()->user();
            
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

            return responseJson(200, "success");
        }catch(\Exception $e){
            DB::rollBack();
            return responseJson(500, "there is some thing wrong , please contact technical support");
        }
    }

    public function deleteOffer($id)
    {
        try{
            
            $offer = $this->offer->where('provider_id', auth()->user()->id)->where('id', $id)->first();
            if((int)$offer->status == 1){
                $offer->delete();
            }else {
                return responseJson(500, "cant remove this offer, this offer has actions");
            }
            return responseJson(200, "success");
        }catch(\Exception $e){
            return responseJson(500, "there is some thing wrong , please contact technical support");
        }
    }


}
