<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsEmployee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $method = $request->method();

        if (!$user->is_employee) {
            abort(response([
                'status' => false,
                'message' => 'Unauthorized access',
                'method' => $method,
            ], 401));
        }
        return $next($request);
    }
}
