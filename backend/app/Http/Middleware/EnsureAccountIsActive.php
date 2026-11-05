<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user->is_suspended || $user->deactivated_at !== null) {
            return response()->json([
                'message' => 'Your account is currently unavailable.',
            ], 403);
        }

        return $next($request);
    }
}