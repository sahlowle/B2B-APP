<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

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

        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Truncate the table
        Category::truncate();

        Category::create([
            'id' => 1,
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'parent_id' => null,
            'order_by' => 1,
            'is_searchable' => 1,
            'is_featured' => 0,
        ]);

        foreach ($data as $index => $item) {
            $enName = trim($item['en_name']);
            $arName = trim($item['ar_name']);
            $hsCode = $item['hs_code'];

            // dd($enName, $arName, $hsCode);

            Category::updateOrCreate(
                ['hs_code' => $hsCode],
                [
                    'name' => [
                        'en' => $hsCode . ' - ' . $enName,
                        'ar' => $hsCode . ' - ' . $arName,
                        // 'be' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'be'),
                        // 'bg' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'bg'),
                        // 'bn' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'bn'),
                        // 'ca' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'ca'),
                        // 'et' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'et'),
                        // 'fr' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'fr'),
                        // 'ja' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'ja'),    
                        // 'nl' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'nl'),
                        // 'zh' => $hsCode . ' - ' . GoogleTranslate::trans($enName, 'zh'),
                    ],
                    'slug' => [
                        'en' => Str::slug($hsCode . ' - ' . $enName),
                        'ar' => Str::slug($hsCode . ' - ' . $arName),
                    ],
                    'parent_id' => null,
                    'order_by' => $index + 2,
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
