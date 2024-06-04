<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RestrictToMainAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Use existing middleware to redirect guests to the home page
        $response = app(\Illuminate\Auth\Middleware\Authenticate::class)->handle($request, function ($request) use ($next) {
            return $next($request);
        });

        // If the response is a redirect to the home page, return it immediately
        if ($response->getStatusCode() === 302 && $response->isRedirect(route('home'))) {
            return $response;
        }

        // Allow access to the registration route for main admin
        if ($request->is('register') && Auth::check() && Auth::user()->id === 1) {
            return $next($request);
        }

        // Restrict access for other users
        if (Auth::check() && Auth::user()->id !== 1) {
            abort(403, 'Unauthorized action.');
        }

        // Redirect main admin to the dashboard page
        if (Auth::check() && Auth::user()->id === 1) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
