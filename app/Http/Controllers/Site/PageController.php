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

       $seo = [
        'title' => trans('About Us'),
        'meta_title' => trans('About Us'),
        'meta_description' => trans('About Us'),
        'image' => asset('public/frontend/img/logo.png'),
       ];

       return view($view,compact('languages', 'currentLang', 'page', 'seo'));

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

       $seo = [
        'title' => trans('Privacy Policy'),
        'meta_title' => trans('Privacy Policy'),
        'meta_description' => trans('Privacy Policy'),
        'image' => asset('public/frontend/img/logo.png'),
       ];

       return view($view,compact('languages', 'currentLang', 'page', 'seo'));
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

       $seo = [
        'title' => trans('Terms and Conditions of Seller'),
        'meta_title' => trans('Terms and Conditions of Seller'),
        'meta_description' => trans('Terms and Conditions of Seller'),
        'image' => asset('public/frontend/img/logo.png'),
       ];

       return view($view,compact('currentLang', 'seo'));
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

       $seo = [
        'title' => trans('Contact Us'),
        'meta_title' => trans('Contact Us'),
        'meta_description' => trans('Contact Us'),
        'image' => asset('public/frontend/img/logo.png'),
       ];

       return view($view,compact('currentLang', 'seo'));
    }

    public function contactUs()
    {
       $languages = Language::where('status', 'Active')->get();

       $availableLanguages = $languages->pluck('short_name')->toArray();

       $lang = app()->getLocale();

       if(!in_array($lang, $availableLanguages)) {
        $lang = 'en';
       }

       $view = 'site.page.contact-us.' . $lang;

       if(!view()->exists($view)) {
         $view = 'site.page.contact-us.en';
       }

       $currentLang = $languages->where('short_name', $lang)->first();

       $homeService = $homeService = new \Modules\CMS\Service\HomepageService();
       $page = $homeService->home();

       
       $seo = [
        'title' => trans('Contact Us'),
        'meta_title' => trans('Contact Us'),
        'meta_description' => trans('Contact Us'),
        'image' => asset('public/frontend/img/logo.png'),
       ];

       return view($view,compact('languages', 'currentLang', 'page', 'seo'));
    }
}
