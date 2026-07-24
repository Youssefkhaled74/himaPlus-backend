<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->string('tracking_number')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=pending, 2=shipped, 3=in_transit, 4=delivered, 5=returned');
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
