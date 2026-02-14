<?php

namespace App\Http\ServicesLayer\PaymentServices;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PaymentService 
{

    use PushNotificationsTrait;

    public $order;
    public $notification;

    protected Client $http;
    protected string $baseUrl;
    protected string $secret;

    public function __construct()
    {
        $this->order = new Order();
        $this->notification = new Notification();
        $this->secret  = '36Rdv7gEyuNg9H8DVwBiYYFtiOb5PJIjdbQ2tfM0i2Q=';
        $this->http    = new Client([
            'base_uri' => 'https://api.moneyhash.io' . '/',
            'timeout'  => 20,
        ]);
    }






    protected function headers(array $extra = []): array
    {
        return array_merge([
            'Authorization'   => "Bearer {$this->secret}",
            'Accept'          => 'application/json',
            'Content-Type'    => 'application/json',
            // مهم لتفادي التكرار لو الشبكة قطعت
            'Idempotency-Key' => (string) Str::uuid(),
        ], $extra);
    }

    public function createHostedCheckoutIntent(int $amountCents, string $currency, array $opts = []): array
    {
        // بنبني البودي بدون تحديد payment_method أو provider
        $body = [
            'amount'        => $amountCents,
            'currency'      => $currency,
            'metadata'      => $opts['metadata'] ?? null,
            'customer'      => $opts['customer'] ?? null,
            'redirect_urls' => $opts['redirect_urls'] ?? null,
        ];

        // لو عايز تقيّد الوسائل المسموح بها (اختياري)
        if (!empty($opts['allowed_payment_methods']) && is_array($opts['allowed_payment_methods'])) {
            $body['allowed_payment_methods'] = $opts['allowed_payment_methods'];
        }

        // نظّف الحقول الفارغة
        $body = array_filter($body, fn($v) => !is_null($v));
        $res = $this->http->post('external/payment_intents', [
            'headers' => $this->headers(),
            'json'    => $body,
        ]);

        return json_decode($res->getBody()->getContents(), true);
    }

    /** جب حالة الـintent (للاحتياط أو العرض) */
    public function getHostedCheckoutIntent(string $intentId): array
    {
        $res = $this->http->get("external/payment_intents/{$intentId}", [
            'headers' => $this->headers(),
        ]);
        return json_decode($res->getBody()->getContents(), true);
    }

    /** مساعد لاستنتاج رابط التوجيه من الاستجابة */
    public static function extractRedirectUrl(array $intent): ?string
    {
        return $intent['checkout_url'] ?? $intent['redirect_url'] ?? null;
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