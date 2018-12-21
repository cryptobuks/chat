<?php

namespace App\Chatter\Middleware;

use Closure;

class VerifyApiKey
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
        if ($request->header('X-Api-Key') != env('API_KEY')) {
            return response()->api()->unauthorized();
        }

        return $next($request);
    }
}
