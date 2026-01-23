<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/organization', function () {
        return view('pages.organization');
    })->name('organization');
    
    Route::get('/device-group', \App\Livewire\DeviceGroupManager::class)->name('device-group');
});
