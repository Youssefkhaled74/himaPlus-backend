<?php

namespace App\Http\ServicesLayer\ArbServices;

use App\Models\Notification;
use App\Models\Order;
use App\Traits\PushNotificationsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ArbPaymentService
{
    use PushNotificationsTrait;

    public function __construct(
        protected ArbCryptoService $cryptoService,
        protected Order $order,
        protected Notification $notification
    ) {
    }

    public function generatePaymentUrl(Order $order, $user, string $deviceType = 'mobile', ?Request $request = null, &$errorDetails = null): ?array
    {
        $errorDetails = null;

        $amount = $this->formatAmount(($order->total_cost ?? 0) + ($order->delivery_fee ?? 0));
        if ((float) $amount <= 0) {
            $errorDetails = ['source' => 'arb_service', 'reason' => 'invalid_amount'];
            return null;
        }

        $trackId = $this->buildTrackId((int) $order->id, (int) $user->id);
        $callbackUrl = config('services.arb.response_url');

        $plainData = [
            'amt' => $amount,
            'action' => '1',
            'password' => (string) config('services.arb.tranportal_password'),
            'id' => (string) config('services.arb.tranportal_id'),
            'currencyCode' => '682',
            'trackId' => $trackId,
            'responseURL' => $callbackUrl,
            'errorURL' => (string) config('services.arb.error_url', $callbackUrl),
            'udf1' => $deviceType,
            'udf2' => (string) $order->id,
            'udf3' => (string) $user->id,
            'udf4' => '',
            'udf5' => '',
        ];

        try {
            $encryptedTranData = $this->cryptoService->encrypt(http_build_query($plainData, '', '&', PHP_QUERY_RFC3986), (string) config('services.arb.resource_key'));
            $this->updateGatewayTracking($order, [
                'gateway_name' => 'arb',
                'gateway_payment_id' => null,
                'gateway_track_id' => $trackId,
            ]);

            $endpoint = (string) config('services.arb.endpoint');
            Log::info('ARB payment init request prepared', [
                'order_id' => $order->id,
                'endpoint' => $endpoint,
                'has_trandata' => !empty($encryptedTranData),
            ]);

            $payload = [[
                'id' => (string) config('services.arb.tranportal_id'),
                'trandata' => $encryptedTranData,
                'responseURL' => $callbackUrl,
                'errorURL' => (string) config('services.arb.error_url', $callbackUrl),
            ]];

            $verifySsl = filter_var(config('services.arb.verify_ssl', true), FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
            $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES);
            if ($jsonPayload === false) {
                throw new \RuntimeException('Failed to encode ARB payment init payload.');
            }

            $response = Http::withBody($jsonPayload, 'application/json;charset=UTF-8')
                ->acceptJson()
                ->withOptions(['verify' => $verifySsl ?? true])
                ->withHeaders([
                    'X-FORWARDED-FOR' => $this->forwardedFor($request),
                ])->send('POST', (string) config('services.arb.endpoint'));

            if (!$response->successful()) {
                $errorDetails = [
                    'source' => 'arb_api',
                    'reason' => 'http_request_failed',
                    'http_status' => $response->status(),
                ];
                Log::error('ARB payment init failed (http)', [
                    'order_id' => $order->id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();
            if (is_array($data) && array_is_list($data)) {
                $first = $data[0] ?? [];
            } elseif (is_array($data)) {
                $first = $data;
            } else {
                $first = [];
            }
            if ((string) ($first['status'] ?? '') !== '1') {
                $errorDetails = [
                    'source' => 'arb_api',
                    'reason' => 'gateway_status_failed',
                    'status' => $first['status'] ?? null,
                    'error' => $first['error'] ?? null,
                    'errorText' => $first['errorText'] ?? null,
                ];
                Log::warning('ARB payment init rejected', [
                    'order_id' => $order->id,
                    'status' => $first['status'] ?? null,
                    'error' => $first['error'] ?? null,
                    'errorText' => $first['errorText'] ?? null,
                ]);
                return null;
            }

            [$paymentId, $paymentPageUrl] = array_pad(explode(':', (string) ($first['result'] ?? ''), 2), 2, null);
            if (!$paymentId || !$paymentPageUrl) {
                $errorDetails = ['source' => 'arb_api', 'reason' => 'invalid_result_format'];
                return null;
            }

            Log::info('ARB payment init accepted', [
                'order_id' => $order->id,
                'payment_id' => $paymentId,
                'payment_page_url' => $paymentPageUrl,
            ]);

            $this->updateGatewayTracking($order, [
                'gateway_name' => 'arb',
                'gateway_payment_id' => $paymentId,
                'gateway_track_id' => $trackId,
            ]);

            return [
                'payment_url' => $this->framePaymentPageUrl($paymentPageUrl, $paymentId),
                'payment_id' => $paymentId,
                'track_id' => $trackId,
                'gateway' => 'arb',
            ];
        } catch (\Throwable $e) {
            report($e);
            $errorDetails = [
                'source' => 'arb_service',
                'reason' => 'exception',
                'message' => $e->getMessage(),
            ];
            return null;
        }
    }

    public function callback(Request $request)
    {
        $raw = $request->all();

        if (!empty($raw['error']) || !empty($raw['errorText'])) {
            Log::warning('ARB callback with explicit error', [
                'error' => $raw['error'] ?? null,
                'errorText' => $raw['errorText'] ?? null,
                'paymentId' => $raw['paymentId'] ?? null,
            ]);
            return responseJson(422, 'Payment failed or rejected', [
                'gateway' => 'arb',
                'error' => $raw['error'] ?? null,
                'errorText' => $raw['errorText'] ?? null,
            ]);
        }

        if (empty($raw['trandata'])) {
            return responseJson(400, 'Missing trandata');
        }

        try {
            $decrypted = $this->cryptoService->decrypt((string) $raw['trandata'], (string) config('services.arb.resource_key'));
        } catch (\Throwable $e) {
            Log::warning('ARB callback decrypt failed', ['message' => $e->getMessage()]);
            return responseJson(400, 'Invalid trandata');
        }

        $payload = $this->parseDecryptedData($decrypted);
        if (empty($payload)) {
            return responseJson(400, 'Unable to parse trandata');
        }

        $payload['paymentId'] = $payload['paymentId'] ?? ($raw['paymentId'] ?? null);
        $order = $this->resolveOrderFromCallback($payload);
        if (!$order) {
            return responseJson(404, 'Order not found for callback');
        }

        $expectedAmount = $this->formatAmount(($order->total_cost ?? 0) + ($order->delivery_fee ?? 0));
        $returnedAmount = $this->formatAmount((float) ($payload['amt'] ?? 0));
        if ((string) $expectedAmount !== (string) $returnedAmount) {
            Log::warning('ARB callback amount mismatch', [
                'order_id' => $order->id,
                'expected' => $expectedAmount,
                'returned' => $returnedAmount,
            ]);
            return responseJson(422, 'Amount mismatch');
        }

        if (!$this->trackIdBelongsToOrder((string) ($payload['trackId'] ?? ''), $order)) {
            return responseJson(422, 'Invalid trackId for order');
        }

        $result = strtoupper((string) ($payload['result'] ?? ''));
        if (!in_array($result, ['CAPTURED', 'APPROVED'], true)) {
            return responseJson(422, 'Transaction not approved', [
                'gateway' => 'arb',
                'result' => $payload['result'] ?? null,
            ]);
        }

        return $this->markPaid($order, $payload);
    }

    public function webhook(Request $request)
    {
        return $this->callback($request);
    }

    public function markPaid(Order $order, array $payload)
    {
        if ((int) $order->payment_status === 1) {
            return responseJson(200, 'already paid', [
                'order_id' => $order->id,
                'gateway' => 'arb',
                'device_type' => $payload['udf1'] ?? null,
            ]);
        }

        $updateData = [
            'payment_status' => 1,
            'payment_type' => $payload['cardType'] ?? 'arb',
            'getway_transaction_id' => $payload['transId'] ?? $payload['ref'] ?? $payload['paymentId'] ?? null,
        ];

        if (Schema::hasColumn('orders', 'gateway_name')) {
            $updateData['gateway_name'] = 'arb';
        }
        if (Schema::hasColumn('orders', 'gateway_payment_id')) {
            $updateData['gateway_payment_id'] = $payload['paymentId'] ?? null;
        }
        if (Schema::hasColumn('orders', 'gateway_track_id')) {
            $updateData['gateway_track_id'] = $payload['trackId'] ?? $order->gateway_track_id;
        }
        if (Schema::hasColumn('orders', 'gateway_response')) {
            $updateData['gateway_response'] = $this->sanitizeGatewayPayload($payload);
        }

        $order->update($updateData);
        $order->loadMissing(['provider', 'user']);

        $this->sendNotification($order, $order->user);

        return responseJson(200, 'Thank You', [
            'order_id' => $order->id,
            'gateway' => 'arb',
            'device_type' => $payload['udf1'] ?? null,
        ]);
    }

    protected function sendNotification($order, $user): void
    {
        $notificationArr[0] = [
            'title' => "Order #$order->id has been paid successfully.", 'content' => "Order #$order->id has been paid successfully.", 'user_id' => $user->id,
            'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\\Models\\Order',
            'created_at' => now(), 'updated_at' => now(),
        ];

        if (!is_null($order->provider_id)) {
            $notificationArr[1] = [
                'title' => "Order #$order->id has been paid successfully.", 'content' => "Order #$order->id has been paid successfully.", 'user_id' => $order->provider_id,
                'order_id' => $order->id, 'serviceable_id' => $order->id, 'serviceable_type' => 'App\\Models\\Order',
                'created_at' => now(), 'updated_at' => now(),
            ];

            $provider = $order->provider;
            $this->targetNewOrderMailJob($provider?->email, $order->id);
            $this->targetFairbaseServicePushNotification(
                $provider?->fcm_token,
                $notificationArr[1]['title'],
                $notificationArr[1]['content'],
                1,
                $order->id
            );
        }

        $this->notification->query()->insert($notificationArr);

        $this->targetNewOrderMailJob($user?->email, $order->id);
        $this->targetFairbaseServicePushNotification(
            $user?->fcm_token,
            $notificationArr[0]['title'],
            $notificationArr[0]['content'],
            1,
            $order->id
        );
    }

    private function forwardedFor(?Request $request = null): string
    {
        $clientIp = $request?->ip() ?? request()->ip() ?? '127.0.0.1';
        $serverIp = gethostbyname(gethostname()) ?: null;

        return $serverIp ? $clientIp . ', ' . $serverIp : $clientIp;
    }

    private function parseDecryptedData(string $decrypted): array
    {
        $decodedJson = json_decode($decrypted, true);
        if (is_array($decodedJson)) {
            return $decodedJson;
        }

        parse_str($decrypted, $parsed);
        if (!is_array($parsed) || empty($parsed)) {
            return [];
        }

        return $parsed;
    }

    private function resolveOrderFromCallback(array $payload): ?Order
    {
        $trackId = (string) ($payload['trackId'] ?? '');
        if ($trackId !== '') {
            $order = null;
            if (Schema::hasColumn('orders', 'gateway_track_id')) {
                $order = $this->order->where('gateway_track_id', $trackId)->first();
            }
            if ($order) {
                return $order;
            }

            if (preg_match('/^ARB-(\d+)-/', $trackId, $matches)) {
                $orderById = $this->order->find((int) $matches[1]);
                if ($orderById) {
                    return $orderById;
                }
            }
        }

        $paymentId = (string) ($payload['paymentId'] ?? '');
        if ($paymentId !== '' && Schema::hasColumn('orders', 'gateway_payment_id')) {
            return $this->order->where('gateway_payment_id', $paymentId)->first();
        }

        return null;
    }

    private function trackIdBelongsToOrder(string $trackId, Order $order): bool
    {
        if ($trackId === '') {
            if (Schema::hasColumn('orders', 'gateway_payment_id')) {
                return !empty($order->gateway_payment_id);
            }
            return false;
        }

        if (Schema::hasColumn('orders', 'gateway_track_id') && !empty($order->gateway_track_id)) {
            return hash_equals((string) $order->gateway_track_id, $trackId);
        }

        return str_starts_with($trackId, 'ARB-' . $order->id . '-');
    }

    private function buildTrackId(int $orderId, int $userId): string
    {
        return 'ARB-' . $orderId . '-' . $userId . '-' . Str::upper(Str::random(8));
    }

    private function formatAmount(float|int|string $amount): string
    {
        return number_format((float) $amount, 2, '.', '');
    }

    private function sanitizeGatewayPayload(array $payload): array
    {
        if (!empty($payload['card'])) {
            $payload['card'] = $this->maskCardNumber((string) $payload['card']);
        }

        return $payload;
    }

    private function maskCardNumber(string $cardNumber): string
    {
        $digits = preg_replace('/\D+/', '', $cardNumber);
        if (strlen($digits) < 8) {
            return '****';
        }

        return substr($digits, 0, 6) . str_repeat('*', max(0, strlen($digits) - 10)) . substr($digits, -4);
    }

    private function updateGatewayTracking(Order $order, array $data): void
    {
        $update = [];

        if (Schema::hasColumn('orders', 'gateway_name') && isset($data['gateway_name'])) {
            $update['gateway_name'] = $data['gateway_name'];
        }
        if (Schema::hasColumn('orders', 'gateway_payment_id') && isset($data['gateway_payment_id'])) {
            $update['gateway_payment_id'] = $data['gateway_payment_id'];
        }
        if (Schema::hasColumn('orders', 'gateway_track_id') && isset($data['gateway_track_id'])) {
            $update['gateway_track_id'] = $data['gateway_track_id'];
        }

        if (!empty($update)) {
            $order->update($update);
        }
    }

    private function framePaymentPageUrl(string $paymentPageUrl, string $paymentId): string
    {
        if (preg_match('/[?&]paymentid=/i', $paymentPageUrl)) {
            return $paymentPageUrl;
        }

        $separator = str_contains($paymentPageUrl, '?') ? '&' : '?';

        return $paymentPageUrl . $separator . 'PaymentID=' . rawurlencode($paymentId);
    }

}
