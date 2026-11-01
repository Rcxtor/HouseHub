<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'HouseHub API is running.',
        'version' => '1.0.0',
    ]);
});
