<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;


foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/organization', [OrganizationController::class, 'index'])->name('organization');
        Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organization.create');
        Route::get('/organization/edit/{id}', [OrganizationController::class, 'edit'])->name('organization.edit');
        Route::get('/organization/show/{id}', [OrganizationController::class, 'show'])->name('organization.show');
        Route::get('/organization/delete/{id}', [OrganizationController::class, 'destroy'])->name('organization.delete');

        Route::get('/device-group', \App\Livewire\DeviceGroupManager::class)->name('device-group');
    });
}
