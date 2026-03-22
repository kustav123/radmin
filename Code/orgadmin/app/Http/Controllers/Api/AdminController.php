<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_organizations' => Organization::count(),
            'active_organizations' => Organization::where('status', true)->count(),
            'total_users' => User::count(),
            'revenue' => 0, // Placeholder
        ]);
    }

    public function organizations(Request $request)
    {
        // Retrieve organizations with pagination or all
        $organizations = Organization::with('creator')->latest()->get();
        return response()->json($organizations);
    }

    public function activity()
    {
        // Return mock activity data for now since there is no Activity model
        return response()->json([
            [
                'id' => 1,
                'type' => 'organization_created',
                'description' => 'New organization was created.',
                'created_at' => now()->subMinutes(5)->toIso8601String(),
            ],
            [
                'id' => 2,
                'type' => 'user_registered',
                'description' => 'A new admin user registered.',
                'created_at' => now()->subHours(2)->toIso8601String(),
            ],
            [
                'id' => 3,
                'type' => 'system_update',
                'description' => 'System maintenance completed successfully.',
                'created_at' => now()->subDays(1)->toIso8601String(),
            ],
        ]);
    }
}
