<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyForNonCentralDomains
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $centralDomains = config('tenancy.central_domains', []);
        $currentDomain = $request->getHost();

        // If this is a central domain, skip tenancy initialization
        if (in_array($currentDomain, $centralDomains)) {
            return $next($request);
        }

        // Otherwise, initialize tenancy by domain
        try {
            return app(InitializeTenancyByDomain::class)->handle($request, $next);
        } catch (\Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException $e) {
            // Handle the case where tenant domain doesn't exist
            return response()->view('errors.404', [
                'title' => '404 Not Found',
                'code' => 404,
                'message' => "Tenant not found. The domain '{$request->getHost()}' is not registered in our system."
            ], 404);
        }
    }
}
