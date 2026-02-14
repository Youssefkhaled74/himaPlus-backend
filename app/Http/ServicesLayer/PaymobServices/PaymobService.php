<?php

namespace App\Http\ServicesLayer\PaymobServices;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymobService 
{

    use PushNotificationsTrait;

    public $order;
    public $notification;

    public $apiKey;
    public $iframeURL;
    public $hmacSecret;
    public $publicKey;
    public $secretKey;
    public $integrationID;

    protected array $hmacOrder = [
        'amount_cents', 'created_at', 'currency', 'error_occured', 'has_parent_transaction', 'id',
        'integration_id', 'is_3d_secure', 'is_auth', 'is_capture', 'is_refunded', 'is_standalone_payment',
        'is_voided', 'order', 'owner', 'pending', 'source_data_pan', 'source_data_sub_type',
        'source_data_type', 'success',
    ];

    public function __construct()
    {
        $this->publicKey = (string) config('services.paymob.public_key');
        $this->secretKey = (string) config('services.paymob.secret_key');
        $this->integrationID = (int) config('services.paymob.integration_id');

        $this->apiKey = (string) config('services.paymob.api_key');
        $this->iframeURL = (string) config('services.paymob.iframe_url');
        $this->hmacSecret = (string) config('services.paymob.hmac_secret');
        
        $this->order = new Order();
        $this->notification = new Notification();
    }

    public function generatePaymentUrl(int $amountCents = 0, int $orderID, $user, $device_type)
    {
        
        $specialReference = Str::upper(Str::random(5)) .'-'. $orderID .'-'. $device_type;
        $payload = [
            "amount"          => $amountCents * 100,
            "currency"        => "SAR",
            "expiration"      => 3600,
            "order_id"        => (string)$orderID,
            "payment_methods" => [(int)$this->integrationID],
            "items" => [[
                "name"        => "Order #{$orderID}",
                "amount"      => $amountCents * 100,
                "description" => "Cart items",
                "quantity"    => 1,
            ]],
            "billing_data" => [
                "first_name"  => $user->name ?? 'guest',
                "last_name"   => $user->name ?? 'guest',
                "email"       => $user->email ?? 'guest@example.com',
                "phone_number"=> $user->phone ?? '0000000000',
                "apartment"   => "",
                "street"      => "",
                "building"    => "",
                "country"     => "",
                "floor"       => "",
                "state"       => "",
            ],
            "special_reference" => $specialReference,
            "customer" => [
                "first_name"  => $user->name ?? 'guest',
                "last_name"   => $user->name ?? 'guest',
                "email"       => $user->email ?? 'guest@example.com',
                "extras"      => ["source" => "laravel"],
            ],
            "extras" => [
                "device_type" => $device_type,
                "transaction_id" => $orderID,
            ],
        ];

        try {
            $res = Http::withHeaders([
                'Authorization' => "Token {$this->secretKey}",
                'Content-Type'  => "application/json",
            ])->post('https://ksa.paymob.com/v1/intention/', $payload);
            // ])->post('https://accept.paymob.com/v1/intention/', $payload);

            if (!$res->successful()) {
                throw new \RuntimeException('Paymob intention failed: ' . $res->body());
            }

            $clientSecret = $res->json('client_secret');
            if (!$clientSecret) {
                throw new \RuntimeException('Missing client_secret in intentions response');
            }

            return "https://ksa.paymob.com/unifiedcheckout/?publicKey={$this->publicKey}&clientSecret={$clientSecret}";
        } catch (\Exception $e) {
            report("generatePaymentUrl issue ======> $e");
            return 0;
        }
    }

    public function callback(Request $request)
    {

        [$valid, $payload] = $this->verifyHmac($request);
        if (!$valid) {
            return responseJson(400, 'Invalid HMAC');
        }

        $isSuccess = filter_var(($payload['success'] ?? $request->input('success')), FILTER_VALIDATE_BOOLEAN);
        if (!$isSuccess) {
            return responseJson(400, 'Not Success');
        }
        
        $orderID = explode('-', $payload['merchant_order_id'])[1];
        $deviceType = explode('-', $payload['merchant_order_id'])[2];
        // report('(paymob)request callback ====================> ' . $request);
        // dd($payload, $request->all(), $orderID);

        $txId = (string)($payload['id'] ?? $request->input('id'));
        $subType = $payload['source_data_sub_type'] ?? $request->input('source_data_sub_type');

        return $this->markPaid($orderID, $subType, $txId, $deviceType);
    }

    public function webhook(Request $request)
    {
        [$valid, $payload] = $this->verifyHmac($request);

        if (!$valid) {
            return responseJson(400, 'Invalid HMAC');
        }

        $isSuccess  = filter_var(($payload['success'] ?? false), FILTER_VALIDATE_BOOLEAN);
        $isVoided   = filter_var(($payload['is_voided'] ?? false), FILTER_VALIDATE_BOOLEAN);
        $isRefunded = filter_var(($payload['is_refunded'] ?? false), FILTER_VALIDATE_BOOLEAN);

        if ($isSuccess && !$isVoided && !$isRefunded) {

            $orderID = explode('-', $payload['merchant_order_id'])[1];
            $deviceType = explode('-', $payload['merchant_order_id'])[2] ?? 'mobile';
            // report('(paymob)request callback ====================> ' . $request);
            // dd($payload, $request->all(), $orderID);

            $txId = (string)($payload['id'] ?? '');
            $subType = $payload['source_data_sub_type'] ?? null;

            return $this->markPaid($orderID, $subType, $txId, $deviceType);
        }

        return responseJson(200, 'Ignored');
    }

    public function verifyHmac(Request $request): array
    {
        $payload = $request->input('obj', $request->all());
        $sentHmac = $request->input('hmac', $payload['hmac'] ?? null);

        $concatenated = $this->buildHmacString($payload);
        $calculated = hash_hmac('sha512', $concatenated, $this->hmacSecret);

        $isValid = $sentHmac && hash_equals($calculated, $sentHmac);

        return [$isValid, $payload, $calculated, $sentHmac];
    }

    protected function buildHmacString(array $payload): string
    {
        $connected = '';
        foreach ($this->hmacOrder as $key) {
            $connected .= isset($payload[$key]) ? (string)$payload[$key] : '';
        }
        return $connected;
    }

    public function markPaid(?int $orderID, ?string $subType, ?string $getwayTransactionID, $deviceType)
    {
        
        if (!$orderID || !$getwayTransactionID) {
            return responseJson(422, 'Missing payment id');
        }
        $order = $this->order->where('id', $orderID)->with(['provider', 'user'])->first();
        if (!$order) {
            return responseJson(404, 'Payment not found');
        }

        $order->update([
            'payment_type' => $subType,
            'getway_transaction_id' => $getwayTransactionID,
            'payment_status' => 1,
        ]);
        $this->sendNotification($order, $order->user);
        return responseJson(200, 'Thank You', [
            'order_id' => $orderID,
            'device_type' => $deviceType,
        ]);
    }

    protected function sendNotification($order, $user)
    {
        $notificationArr[0] = [
            'title' => "Order #$order->id has been paid successfully.", 'content' => "Order #$order->id has been paid successfully.", 'user_id' => $user->id, 
            'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\Models\Order',
            'created_at' => now(), 'updated_at' => now()
        ];
        if (!is_null($order->provider_id)) {
            $notificationArr[1] = [
                'title' => "Order #$order->id has been paid successfully.", 'content' => "Order #$order->id has been paid successfully.", 'user_id' => $order->provider_id, 
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

}
