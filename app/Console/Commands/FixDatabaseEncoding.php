<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDatabaseEncoding extends Command
{
    protected $signature = 'db:fix-encoding {--dry-run : Show SQL without executing it}';

    protected $description = 'Convert MySQL database and tables to utf8mb4/utf8mb4_unicode_ci';

    public function handle(): int
    {
        $database = (string) config('database.connections.mysql.database');

        if ($database === '') {
            $this->error('Database name is empty. Set DB_DATABASE first.');
            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $statements = [];

        $statements[] = "ALTER DATABASE `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

        $tables = DB::select(
            'SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? ORDER BY TABLE_NAME',
            [$database]
        );

        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            $statements[] = "ALTER TABLE `{$name}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        }

        if ($dryRun) {
            foreach ($statements as $sql) {
                $this->line($sql . ';');
            }
            $this->info('Dry run complete.');
            return self::SUCCESS;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            foreach ($statements as $sql) {
                DB::statement($sql);
                $this->info("OK: {$sql}");
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->info('Database encoding normalization completed.');

        return self::SUCCESS;
    }
}

