<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyForNonCentralDomains
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // 1️⃣ Central domains → skip tenancy completely
        if (in_array($host, config('tenancy.central_domains', []), true)) {
            return $next($request);
        }

        // 2️⃣ Non-central domains → try to initialize tenancy
        try {
            return app(InitializeTenancyByDomain::class)->handle($request, $next);
        } catch (TenantCouldNotBeIdentifiedOnDomainException $e) {
            // 3️⃣ Unknown tenant domain → hard 404 (NOT login redirect)
            abort(404, "Tenant not found for domain {$host}");
        }
    }
}
