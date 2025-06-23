<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGetStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the 'get started' process is not completed
        // and the user is not already on the 'get-started' page or trying to complete it.
        if (!session('get_started_completed') && !$request->routeIs(['get-started', 'get-started.complete'])) {
            return redirect()->route('get-started');
        }

        // If the user has completed the process but tries to access the 'get-started' page again, redirect to dashboard.
        if (session('get_started_completed') && $request->routeIs('get-started')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
