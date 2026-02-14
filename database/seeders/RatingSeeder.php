<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ratings')->insert([
            ['id' => 1, 'user_id' => 2, 'forable_id' => 1, 'forable_type' => 'App\\Models\\User', 'rating' => 5, 'comment' => 'Excellent service', 'created_at' => '2025-10-10 03:00:00', 'updated_at' => '2025-10-10 03:00:00'],
            ['id' => 2, 'user_id' => 2, 'forable_id' => 1, 'forable_type' => 'App\\Models\\Product', 'rating' => 4, 'comment' => 'Good quality', 'created_at' => '2025-10-11 03:00:00', 'updated_at' => '2025-10-11 03:00:00'],
            ['id' => 3, 'user_id' => 4, 'forable_id' => 4, 'forable_type' => 'App\\Models\\User', 'rating' => 5, 'comment' => 'Very satisfied', 'created_at' => '2025-10-12 03:00:00', 'updated_at' => '2025-10-12 03:00:00'],
            ['id' => 4, 'user_id' => 4, 'forable_id' => 3, 'forable_type' => 'App\\Models\\Product', 'rating' => 4, 'comment' => 'Nice product', 'created_at' => '2025-10-13 03:00:00', 'updated_at' => '2025-10-13 03:00:00'],
            ['id' => 5, 'user_id' => 2, 'forable_id' => 5, 'forable_type' => 'App\\Models\\User', 'rating' => 3, 'comment' => 'Average service', 'created_at' => '2025-10-14 03:00:00', 'updated_at' => '2025-10-14 03:00:00'],
            ['id' => 6, 'user_id' => 4, 'forable_id' => 2, 'forable_type' => 'App\\Models\\Product', 'rating' => 5, 'comment' => 'Perfect', 'created_at' => '2025-10-15 03:00:00', 'updated_at' => '2025-10-15 03:00:00'],
            ['id' => 7, 'user_id' => 21, 'forable_id' => 3, 'forable_type' => 'App\\Models\\User', 'rating' => 4, 'comment' => 'Good experience', 'created_at' => '2025-11-08 15:00:00', 'updated_at' => '2025-11-08 15:00:00'],
            ['id' => 8, 'user_id' => 22, 'forable_id' => 5, 'forable_type' => 'App\\Models\\Product', 'rating' => 5, 'comment' => 'Highly recommend', 'created_at' => '2025-11-09 15:00:00', 'updated_at' => '2025-11-09 15:00:00'],
            ['id' => 9, 'user_id' => 23, 'forable_id' => 4, 'forable_type' => 'App\\Models\\User', 'rating' => 3, 'comment' => 'Okay', 'created_at' => '2025-11-10 15:00:00', 'updated_at' => '2025-11-10 15:00:00'],
            ['id' => 10, 'user_id' => 26, 'forable_id' => 1, 'forable_type' => 'App\\Models\\Product', 'rating' => 4, 'comment' => 'Good value', 'created_at' => '2025-11-16 15:00:00', 'updated_at' => '2025-11-16 15:00:00'],
            ['id' => 11, 'user_id' => 27, 'forable_id' => 5, 'forable_type' => 'App\\Models\\User', 'rating' => 5, 'comment' => 'Excellent', 'created_at' => '2025-11-17 15:00:00', 'updated_at' => '2025-11-17 15:00:00'],
            ['id' => 12, 'user_id' => 28, 'forable_id' => 6, 'forable_type' => 'App\\Models\\Product', 'rating' => 4, 'comment' => 'Great quality', 'created_at' => '2025-11-18 15:00:00', 'updated_at' => '2025-11-18 15:00:00'],
            ['id' => 13, 'user_id' => 2, 'forable_id' => 6, 'forable_type' => 'App\\Models\\User', 'rating' => 5, 'comment' => 'Perfect service', 'created_at' => '2025-12-01 15:00:00', 'updated_at' => '2025-12-01 15:00:00'],
        ]);
    }
}
