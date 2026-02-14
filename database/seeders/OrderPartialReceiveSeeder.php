<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderPartialReceiveSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_partial_receive')->insert([
            ['id' => 1, 'order_id' => 3, 'user_id' => 2, 'received_quantity' => 1, 'created_at' => '2025-10-10 02:30:00', 'updated_at' => '2025-10-10 02:30:00', 'is_activate' => 1],
            ['id' => 2, 'order_id' => 6, 'user_id' => 2, 'received_quantity' => 2, 'created_at' => '2025-10-10 05:30:00', 'updated_at' => '2025-10-10 05:30:00', 'is_activate' => 1],
            ['id' => 3, 'order_id' => 2, 'user_id' => 2, 'received_quantity' => 1, 'created_at' => '2025-10-10 01:30:00', 'updated_at' => '2025-10-10 01:30:00', 'is_activate' => 1],
            ['id' => 4, 'order_id' => 5, 'user_id' => 4, 'received_quantity' => 3, 'created_at' => '2025-10-10 04:30:00', 'updated_at' => '2025-10-10 04:30:00', 'is_activate' => 1],
            ['id' => 5, 'order_id' => 4, 'user_id' => 4, 'received_quantity' => 2, 'created_at' => '2025-10-10 03:30:00', 'updated_at' => '2025-10-10 03:30:00', 'is_activate' => 1],
        ]);
    }
}
