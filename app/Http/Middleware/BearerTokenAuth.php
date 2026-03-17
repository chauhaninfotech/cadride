<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BearerTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
    
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token Not Found'], 401);
        }

        $table = $request->input('role') == 'passenger' ? 'passengers' : 'riders';
        $user = DB::table($table)->where('otp_key', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid Token'], 401);
        }

        Auth::loginUsingId($user->id);

        return $next($request);
    }
}
