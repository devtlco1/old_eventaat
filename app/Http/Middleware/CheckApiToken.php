<?php

namespace App\Http\Middleware;

use App\Traits\HelperTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    use  HelperTrait ;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the 'Token' header matches the expected token
        $expectedToken = 'bbc41db488jsnd862kjn24e630cf3122abd4218ea74f38226ab160350f75c4e305ed3653fcb1';
        $locale = $request->header('lang', 'en');
        App::setLocale($locale);
        if ($request->header('Token') !== $expectedToken) {
            // Return an error response if the token doesn't match
            return  $this->UN_AUTHENTICATED();
        }

        return $next($request);
    }
}
