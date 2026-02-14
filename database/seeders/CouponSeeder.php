<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('coupons')->insert([
            [
                'id' => 1,
                'created_at' => '2025-10-07 22:26:14',
                'updated_at' => '2025-10-07 22:26:14',
                'name' => 'SAVE10',
                'amount' => 10,
                'type' => 2,
                'is_activate' => 1,
            ],
            [
                'id' => 2,
                'created_at' => '2025-10-07 22:26:36',
                'updated_at' => '2025-10-07 22:26:36',
                'name' => 'SAVE50',
                'amount' => 50,
                'type' => 1,
                'is_activate' => 1,
            ],
            [
                'id' => 3,
                'created_at' => '2025-10-07 22:26:57',
                'updated_at' => '2025-10-07 22:26:57',
                'name' => 'SAVE20',
                'amount' => 20,
                'type' => 2,
                'is_activate' => 1,
            ],
        ]);
    }
}
