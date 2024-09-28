<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard()->user();

        if (empty($user)) {
            return response()->json([
                'status' => 'error',
                'message' => "Please Provide valid JWT token to perform the action",
            ], JsonResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
