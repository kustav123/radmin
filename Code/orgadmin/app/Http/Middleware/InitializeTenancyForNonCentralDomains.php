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
        return app(InitializeTenancyByDomain::class)->handle($request, $next);
    }
}
