<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Vendor14OffersSeeder extends Seeder
{
    public function run(): void
    {
        // Create a few orders for provider_id = 14
        $now = date('Y-m-d H:i:s');
        $orders = [
            ['created_at' => $now, 'updated_at' => $now, 'user_id' => 2, 'provider_id' => 14, 'items_cost' => '120.00', 'vat_amount' => '6.00', 'delivery_fee' => '10.00', 'discount' => '0.00', 'total_cost' => '136.00', 'address' => 'Seeder Address 1', 'notes' => '', 'payment_status' => 0],
            ['created_at' => $now, 'updated_at' => $now, 'user_id' => 2, 'provider_id' => 14, 'items_cost' => '220.00', 'vat_amount' => '11.00', 'delivery_fee' => '15.00', 'discount' => '0.00', 'total_cost' => '246.00', 'address' => 'Seeder Address 2', 'notes' => '', 'payment_status' => 0],
            ['created_at' => $now, 'updated_at' => $now, 'user_id' => 4, 'provider_id' => 14, 'items_cost' => '320.00', 'vat_amount' => '16.00', 'delivery_fee' => '20.00', 'discount' => '0.00', 'total_cost' => '356.00', 'address' => 'Seeder Address 3', 'notes' => '', 'payment_status' => 1],
        ];

        $insertedOrderIds = [];
        foreach ($orders as $ord) {
            $id = DB::table('orders')->insertGetId($ord);
            $insertedOrderIds[] = $id;
        }

        // Create offers for these orders by provider 14
        $offers = [];
        foreach ($insertedOrderIds as $i => $orderId) {
            $offers[] = [
                'order_id' => $orderId,
                'provider_id' => 14,
                'cost' => number_format(100 + ($i * 50), 2, '.', ''),
                'delivery_fee' => '0.00',
                'delivery_time' => (2 + $i) . ' days',
                'warranty' => $i === 2 ? '1 year' : null,
                // Match DB numeric status values used elsewhere (see OfferSeeder)
                'status' => $i === 0 ? 1 : ($i === 1 ? 2 : 3),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('offers')->insert($offers);
    }
}
