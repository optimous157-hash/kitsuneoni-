<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            auth()->logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Unauthorized access.']);
        }

        return $next($request);
    }
}
