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
        'main_title' => trans('About Us'),
        'title' => trans('Exports Valley') . ' ' . trans('Saudi Exports Services'),
        'meta_title' => trans('Exports Valley') . ' ' . trans('Saudi Exports Services'),
        'meta_description' => trans('Exports Valley is a Saudi company specialized in export services and support for exporters, including consultations, market research, logistics, and international shipping for the success of products outside the Kingdom of Saudi Arabia.'),
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
        'main_title' => trans('Privacy Policy'),
        'title' => trans('Exports Valley') . ' ' . trans('Saudi Exports Program'),
        'meta_title' => trans('Exports Valley') . ' ' . trans('Saudi Exports Program'),
        'meta_description' => trans("Learn about Exports Valley's privacy policy and how we protect company and exporter data within the Saudi Export Program according to the highest standards of security and transparency."),
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
        'main_title' => trans('Terms and Conditions of Seller'),
        'title' => trans('Exports Valley') . ' ' . trans('Saudi Exports'),
        'meta_title' => trans('Exports Valley') . ' ' . trans('Saudi Exports'),
        'meta_description' => trans("The terms and conditions for sellers at Exports Valley clarify the rights and obligations of sellers, the sales mechanism, policies, and guarantees of compliance with Saudi export regulations and standards."),
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
        'main_title' => trans('Terms and Conditions of Buyer'),
        'title' => trans('Exports Valley') . ' ' . trans('Saudi Exports'),
        'meta_title' => trans('Exports Valley') . ' ' . trans('Saudi Exports'),
        'meta_description' => trans("Learn about Exports Valley's buyer terms and conditions, purchasing rights and responsibilities, and payment, shipping, and return policies in accordance with Saudi export regulations."),
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
