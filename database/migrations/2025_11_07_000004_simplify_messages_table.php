<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Add new file column
            $table->string('file')->nullable()->after('message');

            // Drop old columns
            $table->dropColumn(['file_path', 'file_name', 'file_size', 'mime_type']);
        });

        // Update message_type enum to only have 'text' and 'file'
        DB::statement("ALTER TABLE messages MODIFY COLUMN message_type ENUM('text', 'file') DEFAULT 'text'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Add back old columns
            $table->string('file_path')->nullable()->after('message_type');
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('file_size')->nullable()->after('file_name');
            $table->string('mime_type')->nullable()->after('file_size');

            // Drop new file column
            $table->dropColumn('file');
        });

        // Revert message_type enum
        DB::statement("ALTER TABLE messages MODIFY COLUMN message_type ENUM('text', 'file', 'image', 'video', 'audio', 'document') DEFAULT 'text'");
    }
};