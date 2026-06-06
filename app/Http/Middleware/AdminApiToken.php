<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = trim((string) $request->bearerToken());

        if ($token === '') {
            return response()->json([
                'message' => 'Missing bearer token.',
            ], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Invalid API token.',
                'hint' => 'The token you entered does not match any api_token in the users table.',
            ], 401);
        }

        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Admin access only.',
            ], 403);
        }

        Auth::setUser($user);

        return $next($request);
    }
}