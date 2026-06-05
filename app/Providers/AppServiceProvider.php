<?php

namespace App\Providers;

use App\Contracts\Repositories\SectionRepositoryInterface;
use App\Repositories\SectionRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //



        Schema::defaultStringLength(191);
    }
}
