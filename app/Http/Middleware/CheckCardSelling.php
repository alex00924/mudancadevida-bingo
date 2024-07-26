<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCardSelling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!\App\Models\SiteSetting::isEnabledSelling() &&
            (!auth()->check() ||
            (auth()->check() &&
                !auth()->user()->hasRole('admin'))
            ))
        {
            return redirect('not-selling-now');
        }

        return $next($request);
    }
}
