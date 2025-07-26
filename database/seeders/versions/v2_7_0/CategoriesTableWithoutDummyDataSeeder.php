<?php

namespace Database\Seeders\versions\v2_7_0;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableWithoutDummyDataSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $this->updateColumn(
            'Uncategorized',
            '{ "en": "Uncategorized", "bn": "শ্রেণীবদ্ধ নয়", "fr": "Non catégorisé", "zh": "未分类", "ar": "غير مصنف", "be": "Некатэгарызаваны", "bg": "Некатегоризирано", "ca": "Sense categoria", "et": "Kategooriata", "nl": "Niet gecategoriseerd" }',
            '{ "en": "uncategorized", "bn": "শ্রেণীবদ্ধ-নয়", "fr": "non-catégorisé", "zh": "未分类", "ar": "غير-مصنف", "be": "некатэгарызаваны", "bg": "некатегоризирано", "ca": "sense-categoria", "et": "kategooriata", "nl": "niet-gecategoriseerd" }',
        );

        $this->updateColumn(
            'Category 1',
            '{ "en": "Category 1", "bn": "বিভাগ ১", "fr": "Catégorie 1", "zh": "类别 1", "ar": "الفئة 1", "be": "Катэгорыя 1", "bg": "Категория 1", "ca": "Categoria 1", "et": "Kategooria 1", "nl": "Categorie 1" }',
            '{ "en": "category-1", "bn": "বিভাগ-১", "fr": "catégorie-1", "zh": "类别-1", "ar": "الفئة-1", "be": "катэгорыя-1", "bg": "категория-1", "ca": "categoria-1", "et": "kategooria-1", "nl": "categorie-1" }',
        );

        $this->updateColumn(
            'Category 2',
            '{ "en": "Category 2", "bn": "বিভাগ ২", "fr": "Catégorie 2", "zh": "类别 2", "ar": "الفئة 2", "be": "Катэгорыя 2", "bg": "Категория 2", "ca": "Categoria 2", "et": "Kategooria 2", "nl": "Categorie 2" }',
            '{ "en": "category-2", "bn": "বিভাগ-২", "fr": "catégorie-2", "zh": "类别-2", "ar": "الفئة-2", "be": "катэгорыя-2", "bg": "категория-2", "ca": "categoria-2", "et": "kategooria-2", "nl": "categorie-2" }',
        );
    }

    /**
     * update ctagory colum
     *
     * @return void
     */
    protected function updateColumn($name, $translateName, $translateSlug)
    {
        Category::where('name', $name)->update(['name' => $translateName, 'slug' => $translateSlug]);
    }
}
