<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\App;

use App;
use Config;
class CheckWebsiteLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 
    
    
    public function handle(Request $request, Closure $next)
    {
        // Check if a language is already set in session or cookie
        if (!Session::has('website_locale') && !isset($_COOKIE['website_lang_code'])) {
            // Get default language code
            $defaultCode = Language::where('is_default', '1')->value('code');

            if ($defaultCode) {
                App::setLocale($defaultCode);
                Session::put('website_locale', $defaultCode);
                setcookie('website_lang_code', $defaultCode, time() + (60 * 60 * 24 * 365), "/");
            }
        } else {
            // If language is already set, apply it
            $lang = Session::get('website_locale', $_COOKIE['website_lang_code'] ?? Config::get('app.locale'));
            App::setLocale($lang);
        }

        return $next($request);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}