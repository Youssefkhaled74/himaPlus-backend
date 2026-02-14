<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\ServicesLayer\PaymobServices\PaymobService;
use Illuminate\Support\Facades\Auth;

class PaymobController extends Controller
{
    public function __construct(protected PaymobService $paymobService) {}
    
    public function callback(Request $request)
    {
        return $this->paymobService->callback($request);
    }

    public function webhook(Request $request)
    {
        $webhook = $this->paymobService->webhook($request);
        $device = data_get($webhook->getData(true), 'data.device_type');
        if ($device == 'pc') {
            $orderID = data_get($webhook->getData(true), 'data.order_id');
            return redirect()->route('user/get/order', ['id' => $orderID, 'from' => 'pc']);
        }else{
            return $webhook;
        }
    }
}
