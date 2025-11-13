<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\HSCategoriesSubImport;

class ImportHSCategoriesSubCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:hs-categories-sub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output->title('Starting import');
        (new HSCategoriesSubImport)->withOutput($this->output)->import(storage_path('app/HS_Codes_Complete_Database.xlsx'));
        $this->output->success('Import successful');
    }
}
