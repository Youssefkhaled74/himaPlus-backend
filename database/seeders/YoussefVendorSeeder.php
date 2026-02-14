<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTimeline;
use App\Models\Offer;
use App\Models\Rating;
use App\Models\Notification;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class YoussefVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get existing YOUSSEF vendor user
        $vendor = User::firstOrCreate(
            ['email' => 'youssef@vendor.test'],
            [
                'name' => 'YOUSSEF',
                'password' => Hash::make('password123'),
                'mobile' => '0501234567',
                'iban' => 'SA1234567890123456789012',
                'branch' => 'Main Branch',
                'tax_number' => '123456789',
                'cr_number' => 'CR123456789',
                'location' => 'Riyadh, Saudi Arabia',
                'img' => 'storage/vendors/youssef.jpg',
                'user_type' => 2, // Vendor type
                'mobile_verified_at' => now(),
                'email_verified_at' => now(),
                'lang' => 'ar',
            ]
        );

        // Update vendor info to ensure latest data
        $vendor->update([
            'name' => 'YOUSSEF',
            'mobile' => '0501234567',
            'iban' => 'SA1234567890123456789012',
            'branch' => 'Main Branch',
            'tax_number' => '123456789',
            'cr_number' => 'CR123456789',
            'location' => 'Riyadh, Saudi Arabia',
            'lang' => 'ar',
        ]);

        $isNew = $vendor->wasRecentlyCreated;
        $status = $isNew ? 'Created' : 'Using existing';
        echo "✓ {$status} vendor user: YOUSSEF (ID: {$vendor->id})\n";

        // Get categories for products
        $categories = Category::limit(5)->get();
        if ($categories->isEmpty()) {
            echo "⚠ No categories found. Creating sample categories...\n";
            $categories = collect([
                Category::create(['name' => 'Medical Supplies']),
                Category::create(['name' => 'Equipment']),
                Category::create(['name' => 'Laboratory']),
                Category::create(['name' => 'Pharmaceuticals']),
                Category::create(['name' => 'Consumables']),
            ]);
        }

        // Create 10 products for the vendor
        $products = [];
        $productNames = [
            'Digital Blood Pressure Monitor',
            'Disposable Syringes (100 Pack)',
            'Surgical Gloves Nitrile',
            'Clinical Thermometer Digital',
            'Oxygen Saturation Monitor',
            'Sterile Wound Dressing Kit',
            'Medical Gauze Pack',
            'IV Stand Stainless Steel',
            'Examination Bed',
            'Sterilization Autoclave',
        ];

        $productDescriptions = [
            'Professional grade digital blood pressure monitor with large display',
            'Sterile disposable syringes with safety features',
            'Latex-free nitrile examination gloves',
            'Fast and accurate digital thermometer',
            'Non-invasive oxygen saturation monitor with display',
            'Complete sterile dressing kit for wound care',
            'Medical grade sterile gauze pads',
            'Adjustable stainless steel IV stand for hospitals',
            'Professional examination and treatment bed',
            'Medical grade sterilization autoclave for surgical instruments',
        ];

        $prices = [450, 280, 95, 150, 550, 320, 180, 950, 2500, 5500];
        $quantities = [50, 200, 100, 80, 30, 40, 150, 15, 8, 5];

        for ($i = 0; $i < 10; $i++) {
            // Check if product already exists for this vendor
            $product = Product::where('provider_id', $vendor->id)
                ->where('name', $productNames[$i])
                ->first();

            if (!$product) {
                $product = Product::create([
                    'name' => $productNames[$i],
                    'desc' => $productDescriptions[$i],
                    'category_id' => $categories[$i % count($categories)]->id,
                    'price' => $prices[$i],
                    'stock_quantity' => $quantities[$i],
                    'img' => 'storage/products/sample-' . ($i + 1) . '.jpg',
                    'imgs' => json_encode([
                        'storage/products/sample-' . ($i + 1) . '.jpg',
                        'storage/products/sample-' . ($i + 1) . '-alt.jpg',
                    ]),
                    'provider_id' => $vendor->id,
                    'is_activate' => 1,
                ]);
                echo "✓ Created product: {$product->name} (ID: {$product->id})\n";
            } else {
                echo "⊙ Product already exists: {$product->name} (ID: {$product->id})\n";
            }

            $products[] = $product;
        }

        // Create test customers (if not exists)
        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $customer = User::firstOrCreate(
                ['email' => "customer{$i}@test.test"],
                [
                    'name' => "Customer {$i}",
                    'password' => Hash::make('password123'),
                    'mobile' => "050" . str_pad($i, 8, '0', STR_PAD_LEFT),
                    'user_type' => 1, // Customer type
                    'email_verified_at' => now(),
                    'lang' => 'ar',
                ]
            );
            $customers[] = $customer;
        }
        echo "✓ Created/fetched " . count($customers) . " customer accounts\n";

        // Clean up old test data from this vendor (orders, offers, notifications)
        echo "\n📝 Cleaning up old test data for this vendor...\n";
        $ordersCount = Order::where('provider_id', $vendor->id)->count();
        if ($ordersCount > 0) {
            // Delete associated data
            $orderIds = Order::where('provider_id', $vendor->id)->pluck('id')->toArray();
            Offer::where('provider_id', $vendor->id)->delete();
            OrderItem::whereIn('order_id', $orderIds)->delete();
            OrderTimeline::whereIn('order_id', $orderIds)->delete();
            Order::where('provider_id', $vendor->id)->delete();
            Notification::where('user_id', $vendor->id)->delete();
            echo "✓ Cleaned up old orders, offers, and notifications\n";
        }

        // Create 8 orders with different statuses
        $orders = [];

        for ($i = 0; $i < 8; $i++) {
            $order = Order::create([
                'user_id' => $customers[$i % count($customers)]->id,
                'provider_id' => $vendor->id,
                'order_type' => $i % 2, // 0 = normal, 1 = quotation
                'notes' => 'Order for medical supplies - ' . ['Urgent', 'Regular', 'Standard', 'VIP', 'Bulk order'][$i % 5],
                'items_cost' => rand(500, 5000),
                'total_cost' => rand(600, 6000),
            ]);

            $orders[] = $order;
            $typeLabel = $order->order_type == 0 ? 'normal' : 'quotation';
            echo "✓ Created order: #{$order->id} (Type: {$typeLabel})\n";

            // Create order items (1-3 items per order)
            $itemCount = rand(1, 3);
            for ($j = 0; $j < $itemCount; $j++) {
                $itemPrice = min($products[rand(0, count($products) - 1)]->price ?? 100, 500); // Cap at 500
                $quantity = rand(1, 3); // Very small quantity
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $products[rand(0, count($products) - 1)]->id,
                    'quantity' => $quantity,
                    'item_price' => $itemPrice,
                    'total_price' => $itemPrice * $quantity,
                ]);
            }

            // Create order timeline entries
            $timelineStatuses = [
                0 => 'Order Received',
                1 => 'Order Confirmed',
                2 => 'Processing',
                3 => 'Shipped',
            ];

            OrderTimeline::create([
                'order_id' => $order->id,
                'user_id' => $vendor->id,
                'timeline_no' => $i + 1,
                'action_at' => now(),
            ]);
        }

        echo "✓ Created 8 orders with items and timelines\n";

        // Create 6 offers from vendor
        $offers = [];
        $offerStatuses = [0 => 'pending', 1 => 'accepted', 2 => 'rejected'];

        for ($i = 0; $i < 6; $i++) {
            $statusIndex = $i % count($offerStatuses);
            $offer = Offer::create([
                'order_id' => $orders[$i % count($orders)]->id,
                'provider_id' => $vendor->id,
                'cost' => rand(500, 3000),
                'delivery_time' => rand(1, 30),
                'warranty' => rand(1, 24),
                'files' => 'storage/offers/offer-' . ($i + 1) . '.pdf',
                'status' => $statusIndex,
                'notes' => 'Professional offer for medical supplies with quality guarantee',
            ]);

            $offers[] = $offer;
            $statusLabel = $offerStatuses[$statusIndex];
            echo "✓ Created offer: #{$offer->id} (Status: {$statusLabel})\n";
        }

        // Create ratings for products
        $ratings = [];
        $ratingScores = [5, 5, 4, 4, 5, 3, 5, 4, 4, 5];

        for ($i = 0; $i < count($products); $i++) {
            $rating = Rating::create([
                'forable_id' => $products[$i]->id,
                'forable_type' => 'App\Models\Product',
                'user_id' => $customers[$i % count($customers)]->id,
                'rating' => $ratingScores[$i],
                'comment' => [
                    'Excellent quality and fast delivery!',
                    'Very satisfied with this product',
                    'Good product, could be better packaging',
                    'Great service and good product',
                    'Perfect! Highly recommended',
                    'Decent product, average quality',
                ][$i % 6],
                'is_activate' => 1,
            ]);

            $ratings[] = $rating;
            echo "✓ Created rating: {$ratingScores[$i]} stars for product #{$products[$i]->id}\n";
        }

        // Create notifications for vendor
        $notificationTypes = ['order', 'offer', 'message'];
        $notificationMessages = [
            'New order received from Customer',
            'Your offer was accepted!',
            'New message from customer',
            'Order status has been updated',
            'Payment received for your offer',
            'New customer review received',
        ];

        for ($i = 0; $i < 8; $i++) {
            $notification = Notification::create([
                'user_id' => $vendor->id,
                'order_id' => $orders[$i % count($orders)]->id ?? null,
                'title' => 'Notification ' . ($i + 1),
                'content' => $notificationMessages[$i % count($notificationMessages)],
            ]);

            echo "✓ Created notification #{$notification->id}\n";
        }

        echo "\n";
        echo "╔════════════════════════════════════════════════════════════════╗\n";
        echo "║                   YOUSSEF VENDOR SEEDING COMPLETE               ║\n";
        echo "╚════════════════════════════════════════════════════════════════╝\n";
        echo "\n";
        echo "📊 SUMMARY:\n";
        echo "  • Vendor: YOUSSEF\n";
        echo "  • Email: youssef@vendor.test\n";
        echo "  • Password: password123\n";
        echo "  • Products: 10\n";
        echo "  • Orders: 8\n";
        echo "  • Offers: 6\n";
        echo "  • Ratings: 10\n";
        echo "  • Notifications: 8\n";
        echo "  • Customers: 5\n";
        echo "\n";
        echo "🧪 TEST ACCOUNT:\n";
        echo "  Login URL: /vendor/login\n";
        echo "  Email: youssef@vendor.test\n";
        echo "  Password: password123\n";
        echo "\n";
    }
}
