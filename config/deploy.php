<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Deploy Secret Token
    |--------------------------------------------------------------------------
    |
    | Secret token required to access the deploy console at /_deploy/{token}.
    | Leave empty to disable the page entirely.
    |
    */

    'secret' => env('DEPLOY_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Allowed Artisan Commands
    |--------------------------------------------------------------------------
    |
    | Only these commands can be executed from the deploy console.
    | Key = form identifier, value = [command, parameters].
    |
    */

    'commands' => [
        'migrate' => [
            'label' => 'تشغيل Migrations',
            'description' => 'php artisan migrate --force',
            'command' => 'migrate',
            'parameters' => ['--force' => true],
            'dangerous' => false,
        ],
        'migrate_status' => [
            'label' => 'حالة Migrations',
            'description' => 'php artisan migrate:status',
            'command' => 'migrate:status',
            'parameters' => [],
            'dangerous' => false,
        ],
        'storage_link' => [
            'label' => 'ربط Storage',
            'description' => 'storage:link (أو بديل .htaccess إذا symlink معطّل)',
            'handler' => \App\Support\StorageLinker::class,
            'dangerous' => false,
        ],
        'db_seed' => [
            'label' => 'تعبئة البيانات (Seed)',
            'description' => 'php artisan db:seed --force',
            'command' => 'db:seed',
            'parameters' => ['--force' => true],
            'dangerous' => false,
        ],
        'config_cache' => [
            'label' => 'تخزين Config',
            'description' => 'php artisan config:cache',
            'command' => 'config:cache',
            'parameters' => [],
            'dangerous' => false,
        ],
        'config_clear' => [
            'label' => 'مسح Config',
            'description' => 'php artisan config:clear',
            'command' => 'config:clear',
            'parameters' => [],
            'dangerous' => false,
        ],
        'route_cache' => [
            'label' => 'تخزين Routes',
            'description' => 'php artisan route:cache',
            'command' => 'route:cache',
            'parameters' => [],
            'dangerous' => false,
        ],
        'route_clear' => [
            'label' => 'مسح Routes',
            'description' => 'php artisan route:clear',
            'command' => 'route:clear',
            'parameters' => [],
            'dangerous' => false,
        ],
        'view_cache' => [
            'label' => 'تخزين Views',
            'description' => 'php artisan view:cache',
            'command' => 'view:cache',
            'parameters' => [],
            'dangerous' => false,
        ],
        'view_clear' => [
            'label' => 'مسح Views',
            'description' => 'php artisan view:clear',
            'command' => 'view:clear',
            'parameters' => [],
            'dangerous' => false,
        ],
        'cache_clear' => [
            'label' => 'مسح Cache',
            'description' => 'php artisan cache:clear',
            'command' => 'cache:clear',
            'parameters' => [],
            'dangerous' => false,
        ],
        'optimize' => [
            'label' => 'تحسين (Optimize)',
            'description' => 'php artisan optimize',
            'command' => 'optimize',
            'parameters' => [],
            'dangerous' => false,
        ],
        'optimize_clear' => [
            'label' => 'مسح التحسين',
            'description' => 'php artisan optimize:clear',
            'command' => 'optimize:clear',
            'parameters' => [],
            'dangerous' => false,
        ],
        'migrate_fresh_seed' => [
            'label' => 'إعادة بناء القاعدة + Seed',
            'description' => 'php artisan migrate:fresh --seed --force (يحذف كل البيانات!)',
            'command' => 'migrate:fresh',
            'parameters' => ['--seed' => true, '--force' => true],
            'dangerous' => true,
        ],
    ],
];
