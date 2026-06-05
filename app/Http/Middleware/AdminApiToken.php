<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json([
                'message' => 'Missing bearer token.',
            ], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Invalid API token.',
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
class AdminApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
