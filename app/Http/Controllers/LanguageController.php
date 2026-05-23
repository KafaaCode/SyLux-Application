<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change the application language
     */
    public function switchLanguage(Request $request, $locale)
    {
        if (in_array($locale, array_keys(config('app.available_locales', [])))) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }

    /**
     * Get current language
     */
    public function getCurrentLanguage()
    {
        return response()->json([
            'locale' => App::getLocale(),
            'available_locales' => config('app.available_locales', [])
        ]);
    }
}
