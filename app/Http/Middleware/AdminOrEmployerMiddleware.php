<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrEmployerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role == 'admin' || $request->user()->role == 'employer') {
            return $next($request);
        }

        return response()->json(['message' => 'unauthorized'], 403);
    }
}
