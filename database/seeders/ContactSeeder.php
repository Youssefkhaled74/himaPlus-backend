<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contacts')->insert([
            ['id' => 1, 'created_at' => '2025-10-10 09:30:15', 'updated_at' => '2025-10-10 09:30:15', 'email' => 'john@example.com', 'mobile' => '1234567890', 'location' => 'New York', 'details' => 'Test contact 1', 'is_activate' => 1],
            ['id' => 2, 'created_at' => '2025-10-12 14:20:45', 'updated_at' => '2025-10-12 14:20:45', 'email' => 'jane@example.com', 'mobile' => '0987654321', 'location' => 'Los Angeles', 'details' => 'Test contact 2', 'is_activate' => 1],
            ['id' => 3, 'created_at' => '2025-10-15 11:45:20', 'updated_at' => '2025-10-15 11:45:20', 'email' => 'bob@example.com', 'mobile' => '5555555555', 'location' => 'Chicago', 'details' => 'Test contact 3', 'is_activate' => 1],
            ['id' => 4, 'created_at' => '2025-10-18 16:10:30', 'updated_at' => '2025-10-18 16:10:30', 'email' => 'alice@example.com', 'mobile' => '6666666666', 'location' => 'Houston', 'details' => 'Test contact 4', 'is_activate' => 1],
            ['id' => 5, 'created_at' => '2025-10-22 10:25:15', 'updated_at' => '2025-10-22 10:25:15', 'email' => 'charlie@example.com', 'mobile' => '7777777777', 'location' => 'Phoenix', 'details' => 'Test contact 5', 'is_activate' => 1],
            ['id' => 6, 'created_at' => '2025-11-08 13:50:40', 'updated_at' => '2025-11-08 13:50:40', 'email' => 'diana@example.com', 'mobile' => '8888888888', 'location' => 'Philadelphia', 'details' => 'Test contact 6', 'is_activate' => 1],
            ['id' => 7, 'created_at' => '2025-11-15 09:15:25', 'updated_at' => '2025-11-15 09:15:25', 'email' => 'edward@example.com', 'mobile' => '9999999999', 'location' => 'San Antonio', 'details' => 'Test contact 7', 'is_activate' => 1],
        ]);
    }
}
