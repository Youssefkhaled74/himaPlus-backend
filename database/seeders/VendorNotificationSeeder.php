<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class VendorNotificationSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get vendor user with ID 41
        $vendor = User::find(41);
        
        if (!$vendor) {
            echo "Vendor user with ID 41 not found.\n";
            return;
        }

        $notifications = [
            [
                'user_id' => $vendor->id,
                'title' => 'New Order Received',
                'message' => 'You have received a new purchase order #1234 from King Fahad Hospital.',
                'type' => 'order',
                'action_url' => '/vendor/orders/1234',
                'meta' => json_encode(['order_id' => 1234, 'order_type' => 'purchase']),
                'read_at' => null,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'Offer Accepted',
                'message' => 'Your offer for Order #1230 has been accepted by the customer.',
                'type' => 'offer',
                'action_url' => '/vendor/orders/my-offers',
                'meta' => json_encode(['offer_id' => 567, 'order_id' => 1230]),
                'read_at' => now()->subHour(),
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHour(),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'Scheduled Order Upcoming',
                'message' => 'Scheduled order #1225 delivery is due in 2 days. Please prepare the shipment.',
                'type' => 'scheduled',
                'action_url' => '/vendor/orders/1225',
                'meta' => json_encode(['order_id' => 1225, 'next_shipment' => now()->addDays(2)->format('Y-m-d')]),
                'read_at' => null,
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(8),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'New Rating Received',
                'message' => 'You received a 5-star rating from Prince Sultan Hospital for your recent delivery.',
                'type' => 'rating',
                'action_url' => '/vendor/ratings',
                'meta' => json_encode(['rating' => 5, 'order_id' => 1220]),
                'read_at' => null,
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'System Maintenance Notice',
                'message' => 'The platform will undergo scheduled maintenance on Sunday from 2 AM to 4 AM.',
                'type' => 'system',
                'action_url' => null,
                'meta' => json_encode(['maintenance_date' => now()->addDays(3)->format('Y-m-d')]),
                'read_at' => now()->subMinutes(30),
                'created_at' => now()->subDay(),
                'updated_at' => now()->subMinutes(30),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'Offer Pending Review',
                'message' => 'Your offer for quotation request #1240 is pending customer review.',
                'type' => 'offer',
                'action_url' => '/vendor/orders/my-offers',
                'meta' => json_encode(['offer_id' => 580, 'order_id' => 1240]),
                'read_at' => null,
                'created_at' => now()->subHours(16),
                'updated_at' => now()->subHours(16),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'Scheduled Order Paused',
                'message' => 'Scheduled order #1210 has been paused by the customer. Please contact them for more details.',
                'type' => 'scheduled',
                'action_url' => '/vendor/orders/1210',
                'meta' => json_encode(['order_id' => 1210, 'status' => 'paused']),
                'read_at' => now()->subDays(1),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'user_id' => $vendor->id,
                'title' => 'New Quotation Request',
                'message' => 'You have received a new quotation request for medical supplies from Al Noor Clinic.',
                'type' => 'order',
                'action_url' => '/vendor/orders',
                'meta' => json_encode(['order_id' => 1245, 'order_type' => 'quotation']),
                'read_at' => null,
                'created_at' => now()->subMinutes(45),
                'updated_at' => now()->subMinutes(45),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        echo "Successfully seeded " . count($notifications) . " vendor notifications.\n";
    }
}
