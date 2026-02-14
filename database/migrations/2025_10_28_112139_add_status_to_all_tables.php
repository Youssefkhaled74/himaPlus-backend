<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private string $column = 'report_id';
    public function up(): void
    {
        $tables = collect(DB::select("
            SELECT TABLE_NAME
            FROM information_schema.tables
            WHERE TABLE_SCHEMA = DATABASE()
        "))->pluck('TABLE_NAME');
        foreach ($tables as $table) {
            if (Schema::hasColumn($table, $this->column)) continue;
            Schema::table($table, function (Blueprint $t) {
                $t->tinyInteger($this->column)->default(1);
            });
        }
    }
    public function down(): void
    {
        $tables = collect(DB::select("
            SELECT TABLE_NAME
            FROM information_schema.tables
            WHERE TABLE_SCHEMA = DATABASE()
        "))->pluck('TABLE_NAME');
        foreach ($tables as $table) {
            if (Schema::hasColumn($table, $this->column)) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn($this->column);
                });
            }
        }
    }
};
