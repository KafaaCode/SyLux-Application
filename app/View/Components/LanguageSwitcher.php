<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class LanguageSwitcher extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.language-switcher', [
            'currentLocale' => app()->getLocale(),
            'availableLocales' => config('app.available_locales', [])
        ]);
    }
}
