<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        $user = $request->user();

        // NO ROLE
        if (!$user || empty($roles)) {
            return response()->json([
                'message' => 'Forbidden.',
            ], 403);
        }

        // Check whether the user has at least one accepted role.
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => 'You do not have permission to access this resource.',
        ], 403);
    }
}
