<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `order_items` MODIFY `item_price` DECIMAL(12,2) NULL');
        DB::statement('ALTER TABLE `order_items` MODIFY `total_price` DECIMAL(12,2) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `order_items` MODIFY `item_price` DECIMAL(6,2) NULL');
        DB::statement('ALTER TABLE `order_items` MODIFY `total_price` DECIMAL(6,2) NULL');
    }
};

