<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\CompanyController;
use App\Http\Middleware\InitializeTenancyForNonCentralDomains;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'web',
    InitializeTenancyForNonCentralDomains::class,
])->group(function () {

    Route::get('/login', fn () => view('auth.login'))
        ->name('tenant.login');

    Route::post('/login', [
        \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class,
        'store'
    ])->name('tenant.login.store');

    Route::post('/logout', [
        \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class,
        'destroy'
    ])->name('tenant.logout');
});

/*
|--------------------------------------------------------------------------
| Tenant Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware([
    'web',
    InitializeTenancyForNonCentralDomains::class,
    PreventAccessFromCentralDomains::class,
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', fn () => redirect()->route('tenant.dashboard'));

    Route::get('/dashboard', fn () => view('dashboard'))
        ->name('tenant.dashboard');

    Route::get('/users', \App\Livewire\Tenant\UserCrud::class)
        ->name('tenant.users');

    Route::get('/roles', \App\Livewire\Tenant\RoleCrud::class)
        ->name('tenant.roles');

    Route::get('/settings', [CompanyController::class, 'settings'])
        ->name('tenant.settings');
});
