<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class ImportSql extends Command
{
    
    protected $signature = 'db:import';
    protected $description = 'Import SQL file';

  
    
    public function handle()
    {
          // Drop all existing tables
        $this->info('Dropping all existing tables...');
        Schema::disableForeignKeyConstraints();

        $tables = Schema::getTables();
          
        Schema::dropAllTables();

        dd(count($tables));

          
        $this->info('All tables dropped successfully.');
        
        $sql = file_get_contents(database_path('schema/db.sql'));
        DB::unprepared($sql);
        
        $this->info('SQL importing completed!');
        return 0;
    }
}
