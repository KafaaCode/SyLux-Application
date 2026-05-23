<?php

namespace App\Traits;

trait Translatable
{
    /**
     * Get translated name for the current locale
     */
    public function getTranslatedName($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = $this->translations()->where('locale', $locale)->first();
        
        return $translation ? $translation->name_translated : $this->name;
    }
    
    /**
     * Get translated description for the current locale (for products)
     */
    public function getTranslatedDescription($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = $this->translations()->where('locale', $locale)->first();
        
        return $translation ? $translation->description_translated : $this->description;
    }
    
    /**
     * Get translated attribute for the current locale
     */
    public function getTranslatedAttribute($attribute, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = $this->translations()->where('locale', $locale)->first();
        
        if ($translation && isset($translation->{$attribute . '_translated'})) {
            return $translation->{$attribute . '_translated'};
        }
        
        return $this->{$attribute};
    }
    
    /**
     * Check if translation exists for specific locale
     */
    public function hasTranslation($locale)
    {
        return $this->translations()->where('locale', $locale)->exists();
    }
    
    /**
     * Get all available translations
     */
    public function getAvailableTranslations()
    {
        return $this->translations()->pluck('locale')->toArray();
    }
}
