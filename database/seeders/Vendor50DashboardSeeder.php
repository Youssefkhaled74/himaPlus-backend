<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Country;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTimeline;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Vendor50DashboardSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $vendor = $this->upsertVendor50();
            $customers = $this->upsertCustomers();
            [$categories, $country] = $this->resolveLookups();

            $this->cleanupVendorData($vendor->id);

            $products = $this->seedProducts($vendor->id, $categories, $country?->id);
            $orders = $this->seedOrders($vendor->id, $customers);
            $this->seedOrderItems($orders, $products);
            $this->seedOrderTimelines($orders, $vendor->id);
            $this->seedOffers($vendor->id, $orders);
            $this->seedRatings($vendor->id, $customers, $products);
            $this->seedNotifications($vendor->id, $orders);
        });

        $this->command?->info('Vendor50DashboardSeeder done.');
        $this->command?->line('Login test vendor: id=50, email=vendor50@test.local, password=password123');
    }

    private function upsertVendor50(): User
    {
        $vendor = User::find(50);

        if (!$vendor) {
            $vendor = new User();
            $vendor->id = 50;
            $vendor->name = 'SaudiMed Supply Co.';
            $vendor->email = 'vendor50@test.local';
            $vendor->password = Hash::make('password123');
        }

        $vendor->mobile = $vendor->mobile ?: '+966501112233';
        $vendor->iban = 'SA4420000001234567890123';
        $vendor->branch = 'Riyadh Main Branch';
        $vendor->tax_number = '300123456700003';
        $vendor->cr_number = '1010123456';
        $vendor->location = 'Riyadh, Saudi Arabia';
        $vendor->user_type = 2;
        $vendor->is_activate = 1;
        $vendor->lang = $vendor->lang ?: 'en';
        $vendor->mobile_verified_at = $vendor->mobile_verified_at ?: now();
        $vendor->email_verified_at = $vendor->email_verified_at ?: now();
        $vendor->save();

        return $vendor;
    }

    private function upsertCustomers(): array
    {
        $payload = [
            ['email' => 'hospital.kfh@test.local', 'name' => 'King Fahad Hospital', 'mobile' => '+966500000101'],
            ['email' => 'hospital.nmc@test.local', 'name' => 'National Medical Center', 'mobile' => '+966500000102'],
            ['email' => 'clinic.alnour@test.local', 'name' => 'Al Nour Clinic', 'mobile' => '+966500000103'],
            ['email' => 'hospital.psh@test.local', 'name' => 'Prince Sultan Hospital', 'mobile' => '+966500000104'],
            ['email' => 'clinic.citycare@test.local', 'name' => 'City Care Clinic', 'mobile' => '+966500000105'],
        ];

        $customers = [];
        foreach ($payload as $row) {
            $customer = User::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'mobile' => $row['mobile'],
                    'password' => Hash::make('password123'),
                    'user_type' => 1,
                    'is_activate' => 1,
                    'lang' => 'en',
                    'email_verified_at' => now(),
                    'mobile_verified_at' => now(),
                ]
            );
            $customers[] = $customer;
        }

        return $customers;
    }

    private function resolveLookups(): array
    {
        $categories = Category::query()->limit(4)->get();
        if ($categories->isEmpty()) {
            $categories = collect([
                Category::create(['name' => 'Medical Devices']),
                Category::create(['name' => 'Consumables']),
                Category::create(['name' => 'Laboratory']),
                Category::create(['name' => 'Imaging']),
            ]);
        }

        $country = Country::query()->first();
        if (!$country) {
            $country = Country::create(['name' => 'Saudi Arabia']);
        }

        return [$categories, $country];
    }

    private function cleanupVendorData(int $vendorId): void
    {
        $productIds = Product::query()->where('provider_id', $vendorId)->pluck('id');
        $orderIds = Order::query()->where('provider_id', $vendorId)->pluck('id');

        if ($orderIds->isNotEmpty()) {
            Offer::query()->where('provider_id', $vendorId)->delete();
            OrderItem::query()->whereIn('order_id', $orderIds)->delete();
            OrderTimeline::query()->whereIn('order_id', $orderIds)->delete();
            Order::query()->whereIn('id', $orderIds)->delete();
        }

        Notification::query()->where('user_id', $vendorId)->delete();
        Rating::query()
            ->where('forable_type', User::class)
            ->where('forable_id', $vendorId)
            ->delete();

        if ($productIds->isNotEmpty()) {
            Rating::query()
                ->where('forable_type', Product::class)
                ->whereIn('forable_id', $productIds)
                ->delete();
            Product::query()->whereIn('id', $productIds)->delete();
        }
    }

    private function seedProducts(int $vendorId, $categories, ?int $countryId): array
    {
        $rows = [
            ['name' => 'Digital X-Ray Machine', 'price' => 9500, 'stock' => 18, 'desc' => 'High-resolution digital X-ray machine for radiology departments.', 'imaging_type' => 'Digital Radiography', 'power' => '220V / 50Hz', 'weight' => '180 kg', 'dimensions' => '150x80x200 cm', 'warranty' => '2 years'],
            ['name' => 'Portable Ultrasound Scanner', 'price' => 8900, 'stock' => 22, 'desc' => 'Portable ultrasound scanner with Doppler support.', 'imaging_type' => 'Ultrasound', 'power' => '110-220V', 'weight' => '9 kg', 'dimensions' => '42x28x10 cm', 'warranty' => '3 years'],
            ['name' => 'ECG Monitor 12-Lead', 'price' => 4900, 'stock' => 40, 'desc' => '12-lead ECG monitor with cloud export and trend charts.', 'imaging_type' => 'Cardiac Monitoring', 'power' => 'AC/DC', 'weight' => '6.5 kg', 'dimensions' => '32x26x11 cm', 'warranty' => '2 years'],
            ['name' => 'Infusion Pump Pro', 'price' => 2200, 'stock' => 65, 'desc' => 'Accurate infusion pump with multi-mode delivery.', 'imaging_type' => 'Therapy Device', 'power' => 'Battery + AC', 'weight' => '2.2 kg', 'dimensions' => '20x14x8 cm', 'warranty' => '2 years'],
            ['name' => 'Patient Bedside Monitor', 'price' => 6900, 'stock' => 26, 'desc' => 'Bedside monitor for ICU with NIBP, SpO2 and ECG modules.', 'imaging_type' => 'Vital Monitoring', 'power' => '220V', 'weight' => '5.2 kg', 'dimensions' => '30x24x12 cm', 'warranty' => '2 years'],
            ['name' => 'Surgical Nitrile Gloves (500)', 'price' => 420, 'stock' => 250, 'desc' => 'Powder-free nitrile gloves for sterile procedures.', 'imaging_type' => null, 'power' => null, 'weight' => '7 kg carton', 'dimensions' => '40x30x22 cm', 'warranty' => 'Shelf life 3 years'],
            ['name' => 'Sterile Syringes 10ml (1000)', 'price' => 760, 'stock' => 180, 'desc' => 'Single-use sterile syringes with Luer lock.', 'imaging_type' => null, 'power' => null, 'weight' => '11 kg carton', 'dimensions' => '45x35x26 cm', 'warranty' => 'Shelf life 5 years'],
            ['name' => 'Anesthesia Workstation', 'price' => 9800, 'stock' => 7, 'desc' => 'Comprehensive anesthesia workstation with safety alarms.', 'imaging_type' => 'Anesthesia', 'power' => '220V / 50Hz', 'weight' => '135 kg', 'dimensions' => '90x75x145 cm', 'warranty' => '3 years'],
        ];

        $products = [];
        foreach ($rows as $i => $row) {
            $products[] = Product::create([
                'name' => $row['name'],
                'category_id' => $categories[$i % $categories->count()]->id,
                'desc' => $row['desc'],
                'price' => $row['price'],
                'stock_quantity' => $row['stock'],
                'img' => 'admin/assets/images/products/seed-product-' . ($i + 1) . '.jpg',
                'imgs' => json_encode([
                    'admin/assets/images/products/seed-product-' . ($i + 1) . '.jpg',
                    'admin/assets/images/products/seed-product-' . ($i + 1) . '-2.jpg',
                ]),
                'imaging_type' => $row['imaging_type'],
                'power' => $row['power'],
                'production_date' => now()->subMonths(rand(2, 18))->toDateString(),
                'expiry_date' => now()->addYears(rand(1, 4))->toDateString(),
                'weight' => $row['weight'],
                'dimensions' => $row['dimensions'],
                'warranty' => $row['warranty'],
                'origin_id' => $countryId,
                'provider_id' => $vendorId,
                'is_activate' => 1,
                'is_offer' => $i % 3 === 0 ? 1 : 0,
                'is_special' => $i % 4 === 0 ? 1 : 0,
            ]);
        }

        return $products;
    }

    private function seedOrders(int $vendorId, array $customers): array
    {
        $orders = [];
        $daysAgo = [1, 2, 3, 5, 8, 12, 20, 28, 35];

        $definitions = [
            ['order_type' => 1, 'request_type' => 1, 'address' => 'King Fahad Hospital - Radiology Dept, Riyadh', 'notes' => 'Urgent imaging equipment delivery.'],
            ['order_type' => 2, 'request_type' => 1, 'address' => 'National Medical Center - Purchasing, Jeddah', 'notes' => 'Quotation request for ICU monitors.'],
            ['order_type' => 3, 'request_type' => 1, 'address' => 'Prince Sultan Hospital - Maintenance Unit, Dammam', 'notes' => 'Maintenance request for anesthesia workstation.'],
            ['order_type' => 2, 'request_type' => 2, 'address' => 'Al Nour Clinic - Procurement, Riyadh', 'notes' => 'Scheduled monthly consumables delivery.', 'schedule_start' => now()->addDays(12), 'frequency' => 'Every 2 Weeks', 'duration' => 'Oct 15 - Jan 15, 2026'],
            ['order_type' => 2, 'request_type' => 2, 'address' => 'City Care Clinic - Procurement, Riyadh', 'notes' => 'Scheduled lab supplies.', 'schedule_start' => now()->subDays(5), 'frequency' => 'Monthly', 'duration' => 'Sep 1 - Dec 1, 2026'],
            ['order_type' => 2, 'request_type' => 2, 'address' => 'King Fahad Hospital - Main Store, Riyadh', 'notes' => 'Quarterly scheduled medical gloves.', 'schedule_start' => now()->subDays(15), 'frequency' => 'Quarterly', 'duration' => 'Jul 1 - Jul 1, 2027'],
            ['order_type' => 2, 'request_type' => 2, 'address' => 'Prince Sultan Hospital - Main Store, Dammam', 'notes' => 'Scheduled syringes delivery.', 'schedule_start' => now()->subDays(3), 'frequency' => 'Every 2 Weeks', 'duration' => 'Oct 1 - Feb 1, 2026'],
            ['order_type' => 1, 'request_type' => 1, 'address' => 'National Medical Center - Receiving, Jeddah', 'notes' => 'Purchase order for infusion pumps.'],
            ['order_type' => 2, 'request_type' => 1, 'address' => 'Al Nour Clinic - Manager Office, Riyadh', 'notes' => 'Quotation request for ECG monitors.'],
        ];

        foreach ($definitions as $i => $def) {
            $itemsCost = [8500, 19000, 12000, 15000, 9800, 7600, 13200, 5400, 11200][$i];
            $vatAmount = round($itemsCost * 0.1, 2);
            $deliveryFee = [250, 300, 220, 200, 180, 220, 240, 170, 210][$i];

            $createdAt = now()->subDays($daysAgo[$i]);
            $updatedAt = $createdAt->copy()->addHours(rand(2, 18));

            $orders[] = Order::create([
                'user_id' => $customers[$i % count($customers)]->id,
                'provider_id' => $vendorId,
                'order_type' => $def['order_type'],
                'request_type' => $def['request_type'],
                'frequency' => $def['frequency'] ?? null,
                'delivery_duration' => $def['duration'] ?? null,
                'schedule_start_date' => $def['schedule_start'] ?? null,
                'payment_type' => $i % 2 === 0 ? 'Apple Pay' : 'Cash on Delivery',
                'payment_status' => $i % 3 === 0 ? 1 : 0,
                'vat' => 10,
                'vat_amount' => $vatAmount,
                'delivery_fee' => $deliveryFee,
                'discount' => $i % 4 === 0 ? 250 : 0,
                'items_cost' => $itemsCost,
                'total_before_discount' => $itemsCost + $vatAmount + $deliveryFee,
                'total_cost' => $itemsCost + $vatAmount + $deliveryFee - ($i % 4 === 0 ? 250 : 0),
                'address' => $def['address'],
                'notes' => $def['notes'],
                'date_time_picker' => now()->subDays($daysAgo[$i])->addDay(),
                'preferred_service_time' => $def['order_type'] === 3 ? now()->addDays(2) : null,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);
        }

        // Keep one scheduled order "paused" by making updated_at older than 7 days with pending offer.
        Order::where('id', $orders[5]->id)->update([
            'updated_at' => now()->subDays(14),
            'created_at' => now()->subDays(40),
        ]);

        return $orders;
    }

    private function seedOrderItems(array $orders, array $products): void
    {
        foreach ($orders as $i => $order) {
            if ((int) $order->order_type === 3) {
                continue;
            }

            $first = $products[$i % count($products)];
            $second = $products[($i + 2) % count($products)];

            $q1 = max(1, min(rand(1, 4), (int) floor(9999.99 / max(0.01, (float) $first->price))));
            $q2 = max(1, min(rand(1, 3), (int) floor(9999.99 / max(0.01, (float) $second->price))));

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $first->id,
                'quantity' => $q1,
                'item_price' => $first->price,
                'total_price' => $first->price * $q1,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $second->id,
                'quantity' => $q2,
                'item_price' => $second->price,
                'total_price' => $second->price * $q2,
            ]);
        }
    }

    private function seedOrderTimelines(array $orders, int $vendorId): void
    {
        foreach ($orders as $order) {
            OrderTimeline::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'timeline_no' => 1,
                'action_at' => $order->created_at,
            ]);

            if ((int) $order->order_type !== 2) {
                OrderTimeline::create([
                    'user_id' => $vendorId,
                    'order_id' => $order->id,
                    'timeline_no' => 2,
                    'action_at' => $order->created_at->copy()->addHours(6),
                ]);
            }
        }
    }

    private function seedOffers(int $vendorId, array $orders): void
    {
        // pending, accepted, rejected mix for dashboard and order states
        $offerMap = [
            ['order' => $orders[1], 'status' => 1, 'cost' => 18250, 'time' => '7 days', 'warranty' => '2 years', 'notes' => 'Includes installation and training.'],
            ['order' => $orders[3], 'status' => 1, 'cost' => 14200, 'time' => '10 days', 'warranty' => '1 year', 'notes' => 'Scheduled recurring quotation.'],
            ['order' => $orders[4], 'status' => 2, 'cost' => 9300, 'time' => '5 days', 'warranty' => '1 year', 'notes' => 'Accepted by client.'],
            ['order' => $orders[5], 'status' => 1, 'cost' => 7200, 'time' => '14 days', 'warranty' => '6 months', 'notes' => 'Waiting final approval.'],
            ['order' => $orders[6], 'status' => 3, 'cost' => 12800, 'time' => '9 days', 'warranty' => '1 year', 'notes' => 'Client requested lower price.', 'reason' => 'Price higher than budget'],
            ['order' => $orders[8], 'status' => 2, 'cost' => 10900, 'time' => '6 days', 'warranty' => '2 years', 'notes' => 'Best value option selected.'],
        ];

        foreach ($offerMap as $idx => $data) {
            Offer::create([
                'order_id' => $data['order']->id,
                'provider_id' => $vendorId,
                'cost' => $data['cost'],
                'delivery_fee' => 0,
                'delivery_time' => $data['time'],
                'warranty' => $data['warranty'],
                'files' => 'admin/assets/offers/vendor50-offer-' . ($idx + 1) . '.pdf',
                'status' => $data['status'],
                'notes' => $data['notes'],
                'rejected_reson' => $data['reason'] ?? null,
                'created_at' => $data['order']->created_at->copy()->addHours(8),
                'updated_at' => $data['order']->updated_at,
            ]);
        }
    }

    private function seedRatings(int $vendorId, array $customers, array $products): void
    {
        $vendorRatings = [
            ['rating' => 5, 'comment' => 'Excellent response time and professional support.', 'days_ago' => 3],
            ['rating' => 4, 'comment' => 'Delivery was fast and packaging was secure.', 'days_ago' => 7],
            ['rating' => 5, 'comment' => 'High quality products and smooth coordination.', 'days_ago' => 11],
            ['rating' => 4, 'comment' => 'Good communication and clear quotations.', 'days_ago' => 16],
            ['rating' => 5, 'comment' => 'Reliable supplier for recurring scheduled orders.', 'days_ago' => 21],
        ];

        foreach ($vendorRatings as $i => $item) {
            Rating::create([
                'user_id' => $customers[$i % count($customers)]->id,
                'forable_id' => $vendorId,
                'forable_type' => User::class,
                'rating' => $item['rating'],
                'comment' => $item['comment'],
                'is_activate' => 1,
                'created_at' => now()->subDays($item['days_ago']),
                'updated_at' => now()->subDays($item['days_ago']),
            ]);
        }

        // A few product ratings to look realistic in other pages.
        foreach (array_slice($products, 0, 4) as $i => $product) {
            Rating::create([
                'user_id' => $customers[$i % count($customers)]->id,
                'forable_id' => $product->id,
                'forable_type' => Product::class,
                'rating' => [5, 4, 5, 4][$i],
                'comment' => [
                    'Device quality is excellent for our radiology team.',
                    'Good performance, easy setup.',
                    'Very reliable in daily operation.',
                    'Good value for the price.',
                ][$i],
                'is_activate' => 1,
                'created_at' => now()->subDays($i + 4),
                'updated_at' => now()->subDays($i + 4),
            ]);
        }
    }

    private function seedNotifications(int $vendorId, array $orders): void
    {
        $rows = [
            ['type' => 'order', 'title' => 'New Purchase Order', 'msg' => 'New purchase order received from King Fahad Hospital.', 'order' => $orders[0], 'read' => null, 'hours' => 2],
            ['type' => 'offer', 'title' => 'Offer Accepted', 'msg' => 'Your quotation offer was accepted by National Medical Center.', 'order' => $orders[8], 'read' => now()->subHours(3), 'hours' => 4],
            ['type' => 'scheduled', 'title' => 'Scheduled Delivery Upcoming', 'msg' => 'Upcoming scheduled delivery in 2 days. Prepare shipment.', 'order' => $orders[3], 'read' => null, 'hours' => 7],
            ['type' => 'rating', 'title' => 'New Rating Received', 'msg' => 'You received a new 5-star rating on your service.', 'order' => $orders[4], 'read' => null, 'hours' => 12],
            ['type' => 'system', 'title' => 'Platform Maintenance', 'msg' => 'Scheduled maintenance will occur Sunday 2:00 AM - 3:00 AM.', 'order' => null, 'read' => now()->subDay(), 'hours' => 30],
            ['type' => 'offer', 'title' => 'Offer Requires Update', 'msg' => 'Client asked to resubmit with revised pricing.', 'order' => $orders[6], 'read' => null, 'hours' => 18],
            ['type' => 'scheduled', 'title' => 'Scheduled Order Paused', 'msg' => 'One recurring order has been paused by the client.', 'order' => $orders[5], 'read' => now()->subHours(20), 'hours' => 25],
            ['type' => 'order', 'title' => 'Maintenance Request Assigned', 'msg' => 'A maintenance request is now assigned to your team.', 'order' => $orders[2], 'read' => null, 'hours' => 1],
        ];

        foreach ($rows as $row) {
            Notification::create([
                'user_id' => $vendorId,
                'order_id' => $row['order']?->id,
                'title' => $row['title'],
                'content' => $row['msg'],
                'message' => $row['msg'],
                'type' => $row['type'],
                'action_url' => $row['order'] ? '/vendor/orders/' . $row['order']->id : null,
                'meta' => $row['order'] ? ['order_id' => $row['order']->id] : ['type' => 'system'],
                'read_at' => $row['read'],
                'created_at' => now()->subHours($row['hours']),
                'updated_at' => now()->subHours($row['hours']),
            ]);
        }
    }
}
