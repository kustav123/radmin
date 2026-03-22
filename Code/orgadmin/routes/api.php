<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Middleware\InitializeTenancyByHeader;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Admin Routes
    Route::prefix('admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'stats']);
        Route::get('/organizations', [AdminController::class, 'organizations']);
        Route::get('/activity', [AdminController::class, 'activity']);
    });
    
    // Tenant-Aware API Routes Prefix/Group
    Route::middleware([InitializeTenancyByHeader::class])->group(function () {
        
        // Example tenant-aware route
        Route::get('/tenant/status', function (Request $request) {
            return response()->json([
                'message' => 'You are accessing the tenant database',
                'tenant' => tenant('name')
            ]);
        });
        
    });
});
