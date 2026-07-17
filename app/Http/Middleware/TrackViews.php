<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && !$request->ajax() && !$request->is('admin/*')) {
            $key = 'page_views_' . now()->format('Y-m-d');
            $views = cache()->get($key, 0);
            cache()->put($key, $views + 1, now()->addDay());
        }

        return $response;
    }
}
