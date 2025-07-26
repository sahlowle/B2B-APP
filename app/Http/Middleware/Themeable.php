<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Facades\Theme;

class Themeable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $themeName = null): Response
    {
        if (is_null($themeName)) {
            $themeName = preference('active_theme', 'default');
        }

        Theme::set($themeName);

        return $next($request);
    }
}
