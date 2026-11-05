<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => $data['password'],
            ]);

            $user->assignDefaultRole();

            return $user;
        });

        // Log the new user into the session.
        Auth::login($user);

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registration successful.',
            'user' => new UserResource(
                $user->load(['roles', 'ownerProfile'])
            ),
        ], 201);
    }

    // public function login(LoginRequest $request)
    // {
    //     $credentials = $request->validated();

    //     if (!Auth::attempt($credentials)) {
    //         throw ValidationException::withMessages([
    //             'email' => ['The provided credentials are incorrect.'],
    //         ]);
    //     }

    //     // Prevent session fixation.
    //     $request->session()->regenerate();

    //     $user = Auth::user()->load([
    //         'roles',
    //         'ownerProfile',
    //     ]);

    //     return response()->json([
    //         'message' => 'Login successful.',
    //         'user' => new UserResource($user),
    //     ]);
    // }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'phone';

        $credentials = [
            $field => $data['login'],
            'password' => $data['password'],
        ];

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        // Reject suspended or deactivated accounts.
        if ($user->is_suspended || $user->deactivated_at !== null) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'message' => 'Your account is currently unavailable.',
            ], 403);
        }

        $request->session()->regenerate();

        $user->load(['roles', 'ownerProfile']);

        return response()->json([
            'message' => 'Login successful.',
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load([
            'roles',
            'ownerProfile',
        ]);

        return new UserResource($user);
    }
}
