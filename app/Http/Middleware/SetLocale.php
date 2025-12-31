<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Check if the 'lang' query parameter exists
        $locale = $request->query('lang', session('lang', 'en')); // Default to 'en'

        // Set the application locale
        App::setLocale($locale);

        // Store the selected locale in the session
        session(['lang' => $locale]);

        return $next($request);
    }
}