<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'id' => 1,
                'created_at' => null,
                'updated_at' => '2025-10-07 18:33:45',
                'name' => 'AmrHussien',
                'email' => 'hema@gmail.com',
                'phone' => '123456',
                'img' => 'admin/assets/images/admins/175986922558122.webp',
                'password' => '$2y$10$NJFN1sueb26Fw4t2zHWEqOIw0tjSQaZw9BpkeXqKFYoPuo9cLh//2',
                'deleted_at' => null,
                'is_activate' => 1,
                'report_id' => 1,
            ],
        ]);
    }
}
