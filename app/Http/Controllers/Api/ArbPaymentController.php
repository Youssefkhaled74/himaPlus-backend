<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\ServicesLayer\ArbServices\ArbPaymentService;
use Illuminate\Http\Request;

class ArbPaymentController extends Controller
{
    public function __construct(protected ArbPaymentService $arbPaymentService)
    {
    }

    public function callback(Request $request)
    {
        $response = $this->arbPaymentService->callback($request);

        if (!$request->is('payment/arb/callback')) {
            return $response;
        }

        $data = method_exists($response, 'getData') ? data_get($response->getData(true), 'data') : null;
        $deviceType = (string) data_get($data, 'device_type', '');
        $orderId = data_get($data, 'order_id');

        if ($response->status() === 200 && $deviceType === 'pc' && !empty($orderId)) {
            flash()->success('Payment completed successfully');
            return redirect()->route('user/get/order', ['id' => $orderId, 'from' => 'pc']);
        }

        if ($response->status() !== 200) {
            flash()->error((string) data_get($response->getData(true), 'msg', 'Payment callback failed'));
            return redirect()->route('home');
        }

        return $response;
    }

    public function webhook(Request $request)
    {
        return $this->arbPaymentService->webhook($request);
    }
}
