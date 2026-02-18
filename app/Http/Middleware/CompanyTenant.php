<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyTenant
{
    public function handle(Request $request, Closure $next)
    {
        // procede when user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // returning company id from request
        if ($request->has('company_id')) {
            // unsetting to prevent mass assignment issues
            unset($request['company_id']); 
        }

        return $next($request);
    }
}
