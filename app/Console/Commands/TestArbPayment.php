<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestArbPayment extends Command
{
    protected $signature = 'arb:test2';
    protected $description = 'Test ARB payment variations';

    public function handle()
    {
        $tranportalId = config('services.arb.tranportal_id');
        $password = config('services.arb.tranportal_password');
        $resourceKey = config('services.arb.resource_key');
        $responseUrl = config('services.arb.response_url');
        $errorUrl = config('services.arb.error_url');

        // Use hex-decoded key (AES-128) - confirmed working decryption
        $key = hex2bin($resourceKey);
        $cipher = 'AES-128-CBC';
        $iv = 'PGKEYENCDECIVSPC';
        $trackId = 'ARB-TEST-' . time();
        $endpoint = 'https://digitalpayments.alrajhibank.com.sa/pg/payment/hosted.htm';

        $this->info("Key (hex-decoded): " . bin2hex($key) . " (" . strlen($key) . " bytes)");
        $this->newLine();

        // Variation 1: password raw (not URL-encoded)
        $variations = [
            'v1_all_fields_http_build_query' => http_build_query([
                'amt' => '1.00', 'action' => '1', 'password' => $password,
                'id' => $tranportalId, 'trackId' => $trackId,
                'udf1' => 'pc', 'udf2' => '0', 'udf3' => '0',
                'udf4' => '', 'udf5' => '',
                'currencyCode' => '682',
                'responseURL' => $responseUrl, 'errorURL' => $errorUrl,
            ], '', '&', PHP_QUERY_RFC3986),

            'v2_no_urls' => http_build_query([
                'amt' => '1.00', 'action' => '1', 'password' => $password,
                'id' => $tranportalId, 'trackId' => $trackId,
                'udf1' => 'pc', 'udf2' => '0', 'udf3' => '0',
                'udf4' => '', 'udf5' => '',
                'currencyCode' => '682',
            ], '', '&', PHP_QUERY_RFC3986),

            'v3_no_currency_no_urls' => http_build_query([
                'amt' => '1.00', 'action' => '1', 'password' => $password,
                'id' => $tranportalId, 'trackId' => $trackId,
                'udf1' => 'pc', 'udf2' => '0', 'udf3' => '0',
                'udf4' => '', 'udf5' => '',
            ], '', '&', PHP_QUERY_RFC3986),

            'v4_minimal' => http_build_query([
                'amt' => '1.00', 'action' => '1', 'password' => $password,
                'id' => $tranportalId, 'trackId' => $trackId,
            ], '', '&', PHP_QUERY_RFC3986),

            'v5_manual_no_urlencode' => 'amt=1.00&action=1&password=' . $password . '&id=' . $tranportalId . '&trackId=' . $trackId . '&udf1=pc&udf2=0&udf3=0&udf4=&udf5=&currencyCode=682&responseURL=' . $responseUrl . '&errorURL=' . $errorUrl,

            'v6_no_action_no_currency' => http_build_query([
                'amt' => '1.00', 'password' => $password,
                'id' => $tranportalId, 'trackId' => $trackId,
                'udf1' => 'pc', 'udf2' => '0', 'udf3' => '0',
                'udf4' => '', 'udf5' => '',
                'responseURL' => $responseUrl, 'errorURL' => $errorUrl,
            ], '', '&', PHP_QUERY_RFC3986),
        ];

        foreach ($variations as $name => $plainData) {
            $this->info("=== {$name} ===");
            $this->info("  Plain: " . $plainData);
            $this->newLine();

            $encrypted = bin2hex(openssl_encrypt($plainData, $cipher, $key, OPENSSL_RAW_DATA, $iv));
            $payload = json_encode([[
                'id' => $tranportalId,
                'trandata' => $encrypted,
                'responseURL' => $responseUrl,
                'errorURL' => $errorUrl,
            ]], JSON_UNESCAPED_SLASHES);

            try {
                $response = \Illuminate\Support\Facades\Http::withBody($payload, 'application/json;charset=UTF-8')
                    ->acceptJson()
                    ->withOptions(['verify' => false])
                    ->timeout(30)
                    ->send('POST', $endpoint);
                $this->info("  => {$response->status()}: {$response->body()}");
            } catch (\Throwable $e) {
                $this->error("  => Error: " . $e->getMessage());
            }
            $this->newLine();
        }

        return 0;
    }
}
