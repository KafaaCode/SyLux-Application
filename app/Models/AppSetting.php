<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('app_settings_cache');
        });

        static::deleted(function () {
            Cache::forget('app_settings_cache');
        });
    }

    public static function allSettings(): array
    {
        return Cache::rememberForever('app_settings_cache', function () {
            return self::query()->pluck('value', 'key')->toArray();
        });
    }

    public static function get(string $key, $default = null)
    {
        $settings = self::allSettings();
        return $settings[$key] ?? $default;
    }

    public static function set(string $key, $value, ?string $type = null, ?string $group = null)
    {
        return self::updateOrCreate(['key' => $key], [
            'value' => $value,
            'type' => $type,
            'group' => $group,
        ]);
    }
}



