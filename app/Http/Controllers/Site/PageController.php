<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Language;

class PageController extends Controller
{

    public function aboutUs()
    {
       $languages = Language::where('status', 'Active')->get();

       $availableLanguages = $languages->pluck('short_name')->toArray();

       $lang = app()->getLocale();

       if(!in_array($lang, $availableLanguages)) {
        $lang = 'en';
       }

       $view = 'site.page.about-us.' . $lang;

       if(!view()->exists($view)) {
         $view = 'site.page.about-us.en';
       }

       $currentLang = $languages->where('short_name', $lang)->first();

       $homeService = $homeService = new \Modules\CMS\Service\HomepageService();
       $page = $homeService->home();

       return view($view,compact('languages', 'currentLang', 'page'));

    }

    public function privacyPolicy()
    {
       $languages = Language::where('status', 'Active')->get();

       $availableLanguages = $languages->pluck('short_name')->toArray();

       $lang = app()->getLocale();

       if(!in_array($lang, $availableLanguages)) {
        $lang = 'en';
       }

       $view = 'site.page.privacy-policy.' . $lang;

       if(!view()->exists($view)) {
        $view = 'site.page.privacy-policy.en';
       }

       $currentLang = $languages->where('short_name', $lang)->first();

       $homeService = $homeService = new \Modules\CMS\Service\HomepageService();
       $page = $homeService->home();

       return view($view,compact('languages', 'currentLang', 'page'));
    }

    public function termsAndConditionsOfSeller()
    {

       $availableLanguages = ['en', 'ar'];

       $lang = app()->getLocale();

       if(!in_array($lang, $availableLanguages)) {
        $lang = 'en';
       }

       $view = 'site.page.terms-and-conditions-of-seller.' . $lang;

       if(!view()->exists($view)) {
        $view = 'site.page.terms-and-conditions-of-seller.en';
       }

       $currentLang = $lang;

       return view($view,compact('currentLang'));
    }

    public function termsAndConditionsOfBuyer()
    {

       $availableLanguages = ['en', 'ar'];

       $lang = app()->getLocale();

       if(!in_array($lang, $availableLanguages)) {
        $lang = 'en';
       }

       $view = 'site.page.terms-and-conditions-of-buyer.' . $lang;

       if(!view()->exists($view)) {
        $view = 'site.page.terms-and-conditions-of-buyer.en';
       }

       $currentLang = $lang;

       return view($view,compact('currentLang'));
    }
}
