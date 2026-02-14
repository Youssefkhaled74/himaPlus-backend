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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('files', 1255)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->string('delivery_time', 255)->nullable();
            $table->string('warranty', 255)->nullable();
            $table->integer('provider_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1 => pending, 2 => accepted, 3 => rejected');
            $table->string('notes', 1255)->nullable();
            $table->string('rejected_reson', 1255)->nullable();
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
        Schema::dropIfExists('offers');
    }
};
