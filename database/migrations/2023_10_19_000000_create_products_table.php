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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->nullable();
            $table->integer('category_id')->nullable();
            $table->string('desc', 1255)->nullable();
            $table->decimal('price', 6, 2)->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->string('img', 255)->nullable();
            $table->string('imgs', 1255)->nullable();
            $table->string('imaging_type', 255)->nullable();
            $table->string('power', 255)->nullable();
            $table->date('manufacture_date')->nullable();
            $table->date('production_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('dimensions', 255)->nullable();
            $table->string('warranty', 255)->nullable();
            $table->integer('origin_id')->nullable();
            $table->integer('provider_id')->nullable();
            $table->tinyInteger('is_offer')->default(0);
            $table->tinyInteger('is_special')->default(0);
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
        Schema::dropIfExists('products');
    }
};
