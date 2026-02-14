<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoriteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('favorites')->insert([
            ['id' => 1, 'created_at' => '2025-10-07 22:22:45', 'updated_at' => '2025-10-07 22:22:45', 'user_id' => 2, 'product_id' => 1, 'is_activate' => 1],
            ['id' => 2, 'created_at' => '2025-10-07 22:23:10', 'updated_at' => '2025-10-07 22:23:10', 'user_id' => 2, 'product_id' => 3, 'is_activate' => 1],
            ['id' => 3, 'created_at' => '2025-10-07 22:23:35', 'updated_at' => '2025-10-07 22:23:35', 'user_id' => 4, 'product_id' => 2, 'is_activate' => 1],
            ['id' => 4, 'created_at' => '2025-10-07 22:24:00', 'updated_at' => '2025-10-07 22:24:00', 'user_id' => 4, 'product_id' => 5, 'is_activate' => 1],
            ['id' => 5, 'created_at' => '2025-10-10 13:30:20', 'updated_at' => '2025-10-10 13:30:20', 'user_id' => 2, 'product_id' => 6, 'is_activate' => 1],
            ['id' => 6, 'created_at' => '2025-10-11 15:35:45', 'updated_at' => '2025-10-11 15:35:45', 'user_id' => 3, 'product_id' => 4, 'is_activate' => 1],
            ['id' => 7, 'created_at' => '2025-10-15 10:20:15', 'updated_at' => '2025-10-15 10:20:15', 'user_id' => 2, 'product_id' => 7, 'is_activate' => 1],
            ['id' => 8, 'created_at' => '2025-10-17 14:45:30', 'updated_at' => '2025-10-17 14:45:30', 'user_id' => 4, 'product_id' => 1, 'is_activate' => 1],
            ['id' => 9, 'created_at' => '2025-10-20 11:15:50', 'updated_at' => '2025-10-20 11:15:50', 'user_id' => 2, 'product_id' => 3, 'is_activate' => 1],
            ['id' => 10, 'created_at' => '2025-10-25 16:30:20', 'updated_at' => '2025-10-25 16:30:20', 'user_id' => 4, 'product_id' => 5, 'is_activate' => 1],
            ['id' => 11, 'created_at' => '2025-11-08 12:40:15', 'updated_at' => '2025-11-08 12:40:15', 'user_id' => 21, 'product_id' => 2, 'is_activate' => 1],
            ['id' => 12, 'created_at' => '2025-11-11 09:55:45', 'updated_at' => '2025-11-11 09:55:45', 'user_id' => 22, 'product_id' => 4, 'is_activate' => 1],
            ['id' => 13, 'created_at' => '2025-11-15 14:20:10', 'updated_at' => '2025-11-15 14:20:10', 'user_id' => 23, 'product_id' => 6, 'is_activate' => 1],
            ['id' => 14, 'created_at' => '2025-11-18 10:35:30', 'updated_at' => '2025-11-18 10:35:30', 'user_id' => 26, 'product_id' => 1, 'is_activate' => 1],
            ['id' => 15, 'created_at' => '2025-11-22 15:50:20', 'updated_at' => '2025-11-22 15:50:20', 'user_id' => 28, 'product_id' => 7, 'is_activate' => 1],
        ]);
    }
}
