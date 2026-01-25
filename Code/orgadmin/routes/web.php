<?php

use Illuminate\Support\Facades\Route;



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

        Route::get('/organization', function () {
            return view('pages.organization');
        })->name('organization');

        Route::get('/device-group', \App\Livewire\DeviceGroupManager::class)->name('device-group');
    });
}
