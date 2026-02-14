<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->insert([
            [
                'id' => 1,
                'name' => 'Saudi Arabia',
                'created_at' => '2025-10-07 22:12:31',
                'updated_at' => '2025-10-07 22:12:31',
                'is_activate' => 1,
            ],
            [
                'id' => 2,
                'name' => 'United Arab Emirates',
                'created_at' => '2025-10-07 22:12:37',
                'updated_at' => '2025-10-07 22:12:37',
                'is_activate' => 1,
            ],
        ]);
    }
}
