<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd();
            $locale = $request->segment(1);
            //dd(! in_array($locale, Config::get('app.available_locales')));
        if ( ! in_array($locale, Config::get('app.available_locales'))) {
            //$segments = $request->segments(2);
            //dd();
            $segments[0] = Config::get('app.fallback_locale');

            return redirect('/'.$segments[0].'/?'.$request->getQueryString());
        }

        App::setLocale($locale);
        return $next($request);
    }
}
