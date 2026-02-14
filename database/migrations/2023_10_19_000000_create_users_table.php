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
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile', 255)->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('iban', 255)->nullable();
            $table->string('branch', 255)->nullable();
            $table->string('tax_number', 255)->nullable();
            $table->string('cr_number', 255)->nullable();
            $table->string('cr_document', 255)->nullable();
            $table->string('location', 1255)->nullable();
            $table->string('img', 1255)->nullable();
            $table->string('fcm_token', 1255)->nullable();
            $table->string('code', 25)->nullable();
            $table->string('lang', 25)->nullable();
            $table->tinyInteger('user_type')->comment("1 => clients, 2 => providers, 3 => logistics")->nullable();
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
        Schema::dropIfExists('users');
    }
};
