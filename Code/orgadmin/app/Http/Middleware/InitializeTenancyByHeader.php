<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Organization;

class InitializeTenancyByHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->header('X-Tenant');

        if (! $tenantId) {
            return response()->json(['message' => 'Missing X-Tenant header.'], 400);
        }

        $tenant = Organization::find($tenantId);

        if (! $tenant) {
            return response()->json(['message' => 'Tenant not found.'], 404);
        }

        tenancy()->initialize($tenant);

        return $next($request);
    }
}
