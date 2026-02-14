<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTimelineSeeder extends Seeder
{
    public function run(): void
    {
        $records = [];
        
        // Timeline progress for orders: 1 => Created, 2 => Confirmed, 3 => Processing, 4 => Shipped, 5 => Delivered, 6 => Completed
        $timeline_data = [
            [1, 1, '2025-10-09 23:57:21'],
            [1, 3, '2025-10-10 00:15:45'],
            [2, 1, '2025-10-10 00:02:37'],
            [2, 3, '2025-10-10 00:30:20'],
            [3, 1, '2025-10-10 00:04:56'],
            [3, 2, '2025-10-10 00:45:10'],
            [3, 3, '2025-10-10 02:00:25'],
            [3, 6, '2025-10-10 02:56:22'],
        ];
        
        $id = 1;
        foreach ($timeline_data as $item) {
            $records[] = [
                'id' => $id++,
                'order_id' => $item[0],
                'timeline_no' => $item[1],
                'action_at' => $item[2],
                'created_at' => $item[2],
                'updated_at' => $item[2],
            ];
        }
        
        // Add more records to reach 81 - start from id 9 to avoid duplicates
        for ($i = 9; $i <= 81; $i++) {
            $order_id = (($i - 1) % 64) + 1;
            $timeline_no_options = [1, 2, 3, 4, 5, 6];
            $timeline_no = $timeline_no_options[($i - 1) % 6];
            $timestamp = date('Y-m-d H:i:s', strtotime('2025-10-09 +' . (($i - 8) * 2) . ' hours'));
            
            $records[] = [
                'id' => $i,
                'order_id' => $order_id,
                'timeline_no' => $timeline_no,
                'action_at' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }
        
        DB::table('order_timeline')->insert($records);
    }
}
