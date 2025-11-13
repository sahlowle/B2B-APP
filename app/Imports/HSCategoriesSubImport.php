<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class HSCategoriesSubImport implements ToModel, WithChunkReading,WithBatchInserts,WithProgressBar,WithStartRow
{
    use Importable,RemembersRowNumber;
    
    public function model(array $row)
    {

        $hsCode = $this->filter($row[0]);
        $enName = $row[1];

        if (Str::length($hsCode) <= 2) {
            return null;
        }

        $parentHsCode = Str::substr($hsCode, 0, 2);

        $parentCategory = Category::where('hs_code', $parentHsCode)->first();

        if (is_null($parentCategory)) {
            return null;
        }
        
        return new Category([
            'name' => [
                        'en' => $hsCode . ' - ' . $enName,
            ],
            'slug' => [
                'en' => Str::slug($hsCode . ' - ' . $enName),
            ],
            'parent_id' => $parentCategory->id,
            'order_by' =>   $this->getRowNumber() + 1,
            'is_searchable' => true,
            'is_featured' => false,
            'product_counts' => 0,
            'sell_commissions' => null,
            'status' => 'Active',
            'is_global' => true,
        ]);
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function filter($value)
    {
        $value = Str::remove('[', $value);
        $value = Str::remove(']', $value);
        return $value;
    }
}
