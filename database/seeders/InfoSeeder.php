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
                'email' => 'info@himaplus.com',
                'vat' => '300000000000003',
                'desc' => 'Hima Plus is a leading online platform for medical supplies and healthcare products.',
                'message' => 'Welcome to Hima Plus',
                'vision' => 'Our vision is to provide quality healthcare products to everyone',
                'asks' => 'Frequently Asked Questions',
                'abouts' => 'About Hima Plus Company',
                'terms' => 'Terms and conditions for Hima Plus services',
                'privacy_policies' => 'Privacy policy information - we protect your data',
                'is_activate' => 1,
            ],
        ]);
    }
}
