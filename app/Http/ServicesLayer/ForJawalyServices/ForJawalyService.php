<?php

namespace App\Http\ServicesLayer\ForJawalyServices;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ForJawalyService
{
    public function sendSMS(string $phone, string $code, ?string $lang = null): array
    {
        $lang = $lang ?: app()->getLocale();

        $message = $lang === 'ar'
            ? "مرحب بكم في تطبيق هيما، رمز التحقق: {$code}"
            : "Welcome to Hema app. Your verification code: {$code}";

        $sender = config('services.forjawaly.sender', 'TechPack');

        $data = [
            "messages" => [[
                "text" => $message,
                "numbers" => [$phone],
                "sender" => $sender,
            ]]
        ];

        try {
            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Content-Type" => "application/json",
            ])
                ->baseUrl(config('services.forjawaly.base_url'))
                ->withBasicAuth(
                    config('services.forjawaly.key'),
                    config('services.forjawaly.secret')
                )
                ->timeout(15)
                ->post('account/area/sms/send', $data);

            $result = $response->json();

            Log::info('ForJawaly SMS response', [
                'phone' => $phone,
                'http_status' => $response->status(),
                'api_code' => $result['code'] ?? null,
                'message' => $result['message'] ?? null,
                'job_id' => $result['job_id'] ?? null,
            ]);

            $isSuccess = isset($result['code']) && (int) $result['code'] === 200;

            return [
                'success' => $isSuccess,
                'message' => $result['message'] ?? ($isSuccess ? 'SMS sent successfully' : 'SMS sending failed'),
            ];
        } catch (\Exception $e) {
            Log::error('ForJawaly SMS exception', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage(),
            ];
        }
    }
}
