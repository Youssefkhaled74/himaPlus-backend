<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'created_at' => '2025-10-07 22:13:11',
                'updated_at' => '2025-10-07 22:13:11',
                'name' => 'Medicines',
                'img' => 'admin/assets/images/categories/175987999166555.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 2,
                'created_at' => '2025-10-07 22:13:26',
                'updated_at' => '2025-10-07 22:13:26',
                'name' => 'Medical Supplies',
                'img' => 'admin/assets/images/categories/175987999486234.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 3,
                'created_at' => '2025-10-07 22:13:40',
                'updated_at' => '2025-10-07 22:13:40',
                'name' => 'Health Care',
                'img' => 'admin/assets/images/categories/175987999735896.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 4,
                'created_at' => '2025-10-07 22:13:54',
                'updated_at' => '2025-10-07 22:13:54',
                'name' => 'Devices',
                'img' => 'admin/assets/images/categories/175987999918923.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 5,
                'created_at' => '2025-10-07 22:14:09',
                'updated_at' => '2025-10-07 22:14:09',
                'name' => 'Equipment',
                'img' => 'admin/assets/images/categories/175988000099999.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 6,
                'created_at' => '2025-10-07 22:14:26',
                'updated_at' => '2025-10-07 22:14:26',
                'name' => 'Vitamins',
                'img' => 'admin/assets/images/categories/175988000306152.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 7,
                'created_at' => '2025-10-07 22:14:42',
                'updated_at' => '2025-10-07 22:14:42',
                'name' => 'Supplements',
                'img' => 'admin/assets/images/categories/175988000507389.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 8,
                'created_at' => '2025-10-07 22:14:58',
                'updated_at' => '2025-10-07 22:14:58',
                'name' => 'Other',
                'img' => 'admin/assets/images/categories/175988000722466.png',
                'is_activate' => 1,
                'report_id' => 1,
            ],
        ]);
    }
}
