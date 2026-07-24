<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name_en' => 'Regular Shipping',
                'name_ar' => 'الشحن العادي',
                'description_en' => 'Standard delivery within 3-5 business days',
                'description_ar' => 'توصيل عادي خلال ٣-٥ أيام عمل',
                'base_price' => 15.00,
                'price_per_kg' => 2.00,
                'icon' => 'truck',
                'is_active' => 1,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Refrigerated Shipping (Cold Chain)',
                'name_ar' => 'الشحن المبرد (السلسلة الباردة)',
                'description_en' => 'Temperature-controlled delivery for perishable goods',
                'description_ar' => 'توصيل بتحكم في الحرارة للمنتجات القابلة للتلف',
                'base_price' => 35.00,
                'price_per_kg' => 5.00,
                'icon' => 'snowflake',
                'is_active' => 1,
                'sort_order' => 2,
            ],
            [
                'name_en' => 'Fragile Items Shipping',
                'name_ar' => 'شحن المنتجات الهشة',
                'description_en' => 'Extra protective packaging for breakable items',
                'description_ar' => 'تغليف حماية إضافي للمنتجات القابلة للكسر',
                'base_price' => 25.00,
                'price_per_kg' => 3.50,
                'icon' => 'shield',
                'is_active' => 1,
                'sort_order' => 3,
            ],
            [
                'name_en' => 'Express Shipping',
                'name_ar' => 'الشحن السريع',
                'description_en' => 'Priority delivery within 1-2 business days',
                'description_ar' => 'توصيل سريع خلال ١-٢ أيام عمل',
                'base_price' => 40.00,
                'price_per_kg' => 6.00,
                'icon' => 'zap',
                'is_active' => 1,
                'sort_order' => 4,
            ],
        ];

        foreach ($methods as $method) {
            ShippingMethod::updateOrCreate(
                ['name_en' => $method['name_en']],
                $method
            );
        }
    }
}
