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
        Schema::create('order_timeline', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('timeline_no')->nullable()->comment('
                1 => Order Created, 2 => Confirmed by Supplier, 3 => Processing, 4 => Shipped, 
                5 => Delivered, 6 => Completed, 7 => Offers Received, 8 => Supplier Selected, 
                9 => Converted to Order, 10 => Under Review, 11 => Assigned to Supplier
            ');
            $table->dateTime('action_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->tinyInteger('is_activate')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_timeline');
    }
};
