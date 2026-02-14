<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\ServicesLayer\PaymobServices\PaymobService;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(protected PaymobService $paymobService) {}
    
    public function callback(Request $request)
    {
        return $this->paymobService->callback($request);
    }

    public function webhook(Request $request)
    {
        return $this->paymobService->webhook($request);
    }
}
