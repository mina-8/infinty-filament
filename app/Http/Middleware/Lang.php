<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLanguages = ['en', 'ar'];
        // Check for 'lang' query parameter first
        $queryLang = $request->query('lang');
        if ($queryLang && in_array($queryLang, $supportedLanguages)) {
            app()->setLocale($queryLang);
            URL::defaults(['lang' => $queryLang]);
            return $next($request);
        }
        $lang = $request->segment(1);
        // Allow 'livewire' and 'admin' to bypass this middleware
        if ($lang === 'livewire' || $lang === 'admin') {
            return $next($request);
        }
        // Check if the language is supported
        if (in_array($lang, $supportedLanguages)) {
            app()->setLocale($lang);
            URL::defaults(['lang' => $lang]);
        } else {
            // If the language is not supported, redirect to the default language
            return redirect()->to('/ar' . $request->getRequestUri());
        }
        return $next($request);
    }
}
