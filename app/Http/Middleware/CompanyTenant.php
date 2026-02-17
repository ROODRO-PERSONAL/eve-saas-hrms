<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Only proceed if user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Optionally, you can enforce company_id in request payload
        if ($request->has('company_id')) {
            unset($request['company_id']); // Remove company_id from request to prevent abuse
        }

        return $next($request);
    }
}
