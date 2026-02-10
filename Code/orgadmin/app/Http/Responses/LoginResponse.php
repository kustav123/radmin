<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        // If tenant is initialized, stay on tenant domain
        if (tenancy()->initialized && tenant()) {
            return redirect()->route('tenant.dashboard');
        }

        // Central fallback
        return redirect()->route('dashboard');
    }
}
