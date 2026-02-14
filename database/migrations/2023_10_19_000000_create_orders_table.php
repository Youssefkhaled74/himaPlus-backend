<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('device_category_id')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('offer_id')->nullable();
            $table->tinyInteger('order_type')->nullable()->comment('1 => order, 2 => quotation, 3 => maintenace');
            $table->tinyInteger('request_type')->nullable()->comment('1 => Immediate Request, 2 => Scheduled Request');
            $table->string('frequency', 255)->nullable();
            $table->string('delivery_duration', 255)->nullable();
            $table->dateTime('schedule_start_date')->nullable();
            $table->string('payment_type', 255)->nullable();
            $table->tinyInteger('payment_status')->default(0)->comment('0 => unpaid, 1 => paid');
            $table->integer('vat')->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('items_cost', 10, 2)->default(0);
            $table->decimal('total_before_discount', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->string('address', 1255)->nullable();
            $table->string('files', 1255)->nullable();
            $table->string('notes', 1255)->nullable();
            $table->string('device_name', 1255)->nullable();
            $table->string('budget', 255)->nullable();
            $table->string('quotation_type', 255)->nullable();
            $table->string('serial_number', 255)->nullable();
            $table->string('issue_description', 255)->nullable();
            $table->dateTime('date_time_picker')->nullable();
            $table->dateTime('preferred_service_time')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
