<?php

namespace App\Providers;

use App\Http\Resources\CategoryResourceBasic;
use App\Http\Resources\CategoryResourceExtended;
use App\Http\Resources\MentorResourceBasic;
use App\Http\Resources\MentorResourceExtended;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CategoryResourceBasic::withoutWrapping();
        CategoryResourceExtended::withoutWrapping();
        MentorResourceExtended::withoutWrapping();
        MentorResourceBasic::withoutWrapping();
    }
}
