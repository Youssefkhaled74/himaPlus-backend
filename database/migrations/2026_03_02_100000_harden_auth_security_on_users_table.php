<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('verification_code_hash')->nullable()->after('code');
            $table->timestamp('verification_code_expires_at')->nullable()->after('verification_code_hash');
            $table->string('verification_code_target')->nullable()->after('verification_code_expires_at');
            $table->string('verification_code_channel', 20)->nullable()->after('verification_code_target');

            $table->string('reset_code_hash')->nullable()->after('verification_code_channel');
            $table->timestamp('reset_code_expires_at')->nullable()->after('reset_code_hash');
            $table->string('reset_code_target')->nullable()->after('reset_code_expires_at');
            $table->string('reset_code_channel', 20)->nullable()->after('reset_code_target');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'verification_code_hash',
                'verification_code_expires_at',
                'verification_code_target',
                'verification_code_channel',
                'reset_code_hash',
                'reset_code_expires_at',
                'reset_code_target',
                'reset_code_channel',
            ]);
        });
    }
};
