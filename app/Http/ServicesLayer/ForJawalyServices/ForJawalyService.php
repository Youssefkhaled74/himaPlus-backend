<?php

namespace App\Http\ServicesLayer\ForJawalyServices;

use Illuminate\Support\Facades\Http;

class ForJawalyService
{
    public function sendSMS($phone, string $code)
    {
        $headers = [
            "Accept: application/json",
            "Content-Type: application/json"
        ];
        $data = [
            "messages" => [[
                "text" => "مرحب بكم في تطبيق هيما بالس واليك رمز التاكيد: " . $code,
                "numbers" => [$phone],
                "sender" => 'TechPack'
            ]]
        ];
        $response = Http::withHeaders($headers)
        ->baseUrl(config("services.forjawaly.base_url"))
        ->withBasicAuth(config("services.forjawaly.key"), config("services.forjawaly.secret"))
        ->post('account/area/sms/send', $data);

        return $response->json();

        // [
        //     "job_id" => "4b29af40-d10b-11ef-84d6-0242592ee337"
        //     "messages" => array:1 [
        //       0 => array:4 [
        //         "inserted_numbers" => 1
        //         "message" => array:32 [
        //           "account_id" => 16448
        //           "approve_status" => 3
        //           "job_id" => "4b29af40-d10b-11ef-84d6-0242592ee337"
        //           "webhook" => null
        //           "token_uuid" => "b266f632-5e0f-11ef-a2e2-00163ea420cf"
        //           "agent_browser" => ""
        //           "agent_os" => ""
        //           "agent_engine" => ""
        //           "agent_device" => ""
        //           "agent" => "GuzzleHttp/7"
        //           "ip" => "41.233.202.87"
        //           "from_site" => false
        //           "is_ads_groups" => 0
        //           "app" => null
        //           "ver" => null
        //           "text" => "8321"
        //           "is_encrypted" => 1
        //           "sender_id" => 217302
        //           "sender_name" => "TechPack"
        //           "encoding" => "GSM_7BIT"
        //           "length" => 4
        //           "per_message" => 160
        //           "p_type" => 1
        //           "remaining" => 156
        //           "messages" => 1
        //           "send_at" => null
        //           "send_at_zone" => null
        //           "send_at_system" => null
        //           "updated_at" => "2025-01-12T17:33:10.000000Z"
        //           "created_at" => "2025-01-12T17:33:10.000000Z"
        //           "id" => 59041643
        //           "sms_message_numbers_count" => 1
        //         ]
        //         "no_package" => []
        //         "has_more_iso_code" => []
        //       ]
        //     ]
        //     "code" => 200
        //     "message" => "تمت العملية بنجاح"
        // ]

    }
}
