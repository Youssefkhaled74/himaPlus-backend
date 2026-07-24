<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestArbPayment extends Command
{
    protected $signature = 'arb:test';
    protected $description = 'Test ARB payment gateway - try all formats until success';

    private string $iv = 'PGKEYENCDECIVSPC';

    public function handle()
    {
        $tranportalId = config('services.arb.tranportal_id');
        $password = config('services.arb.tranportal_password');
        $resourceKey = config('services.arb.resource_key');
        $responseUrl = config('services.arb.response_url');
        $errorUrl = config('services.arb.error_url');
        $trackId = 'ARB-TEST-' . time();
        $amount = '1.00';

        $this->info('=== ARB Payment Gateway Test ===');
        $this->info("Tranportal ID: {$tranportalId}");
        $this->info("Password: {$password}");
        $this->info("Resource Key: {$resourceKey} (" . strlen($resourceKey) . " chars)");
        $this->info("Response URL: {$responseUrl}");
        $this->info("Track ID: {$trackId}");
        $this->newLine();

        $endpoints = [
            'hosted.htm' => 'https://digitalpayments.alrajhibank.com.sa/pg/payment/hosted.htm',
            'tranportal.htm' => 'https://digitalpayments.alrajhibank.com.sa/pg/payment/tranportal.htm',
        ];

        // All format variations to try
        $variations = $this->buildVariations($tranportalId, $password, $amount, $trackId, $responseUrl, $errorUrl);

        foreach ($variations as $variation) {
            $this->info("=== {$variation['name']} ===");
            $this->info("  Plain: {$variation['plain']}");
            $this->info("  Key mode: {$variation['key_mode']} ({$variation['cipher']})");

            $encrypted = @openssl_encrypt(
                $variation['plain'],
                $variation['cipher'],
                $variation['key'],
                OPENSSL_RAW_DATA,
                $this->iv
            );

            if ($encrypted === false) {
                $this->error("  Encryption failed!");
                $this->newLine();
                continue;
            }

            $hexEncrypted = bin2hex($encrypted);
            $this->info("  Encrypted length: " . strlen($hexEncrypted));

            foreach ($endpoints as $epName => $epUrl) {
                $payload = json_encode([[
                    'id' => $tranportalId,
                    'trandata' => $hexEncrypted,
                    'responseURL' => $responseUrl,
                    'errorURL' => $errorUrl,
                ]], JSON_UNESCAPED_SLASHES);

                try {
                    $response = Http::withBody($payload, 'application/json;charset=UTF-8')
                        ->acceptJson()
                        ->withOptions(['verify' => false])
                        ->timeout(30)
                        ->send('POST', $epUrl);

                    $body = $response->body();
                    $status = $response->status();

                    // Check if success (status "1" in response)
                    $json = @json_decode($body, true);
                    $respStatus = $json[0]['status'] ?? $json['status'] ?? null;

                    if ((string) $respStatus === '1') {
                        $this->info("  >>> {$epName}: {$body}");
                        $this->newLine();
                        $this->info("  *** SUCCESS! Payment link generated! ***");
                        $this->info("  Result: " . ($json[0]['result'] ?? $json['result'] ?? ''));
                        return 0;
                    }

                    $errorShort = $json[0]['errorText'] ?? $json['errorText'] ?? $body;
                    $this->info("  {$epName} [{$status}]: {$errorShort}");
                } catch (\Throwable $e) {
                    $this->error("  {$epName}: " . $e->getMessage());
                }
            }
            $this->newLine();
        }

        $this->error("All variations failed. Check the credentials and terminal activation.");
        return 1;
    }

    private function buildVariations(string $id, string $password, string $amt, string $trackId, string $responseUrl, string $errorUrl): array
    {
        $keyRaw = $resourceKey = config('services.arb.resource_key');
        $keyHex = @hex2bin($resourceKey);

        $variations = [];

        // === AES-256-CBC (raw key) variations ===

        // 1. JSON array with all fields + langid (like C# example)
        $plain = json_encode([[ 
            'id' => $id,
            'password' => $password,
            'action' => 1,
            'currencyCode' => 682,
            'responseURL' => $responseUrl,
            'errorURL' => $errorUrl,
            'trackId' => $trackId,
            'amt' => (float) $amt,
            'langid' => '',
        ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $variations[] = ['name' => '1-AES256-JSON-native-types-with-langid', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // 2. JSON array with string types (like our current)
        $plain = json_encode([[
            'id' => $id,
            'password' => $password,
            'action' => '1',
            'currencyCode' => '682',
            'responseURL' => $responseUrl,
            'errorURL' => $errorUrl,
            'trackId' => $trackId,
            'amt' => $amt,
            'udf1' => 'pc',
            'udf2' => '0',
            'udf3' => '0',
            'udf4' => '',
            'udf5' => '',
        ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $variations[] = ['name' => '2-AES256-JSON-string-types', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // 3. JSON array native types no langid
        $plain = json_encode([[
            'id' => $id,
            'password' => $password,
            'action' => 1,
            'currencyCode' => 682,
            'responseURL' => $responseUrl,
            'errorURL' => $errorUrl,
            'trackId' => $trackId,
            'amt' => (float) $amt,
        ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $variations[] = ['name' => '3-AES256-JSON-native-no-langid', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // 4. URL-encoded (our original approach)
        $plain = http_build_query([
            'amt' => $amt, 'action' => '1', 'password' => $password,
            'id' => $id, 'trackId' => $trackId,
            'udf1' => 'pc', 'udf2' => '0', 'udf3' => '0',
            'udf4' => '', 'udf5' => '',
            'currencyCode' => '682',
            'responseURL' => $responseUrl, 'errorURL' => $errorUrl,
        ], '', '&', PHP_QUERY_RFC3986);
        $variations[] = ['name' => '4-AES256-urlencoded', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // 5. URL-encoded no URLs
        $plain = http_build_query([
            'amt' => $amt, 'action' => '1', 'password' => $password,
            'id' => $id, 'trackId' => $trackId,
            'currencyCode' => '682',
        ], '', '&', PHP_QUERY_RFC3986);
        $variations[] = ['name' => '5-AES256-urlencoded-minimal', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // 6. Manual string no encoding
        $plain = "amt={$amt}&action=1&password={$password}&id={$id}&trackId={$trackId}&currencyCode=682&responseURL={$responseUrl}&errorURL={$errorUrl}";
        $variations[] = ['name' => '6-AES256-manual-raw', 'plain' => $plain, 'key' => $keyRaw, 'cipher' => 'AES-256-CBC', 'key_mode' => 'raw'];

        // === AES-128-CBC (hex-decoded key) variations ===

        if ($keyHex !== false && strlen($keyHex) === 16) {
            // 7. JSON native types with AES-128
            $plain = json_encode([[
                'id' => $id,
                'password' => $password,
                'action' => 1,
                'currencyCode' => 682,
                'responseURL' => $responseUrl,
                'errorURL' => $errorUrl,
                'trackId' => $trackId,
                'amt' => (float) $amt,
                'langid' => '',
            ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $variations[] = ['name' => '7-AES128-JSON-native', 'plain' => $plain, 'key' => $keyHex, 'cipher' => 'AES-128-CBC', 'key_mode' => 'hex'];

            // 8. URL-encoded with AES-128
            $plain = http_build_query([
                'amt' => $amt, 'action' => '1', 'password' => $password,
                'id' => $id, 'trackId' => $trackId,
                'currencyCode' => '682',
                'responseURL' => $responseUrl, 'errorURL' => $errorUrl,
            ], '', '&', PHP_QUERY_RFC3986);
            $variations[] = ['name' => '8-AES128-urlencoded', 'plain' => $plain, 'key' => $keyHex, 'cipher' => 'AES-128-CBC', 'key_mode' => 'hex'];
        }

        return $variations;
    }
}
