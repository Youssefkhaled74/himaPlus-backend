<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('info')->insert([
            [
                'id' => 1,
                'created_at' => '2025-10-07 22:11:42',
                'updated_at' => '2025-10-07 22:11:42',
                'mobile' => '+966123456789',
                'email' => 'info@Hemaplus.com',
                'vat' => '300000000000003',
                'desc' => 'Hema is a leading online platform for medical supplies and healthcare products.',
                'message' => 'Welcome to Hema',
                'vision' => 'Our vision is to provide quality healthcare products to everyone',
                'asks' => 'Frequently Asked Questions',
                'abouts' => 'About Hema Company',
                'terms' => 'Terms and conditions for Hema services',
                'privacy_policies' => 'Privacy policy information - we protect your data',
                'is_activate' => 1,
            ],
        ]);
    }
}

