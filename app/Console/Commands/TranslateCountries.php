<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\GeoLocale\Entities\Country;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate-countries';

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
        // $this->info('Translating countries...');

        // Schema::table('geolocale_countries', function (Blueprint $table) {
        //     $table->json('translated_name')->after('name')->nullable();
        // });

        // // 2. Update all records
        // $languages = ['en','ar','fr','bg','bn','ca','et','ja','nl','zh'];

        // $countries = Country::all();

        // $this->withProgressBar($countries, function ($country) use ($languages) {
        //     $translations = [];
        //     foreach ($languages as $lang) {
        //         if($lang == 'ar'){
        //             $translations[$lang] = GoogleTranslate::trans($country->name, $lang);
        //         }else{
        //             $translations[$lang] = $country->name;
        //         }
        //     }
        //     $country->translated_name = $translations;
        //     $country->save();
        // });
        

        $this->info(Country::first());
    }
}
