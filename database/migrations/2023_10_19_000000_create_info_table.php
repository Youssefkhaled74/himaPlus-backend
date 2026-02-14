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
        Schema::create('info', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('mobile', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('vat', 255)->nullable();
            $table->text('desc', 20000)->nullable();
            $table->text('message', 20000)->nullable();
            $table->text('vision', 20000)->nullable();
            $table->text('asks', 20000)->nullable();
            $table->text('abouts', 20000)->nullable();
            $table->text('terms', 20000)->nullable();
            $table->text('privacy_policies', 20000)->nullable();
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
        Schema::dropIfExists('info');
    }
};
