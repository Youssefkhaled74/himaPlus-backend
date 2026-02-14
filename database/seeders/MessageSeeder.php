<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [];
        for ($i = 1; $i <= 31; $i++) {
            $conversation_id = (($i - 1) % 2) + 1;
            $sender_id = ($i % 2 == 0) ? 2 : 1;
            $receiver_id = ($i % 2 == 0) ? 1 : 2;
            if ($conversation_id == 2) {
                $sender_id = ($i % 2 == 0) ? 4 : 5;
                $receiver_id = ($i % 2 == 0) ? 5 : 4;
            }
            
            // Calculate proper datetime with hour wrapping
            $hours = $i - 1;
            $days = intdiv($hours, 24);
            $hour = $hours % 24;
            $timestamp = date('Y-m-d H:i:s', strtotime('2025-10-10 00:00:00 +' . $days . ' days +' . $hour . ' hours'));
            
            $messages[] = [
                'id' => $i,
                'conversation_id' => $conversation_id,
                'sender_id' => $sender_id,
                'receiver_id' => $receiver_id,
                'message' => 'Test message ' . $i,
                'message_type' => 'text',
                'is_read' => $i < 20 ? true : false,
                'is_deleted_by_sender' => false,
                'is_deleted_by_receiver' => false,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }
        
        DB::table('messages')->insert($messages);
    }
}
