<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Stancl\Tenancy\Events\TenantCreated;


class CreateTenantAdmin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant;

        // Run this inside the tenant's context
        $tenant->run(function () use ($tenant) {
            User::firstOrCreate(
                ['email' => 'admin@' . $tenant->id . '.com'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('password'), // Default password
                    'email_verified_at' => now(),
                ]
            );
        });
    }
}
