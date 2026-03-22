<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect credentials.'],
            ]);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        // Fetch organizations related to the central user. 
        // Based on the DB structure, assuming organizations created_by the user.
        $organizations = Organization::where('created_by', $user->id)->get();

        return response()->json([
            'token' => $token,
            'user' => $user,
            'organizations' => $organizations,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'organizations' => Organization::where('created_by', $request->user()->id)->get()
        ]);
    }
}
