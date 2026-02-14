<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'created_at' => '2025-10-07 22:16:06',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 1,
                'provider_id' => 1,
                'name' => 'Product 1',
                'desc' => 'Description for product 1',
                'img' => 'admin/assets/images/products/175988013899911.png',
                'price' => '100.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 2,
                'created_at' => '2025-10-07 22:16:24',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 2,
                'provider_id' => 1,
                'name' => 'Product 2',
                'desc' => 'Description for product 2',
                'img' => 'admin/assets/images/products/175988014200999.png',
                'price' => '200.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 3,
                'created_at' => '2025-10-07 22:16:42',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 3,
                'provider_id' => 4,
                'name' => 'Product 3',
                'desc' => 'Description for product 3',
                'img' => 'admin/assets/images/products/175988014499384.png',
                'price' => '300.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 4,
                'created_at' => '2025-10-07 22:17:01',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 4,
                'provider_id' => 4,
                'name' => 'Product 4',
                'desc' => 'Description for product 4',
                'img' => 'admin/assets/images/products/175988014742876.png',
                'price' => '400.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 5,
                'created_at' => '2025-10-07 22:17:22',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 5,
                'provider_id' => 5,
                'name' => 'Product 5',
                'desc' => 'Description for product 5',
                'img' => 'admin/assets/images/products/175988014958234.png',
                'price' => '500.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 6,
                'created_at' => '2025-10-07 22:17:41',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 6,
                'provider_id' => 5,
                'name' => 'Product 6',
                'desc' => 'Description for product 6',
                'img' => 'admin/assets/images/products/175988015169999.png',
                'price' => '600.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
            [
                'id' => 7,
                'created_at' => '2025-10-07 22:18:02',
                'updated_at' => '2025-10-10 13:37:49',
                'category_id' => 7,
                'provider_id' => 6,
                'name' => 'Product 7',
                'desc' => 'Description for product 7',
                'img' => 'admin/assets/images/products/175988015385345.png',
                'price' => '700.00',
                'is_activate' => 1,
                'report_id' => 1,
            ],
        ]);
    }
}
