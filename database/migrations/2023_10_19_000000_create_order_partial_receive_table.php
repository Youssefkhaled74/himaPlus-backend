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
        Schema::create('order_partial_receive', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('offer_id')->nullable();
            $table->string('files', 1255)->nullable();
            $table->integer('received_quantity')->nullable();
            $table->tinyInteger('received_all_quantity')->default(0);
            $table->string('reason_for_partial', 1255)->nullable();
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
        Schema::dropIfExists('order_partial_receive');
    }
};
