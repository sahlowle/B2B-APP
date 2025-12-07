<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteTrashedProducts extends Command
{
    protected $signature = 'products:clean-trashed';
    protected $description = 'Permanently delete all soft-deleted products';

    public function handle()
    {
        $count = Product::onlyTrashed()->count();

        if ($count == 0) {
            $this->info('No trashed products found.');
            return Command::SUCCESS;
        }

        Product::onlyTrashed()->chunkById(100, function ($products) {
            foreach ($products as $product) {
                DB::transaction(function () use ($product) {
                    $product->metadata()->forceDelete();
                    $product->relatedProducts()->forceDelete();
                    $product->productTag()->forceDelete();
                    $product->productCategory()->forceDelete();
                    $product->category()->detach();
                    $product->productTag()->forceDelete();
                    $product->tags()->detach();
                    $product->taxMeta()?->forceDelete();
                    $product->orderDetails()->forceDelete();
                    $product->wishlist()->forceDelete();
                    $product->review()->forceDelete();
                    $product->shop()->forceDelete();
                    $product->deleteFiles();
                    $product->forceDelete();
                });
            }
        });

        $this->info("Successfully permanently deleted {$count} trashed products.");

        return Command::SUCCESS;
    }
}
