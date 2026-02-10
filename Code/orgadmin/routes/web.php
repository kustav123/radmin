<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

Route::get('/_cookie-test', function () {
    session(['test' => 'ok']);
    return 'cookie test ok';
});

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->middleware(['web'])->group(function () {

        // Central login
        Route::get('/login', function () {
            return view('auth.login');
        })->name('login');

        Route::post('/login', [
            \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class,
            'store',
        ])->name('login.store');

        Route::post('/logout', [
            \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class,
            'destroy',
        ])->name('logout');
    });
}

/*
|--------------------------------------------------------------------------
| Central Authenticated Routes
|--------------------------------------------------------------------------
*/
foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->middleware([
        'web',
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {

        Route::get('/', fn () => view('welcome'));

        Route::get('/dashboard', fn () => view('dashboard'))
            ->name('dashboard');

        Route::get('/organization', [OrganizationController::class, 'index'])
            ->name('organization');

        Route::get('/organization/create', [OrganizationController::class, 'create'])
            ->name('organization.create');

        Route::get('/organization/edit/{id}', [OrganizationController::class, 'edit'])
            ->name('organization.edit');

        Route::get('/organization/show/{id}', [OrganizationController::class, 'show'])
            ->name('organization.show');

        Route::get('/organization/delete/{id}', [OrganizationController::class, 'destroy'])
            ->name('organization.delete');

        Route::get('/device-group', \App\Livewire\DeviceGroupManager::class)
            ->name('device-group');
    });
}
