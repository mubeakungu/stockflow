<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return response()->view('errors.401', [], 401);
        }

        $userRole = auth()->user()->role->value;

        if (!in_array($userRole, $roles)) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
