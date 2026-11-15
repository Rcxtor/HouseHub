<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PropertyController;

// Route::get('/health', function () {
//     return response()->json([
//         'success' => true,
//         'message' => 'HouseHub API is running.',
//         'version' => '1.0.0',
//     ]);
// });


// Public routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:register');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// Public property routes
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'show']);

// Property management routes
Route::middleware(['auth:sanctum', 'active', 'role:owner'])
    ->group(function () {

        Route::post('/properties', [PropertyController::class, 'store']);

        Route::put('/properties/{property}', [PropertyController::class, 'update']);

        Route::patch('/properties/{property}', [PropertyController::class, 'update']);

        Route::delete('/properties/{property}', [PropertyController::class, 'destroy']);
    });
// Route::middleware(['auth:sanctum', 'active', 'role:admin'])
//     ->get('/test/admin', function () {
//         return response()->json([
//             'message' => 'Admin access granted.',
//         ]);
//     });

// Route::middleware(['auth:sanctum', 'active', 'role:owner,admin'])
//     ->get('/test/owner', function () {
//         return response()->json([
//             'message' => 'Owner or admin access granted.',
//         ]);
//     });

// Route::middleware(['auth:sanctum', 'active', 'role:renter'])
//     ->get('/test/renter', function () {
//         return response()->json([
//             'message' => 'Renter access granted.',
//         ]);
//     });