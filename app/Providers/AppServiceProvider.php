<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
        // Set the locale based on the 'lang' query parameter or session
        $locale = request('lang', Session::get('lang', 'en'));
        App::setLocale($locale);
        Session::put('lang', $locale);
    }
}
