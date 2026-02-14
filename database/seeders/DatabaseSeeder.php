<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            CouponSeeder::class,
            CartSeeder::class,
            FavoriteSeeder::class,
            ContactSeeder::class,
            InfoSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            OrderTimelineSeeder::class,
            OfferSeeder::class,
            OrderPartialReceiveSeeder::class,
            RatingSeeder::class,
            ConversationSeeder::class,
            MessageSeeder::class,
            NotificationSeeder::class,
            YoussefVendorSeeder::class,
            Vendor14OffersSeeder::class,
        ]);
    }
}
