<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Admin\InfoRepository;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\Eloquent\Admin\ProductRepository;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Validation\Rule;
use App\Http\ServicesLayer\PaymobServices\PaymobService;
use App\Traits\PushNotificationsTrait;
use ZipArchive;

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
        $this->offer = $offer;
        $this->paymobService = $paymobService;
    }

    public function myOrders(Request $request, $page_type = 'all')
    {
        $user = auth()->user();
        $orders = $user->orders()->when($page_type, function($q) use($page_type){
            if ($page_type == 'purchase-orders') {
                $q->where('order_type', 1);
            }elseif ($page_type == 'quotations') {
                $q->where('order_type', 2);
            }elseif ($page_type == 'maintenances') {
                $q->where('order_type', 3);
            }elseif ($page_type == 'scheduled-orders') {
                $q->where('request_type', 2);
            }
        })->when($request->orders_type, function($q) use($request){
            $q->where('order_type', $request->orders_type);
        })->when($request->schedule_requests, function($qq) use($request){
            $qq->where('request_type', (int)$request->schedule_requests);
        })->with([
            'items.product', 'timeline', 'provider', 'offers', 'offer'
        ])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view("front.auth.myorders", compact('orders'));
    }

    public function order($id, $from = null)
    {
        if (!is_null($from)) {
            flash()->success("success");
            return redirect()->route('user/get/order', $id);
        }

        $order = $this->order->where('id', $id)->with([
            'items.product.category', 'timeline', 'provider.ratings', 'user', 'offer.provider', 'offers.provider', 'partial_receive'
        ])->withCount('items')->first();

        return view("front.auth.order", compact('order'));
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
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        try{
            $discount = 0;
            $coupon = null;
            $coupon_id = null;
            $user = auth()->user();
            $info = $this->infoRepository->getfirst();
            $cartItems = $user->cart()->with('product')->get();
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
                $vatAmount = $grandTotal * (((int)$info?->vat ?? 10) / 100);

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
                $order->timeline()->create([
                    'timeline_no' => 1,
                    'action_at' => now(),
                    'user_id' => $user->id,
                ]);
                if (count($orderItems) > 0) {
                    $order->items()->createMany($orderItems);
                }
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

            }
            if (count($orderItems) > 0) {
                $user->cart()->delete();
            }
            DB::commit();
            flash()->success("success");
            return redirect(route('user/myorders', 'all'));
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
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
            'date_time_picker' => 'nullable|date',

            'frequency' => 'required_if:request_type,2|nullable|string|max:255',
            'delivery_duration' => 'required_if:request_type,2|nullable|string|max:255',
            'schedule_start_date'=> 'required_if:request_type,2|nullable|date',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
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
            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->success("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function makeMaintenance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_category_id' => 'nullable|exists:categories,id',
            'provider_id' => 'nullable|exists:users,id',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'device_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:1255',
            'serial_number' => 'nullable|string|max:255',
            'issue_description' => 'nullable|string|max:1255',
            'preferred_service_time' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
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
            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function orderPartialReceive(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:jpeg,png,jpg,webp,webm,pdf|max:114800',
            'offer_id' => 'nullable|exists:offers,id',
            'order_id' => 'required|exists:orders,id',
            'received_quantity' => 'required|integer',
            'received_all_quantity' => 'nullable|in:1',
            'reason_for_partial' => 'nullable|string|max:1255',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $request->order_id)->where('user_id', $user->id)->with(['partial_receive'])->first();
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
                flash()->error("not found");
                return back();
            }

            flash()->success("success");
            return back();
        }catch(\Exception $e){
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function orderTimeline(Request $request)
    {
        try{
            // decrypt
            $decryptedData = [
                'order_type' => decrypt($request->order_type),
                'timeline_no' => decrypt($request->timeline_no),
                'order_id' => decrypt($request->order_id),
                'delivery_fee' => $request->delivery_fee,
            ];
            $request->merge($decryptedData);

            $validator = Validator::make($decryptedData, [
                'order_type' => 'required|in:1,2,3',
                'timeline_no' => 'required|in:2,3,4,5,6,7,8,9,10,11,12',
                'order_id' => 'required|exists:orders,id',
                'delivery_fee' => ['nullable', 'numeric', 'min:0',
                    Rule::requiredIf(fn () =>
                        (int)$decryptedData['timeline_no'] === 2 && (int)$decryptedData['order_type'] === 1
                    ),
                ],
            ]);
            if ($validator->fails()) {
                return redirect()->to(url()->previous())->withErrors($validator)->withInput();
            }

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
                flash()->error("this order was deleted.");
                return back();
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
            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is something wrong , please contact technical support");
            return back();
        }
    }

    public function updateOrder(Request $request, $id)
    {
        try{
            
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline', 'partial_receive'])->first();
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                flash()->error("this order was deleted.");
                return back();
            }
            if ($order) {
                $data = [];
                if (isset($request->issue) && !is_null($request->issue)) {
                    $data['issue_description'] = is_null($order->issue_description) ? $request->issue : $order->issue_description .' / '. $request->issue;
                }
                $order->update($data);
            } else {
                flash()->error("not found");
                return back();
            }

            flash()->success("success");
            return back();
        }catch(\Exception $e){
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function cancelOrder($id)
    {
        try{
            $user = auth()->user();
            $order = $this->order->where('id', $id)->with(['timeline', 'provider'])->first();
            DB::beginTransaction();
            if ($order) {
                if ($order->user_id != $user->id && $order->provider_id != $user->id) {
                    flash()->error('not found');
                    return back();
                }
                $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
                if (in_array(2, $timeline_no_arr)) {
                    flash()->error('can’t cancel because this order is already being processed.');
                    return back();
                } elseif ((int)$user->user_type == 2 && (int)$order->payment_status == 1) {
                    flash()->error('can’t cancel because this order is paid, please contact technical support.');
                    return back();
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
                flash()->error('not found');
                return back();
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
            flash()->success('success');
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is something wrong , please contact technical support");
            return back();
        }
    }

    public function onlinePayment($id)
    {
        try {
            $user = auth()->user();
            $order = $this->order->where('id', $id)->where('user_id', $user->id)->with(['timeline'])->first();
            if (is_null($order)) {
                flash()->error("not found");
                return back();
            }
            if ($order->payment_status == 1) {
                flash()->error("this order is paid");
                return back();
            }
            $timeline_no_arr = array_column($order->timeline->toArray(), 'timeline_no');
            if (in_array(12, $timeline_no_arr)) {
                flash()->error("this order was deleted.");
                return back();
            }
            $device_type = 'pc';
            $total_cost = $order->total_cost + $order->delivery_fee;
            $data['paymob_url'] = $this->paymobService->generatePaymentUrl($total_cost, $order->id, $user, $device_type);
            return redirect()->away($data['paymob_url']);
        } catch (\Exception $ex) {
            flash()->error("there is something wrong , please contact technical support");
            return back();
        }
    }

    public function makeOffer(Request $request)
    {
        // decrypt
        $decryptedData = [
            'order_id' => decrypt($request->order_id),
        ];
        $request->merge($decryptedData);

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
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
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

            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
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
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
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

            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function deleteOffer($id)
    {
        try{
            
            $offer = $this->offer->where('provider_id', auth()->user()->id)->where('id', $id)->first();
            if((int)$offer->status == 1){
                $offer->delete();
            }else {
                flash()->error("cant remove this offer, this offer has actions");
                return back();
            }
            flash()->success("success");
            return back();
        }catch(\Exception $e){
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }

    public function offersDownload(int $id)
    {
        $offer = $this->offer->where('id', $id)->with(['order.user'])->first();
        if (!$offer || $offer->files) {
            abort(404);
            return redirect()->back();
        }
        $user = auth()->user();
        if (!$offer->order || !$offer->order?->user || !$offer->order?->user_id || !$offer->order?->user->id == $user->id) {
            abort(404);
            return redirect()->back();
        }

        $zipName = "offer-{$offer->id}-".str()->random(5).".zip";
        $zipFull = public_path("temp/{$zipName}");
        if (! is_dir(dirname($zipFull))) {
            mkdir(dirname($zipFull), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFull, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Cannot create zip.');
            return redirect()->back();
        }

        foreach ($offer->files as $file) {
            $relative = ltrim((string) $file, '/');
            $abs= public_path($relative);
            if (file_exists($abs) && is_file($abs)) {
                $zip->addFile($abs, basename($relative));
            }
        }
        $zip->close();

        return response()->download($zipFull)->deleteFileAfterSend(true);
    }

    public function offersActions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:2,3',
            'rejected_reson' => 'required_if:action,3|string|max:1255',
            'offer_id' => 'required|exists:offers,id',
        ]);
        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withErrors($validator)->withInput();
        }
        try{
            
            $user = auth()->user();

            // 2 => accepted, 3 => rejected
            DB::beginTransaction();
            $offer = $this->offer->where('id', $request->offer_id)->with(['order', 'provider'])->first();
            if (!is_null($offer->order?->offer_id)) {
                flash()->error("this order has offer");
                return back();
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
                flash()->error("this offer has actions");
                return back();
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
            flash()->success("success");
            return back();
        }catch(\Exception $e){
            DB::rollBack();
            flash()->error("there is some thing wrong , please contact technical support");
            return back();
        }
    }


}
