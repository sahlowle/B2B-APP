<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Str;

class ImportHSCategories extends Command
{
    protected $signature = 'import:hs-categories';
    protected $description = 'Import HS code categories from JSON file into categories table';

    public function handle()
    {
        $path = storage_path('app/hs_categories.json');

        if (!file_exists($path)) {
            $this->error("JSON file not found: {$path}");
            return 1;
        }

        $data = json_decode(file_get_contents($path), true);

        if (!$data) {
            $this->error("Invalid JSON format.");
            return 1;
        }

        foreach ($data as $index => $item) {
            $enName = trim($item['en_name']);
            $arName = trim($item['ar_name']);
            $hsCode = $item['hs_code'];

            // dd($enName, $arName, $hsCode);

            Category::updateOrCreate(
                ['hs_code' => $hsCode],
                [
                    'name' => [
                        'en' => $enName,
                        'ar' => $arName,
                    ],
                    'slug' => [
                        'en' => Str::slug($enName),
                        'ar' => Str::slug($arName, '-'),
                    ],
                    'parent_id' => null,
                    'order_by' => $index + 1,
                    'is_searchable' => true,
                    'is_featured' => false,
                    'product_counts' => 0,
                    'sell_commissions' => null,
                    'status' => 'Active',
                    'is_global' => true,
                ]
            );
        }

        $this->info(count($data) . ' HS categories imported successfully ✅');
        return 0;
    }
}
