<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('type', 50)->nullable()->after('content')->comment('order, offer, scheduled, rating, system');
            $table->text('message')->nullable()->after('content');
            $table->string('action_url', 500)->nullable()->after('type');
            $table->json('meta')->nullable()->after('action_url')->comment('order_id, offer_id, etc');
            $table->timestamp('read_at')->nullable()->after('meta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['type', 'message', 'action_url', 'meta', 'read_at']);
        });
    }
};
