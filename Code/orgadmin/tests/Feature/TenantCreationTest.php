<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TenantCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_organization_and_admin_user()
    {
        // Interact as a super admin
        $admin = User::factory()->create();
        $this->actingAs($admin);

        // Define org data
        $orgCode = 'testorg';
        $orgName = 'Test Organization';

        // Create Organization
        $org = Organization::create([
            'id' => $orgCode,
            'name' => $orgName,
            'created_by' => $admin->id,
            'status' => true,
        ]);

        $this->assertDatabaseHas('organizations', [
            'id' => $orgCode,
            'name' => $orgName,
        ]);

        // Assert Tenant Database exists? 
        // Stancl tenancy usually throws error if DB creation fails.
        // We can check if we can run code in tenant context.

        $org->run(function () {
            // Check if Admin user exists in tenant DB
            $this->assertDatabaseHas('users', [
                'email' => 'admin@testorg.com',
            ]);
        });
    }
}
