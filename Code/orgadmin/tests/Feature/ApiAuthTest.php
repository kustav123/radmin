<?php

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('mobile app can login and receive token and organizations', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password'),
    ]);

    $org = Organization::create([
        'id' => \Illuminate\Support\Str::uuid()->toString(),
        'name' => 'Acme Corp',
        'created_by' => $user->id,
        'status' => true,
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'token',
        'user' => ['id', 'email'],
        'organizations' => [
            '*' => ['id', 'name']
        ]
    ]);
});

test('mobile app can access tenant-aware routes with header', function () {
    $user = User::factory()->create();
    $org = Organization::create([
        'id' => \Illuminate\Support\Str::uuid()->toString(),
        'name' => 'Acme Corp',
        'created_by' => $user->id,
        'status' => true,
    ]);

    Sanctum::actingAs($user, ['*']);

    $response = $this->withHeaders([
        'X-Tenant' => $org->id,
    ])->getJson('/api/tenant/status');

    $response->assertStatus(200);
    expect($response->json('tenant'))->toBe('Acme Corp');
});

test('mobile app fails to access tenant-aware route without header', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user, ['*']);

    $response = $this->getJson('/api/tenant/status');
    $response->assertStatus(400); // Missing X-Tenant header
});
