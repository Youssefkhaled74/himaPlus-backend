<?php

namespace App\Http\ServicesLayer\FairbaseServices;

use Illuminate\Support\Facades\Http;
// use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client as GoogleClient;
use Illuminate\Support\Str;

class FairbaseService
{
    public function pushNotification(string $deviceToken, string $title, string $body, string $action_type, string $target_id)
    {

        $firebaseData = $this->getFirebaseData();
        $projectId = $firebaseData['projectId']; 
        $accessToken = $firebaseData['accessToken'];
        
        if ($deviceToken == 'all') {
            $key = 'topic'; 
            $value = 'all';
        } elseif ($deviceToken == 'chat') {
            $key = 'topic'; 
            $value = "chat_group_$target_id";
        } else {
            $key = 'token';
            $value = $deviceToken;
        }
        $payload = [
            'message' => [
                $key => $value,
                // 'topic' => 'all',
                // 'token' => $deviceToken,
                // 'token' => "eS93IYedo0EXr6_htZu5ZQ:APA91bFqoMg61yrHdGMYcAXyY0248kipSG6kFrscY6kqlEjm6_gJkAHzAlYvhIUKERHzGYpu9KuUtWq3cHhWoyyK_lNi8gRhfhDVmK3bXdAZB6wowTsX7Rg",
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => [
                    'target_id'  => $target_id,
                    'action_type'  => $action_type,
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ],
            ],
        ];
        $response = Http::withToken($accessToken)->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);  
        return $response->json();

    }

    public function getFirebaseData()
    {
        $credentialsPath = base_path('app/Http/ServicesLayer/FairbaseServices/hema-pulse-firebase-adminsdk-fbsvc-27f8bfe54e.json');
        $credentials = json_decode(file_get_contents($credentialsPath), true);
        $response['projectId'] = $credentials['project_id'];    
        
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsPath); 
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging'); 
        $token = $client->fetchAccessTokenWithAssertion();
        $response['accessToken'] = $token['access_token'];
        return $response;
    }

    public function saveChatMessage($message, ?string $actionType = null, ?string $targetId = null, ?string $fcm_token = null): array 
    {
        $payload = [
            'id'              => $message['id'],
            'text'            => $message['message'],
            'sender_id'       => $message['sender_id'],
            'receiver_id'     => $message['receiver_id'],
            'conversation_id' => $message['conversation_id'],
            'type'            => $message['message_type'],
            'action_type'     => $actionType,
            'target_id'       => $targetId,
            'created_at'      => now()->toISOString(),
            'created_ts'      => now()->timestamp,
        ];
        $resp = Http::post('https://hema-pulse-default-rtdb.europe-west1.firebasedatabase.app/' . "chats/conversation_{$message['conversation_id']}/messages.json", $payload);
        if ($resp->failed()) {
            return [
                'ok'     => false,
                'error'  => [
                    'status' => $resp->status(),
                    'body'   => $resp->body(),
                ],
            ];
        }
        $data = $resp->json();
        $autoKey = $data['name'] ?? null;

        Http::put('https://hema-pulse-default-rtdb.europe-west1.firebasedatabase.app/' . "chats/conversation_{$message['conversation_id']}/last.json", $payload)->throw();
        return [
            'ok' => true,
            'key' => $autoKey,
            'message' => $payload,
        ];

    }

    
}

