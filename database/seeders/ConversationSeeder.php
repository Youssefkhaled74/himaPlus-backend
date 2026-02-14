<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('conversations')->insert([
            [
                'id' => 1,
                'user_one_id' => 2,
                'user_two_id' => 1,
                'last_message_at' => null,
                'is_blocked' => false,
                'blocked_by' => null,
                'created_at' => '2025-10-10 10:00:00',
                'updated_at' => '2025-10-10 10:00:00',
            ],
            [
                'id' => 2,
                'user_one_id' => 4,
                'user_two_id' => 5,
                'last_message_at' => null,
                'is_blocked' => false,
                'blocked_by' => null,
                'created_at' => '2025-10-11 10:00:00',
                'updated_at' => '2025-10-11 10:00:00',
            ],
        ]);
    }
}
