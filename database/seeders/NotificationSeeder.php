<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $notifications = [];
        $titles = ['Payment Received', 'Order Updated', 'New Offer Available', 'Order Confirmed', 'Item Delivered'];
        $contents = ['Your payment has been processed', 'Your order status has been updated', 'A new offer is available for you', 'Your order has been confirmed', 'Your item has been delivered'];
        
        for ($i = 1; $i <= 190; $i++) {
            $user_id = ((($i - 1) % 28) + 1);
            if ($user_id == 1) $user_id = 2;
            
            $type_idx = ($i - 1) % 5;
            
            $notifications[] = [
                'id' => $i,
                'user_id' => $user_id,
                'title' => $titles[$type_idx],
                'content' => $contents[$type_idx],
                'order_id' => (($i - 1) % 64) + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        DB::table('notifications')->insert($notifications);
    }
}
