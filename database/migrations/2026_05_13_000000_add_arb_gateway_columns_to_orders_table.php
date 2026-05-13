<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'gateway_name')) {
                $table->string('gateway_name')->nullable()->after('payment_type');
            }

            if (!Schema::hasColumn('orders', 'gateway_payment_id')) {
                $table->string('gateway_payment_id')->nullable()->after('gateway_name');
            }

            if (!Schema::hasColumn('orders', 'gateway_track_id')) {
                $table->string('gateway_track_id')->nullable()->unique()->after('gateway_payment_id');
            }

            if (!Schema::hasColumn('orders', 'gateway_response')) {
                $table->json('gateway_response')->nullable()->after('gateway_track_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'gateway_response')) {
                $table->dropColumn('gateway_response');
            }

            if (Schema::hasColumn('orders', 'gateway_track_id')) {
                $table->dropUnique('orders_gateway_track_id_unique');
                $table->dropColumn('gateway_track_id');
            }

            if (Schema::hasColumn('orders', 'gateway_payment_id')) {
                $table->dropColumn('gateway_payment_id');
            }

            if (Schema::hasColumn('orders', 'gateway_name')) {
                $table->dropColumn('gateway_name');
            }
        });
    }
};
