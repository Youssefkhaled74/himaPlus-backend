<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('offers')->insert([
            ['id' => 1, 'order_id' => 1, 'provider_id' => 1, 'cost' => '200.00', 'delivery_fee' => '0.00', 'status' => 1, 'delivery_time' => '2 days', 'created_at' => '2025-10-10 00:00:00', 'updated_at' => '2025-10-10 00:00:00'],
            ['id' => 2, 'order_id' => 2, 'provider_id' => 4, 'cost' => '280.00', 'delivery_fee' => '10.00', 'status' => 2, 'delivery_time' => '3 days', 'created_at' => '2025-10-10 01:00:00', 'updated_at' => '2025-10-10 01:00:00'],
            ['id' => 3, 'order_id' => 3, 'provider_id' => 5, 'cost' => '380.00', 'delivery_fee' => '15.00', 'status' => 3, 'delivery_time' => '4 days', 'created_at' => '2025-10-10 02:00:00', 'updated_at' => '2025-10-10 02:00:00'],
            ['id' => 4, 'order_id' => 4, 'provider_id' => 1, 'cost' => '480.00', 'delivery_fee' => '0.00', 'status' => 1, 'delivery_time' => '2 days', 'created_at' => '2025-10-10 03:00:00', 'updated_at' => '2025-10-10 03:00:00'],
            ['id' => 5, 'order_id' => 5, 'provider_id' => 6, 'cost' => '580.00', 'delivery_fee' => '20.00', 'status' => 2, 'delivery_time' => '5 days', 'created_at' => '2025-10-10 04:00:00', 'updated_at' => '2025-10-10 04:00:00'],
            ['id' => 6, 'order_id' => 6, 'provider_id' => 4, 'cost' => '680.00', 'delivery_fee' => '25.00', 'status' => 1, 'delivery_time' => '3 days', 'created_at' => '2025-10-10 05:00:00', 'updated_at' => '2025-10-10 05:00:00'],
            ['id' => 7, 'order_id' => 7, 'provider_id' => 5, 'cost' => '380.00', 'delivery_fee' => '10.00', 'status' => 1, 'delivery_time' => '4 days', 'created_at' => '2025-10-10 06:00:00', 'updated_at' => '2025-10-10 06:00:00'],
            ['id' => 8, 'order_id' => 8, 'provider_id' => 1, 'cost' => '280.00', 'delivery_fee' => '0.00', 'status' => 3, 'delivery_time' => '2 days', 'created_at' => '2025-10-10 07:00:00', 'updated_at' => '2025-10-10 07:00:00'],
            ['id' => 9, 'order_id' => 9, 'provider_id' => 1, 'cost' => '120.00', 'delivery_fee' => '5.00', 'status' => 1, 'delivery_time' => '1 day', 'created_at' => '2025-10-11 16:00:00', 'updated_at' => '2025-10-11 16:00:00'],
            ['id' => 10, 'order_id' => 10, 'provider_id' => 4, 'cost' => '280.00', 'delivery_fee' => '10.00', 'status' => 1, 'delivery_time' => '3 days', 'created_at' => '2025-10-11 17:00:00', 'updated_at' => '2025-10-11 17:00:00'],
        ]);
    }
}
