<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('registration_type', 20)->nullable()->after('power');
            $table->string('guarantee_file', 255)->nullable()->after('registration_type');
            $table->string('registration_number', 100)->nullable()->after('guarantee_file');
            $table->date('registration_expiry_date')->nullable()->after('registration_number');
            $table->string('factory_name', 100)->nullable()->after('registration_expiry_date');
            $table->string('factory_country', 100)->nullable()->after('factory_name');
            $table->string('uom', 100)->nullable()->after('factory_country');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'registration_type',
                'guarantee_file',
                'registration_number',
                'registration_expiry_date',
                'factory_name',
                'factory_country',
                'uom',
            ]);
        });
    }
};
