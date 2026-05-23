<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetApiLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. التحقق من Header Accept-Language
        $acceptLanguage = $request->header('Accept-Language');
        
        // 2. التحقق من Header X-Locale (مخصص للتطبيقات)
        $customLocale = $request->header('X-Locale');
        
        // 3. التحقق من Parameter locale في URL
        $urlLocale = $request->query('locale');
        
        // 4. التحقق من Cookie
        $cookieLocale = $request->cookie('locale');
        
        // 5. اللغة الافتراضية من التطبيق
        $defaultLocale = config('app.locale', 'ar');
        
        // اللغات المدعومة
        $supportedLocales = array_keys(config('app.available_locales', []));
        
        // تحديد اللغة بناءً على الأولوية
        $locale = $this->determineLocale([
            'custom' => $customLocale,
            'accept' => $this->parseAcceptLanguage($acceptLanguage),
            'url' => $urlLocale,
            'cookie' => $cookieLocale,
            'default' => $defaultLocale
        ], $supportedLocales);
        
        // تعيين اللغة
        App::setLocale($locale);
        
        // إضافة اللغة إلى الاستجابة
        $response = $next($request);
        
        // إضافة معلومات اللغة إلى الاستجابة
        $response->header('X-Response-Locale', $locale);
        
        // حفظ اللغة في Cookie إذا لم تكن موجودة
        if (!$request->cookie('locale')) {
            $response->cookie('locale', $locale, 60 * 24 * 30); // 30 يوم
        }
        
        return $response;
    }
    
    /**
     * تحديد اللغة بناءً على الأولوية
     */
    private function determineLocale(array $locales, array $supportedLocales): string
    {
        // الأولوية: Custom Header > Accept-Language > URL Parameter > Cookie > Default
        
        if (!empty($locales['custom']) && in_array($locales['custom'], $supportedLocales)) {
            return $locales['custom'];
        }
        
        if (!empty($locales['accept']) && in_array($locales['accept'], $supportedLocales)) {
            return $locales['accept'];
        }
        
        if (!empty($locales['url']) && in_array($locales['url'], $supportedLocales)) {
            return $locales['url'];
        }
        
        if (!empty($locales['cookie']) && in_array($locales['cookie'], $supportedLocales)) {
            return $locales['cookie'];
        }
        
        return $locales['default'];
    }
    
    /**
     * تحليل Accept-Language header
     */
    private function parseAcceptLanguage(?string $acceptLanguage): ?string
    {
        if (!$acceptLanguage) {
            return null;
        }
        
        // تحليل Accept-Language header
        $languages = [];
        $parts = explode(',', $acceptLanguage);
        
        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, ';') !== false) {
                list($lang, $quality) = explode(';', $part, 2);
                $quality = floatval(str_replace('q=', '', $quality));
            } else {
                $lang = $part;
                $quality = 1.0;
            }
            
            // استخراج اللغة الأساسية (ar, en, tr, nl, be)
            $lang = strtolower(substr(trim($lang), 0, 2));
            $languages[$lang] = $quality;
        }
        
        // ترتيب حسب الأولوية
        arsort($languages);
        
        // إرجاع أول لغة مدعومة
        $supportedLocales = array_keys(config('app.available_locales', []));
        foreach (array_keys($languages) as $lang) {
            if (in_array($lang, $supportedLocales)) {
                return $lang;
            }
        }
        
        return null;
    }
}
