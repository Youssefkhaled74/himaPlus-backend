<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->updateOrInsert(
            ['id' => 1],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'name' => 'Youssef Admin',
                'email' => 'youssef@admin.com',
                'phone' => '123456',
                'img' => 'admin/assets/images/admins/175986922558122.webp',
                'password' => Hash::make('12345678'),
                'deleted_at' => null,
                'is_activate' => 1,
                'report_id' => 1,
            ]
        );
    }
}
