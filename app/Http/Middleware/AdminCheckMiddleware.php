<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(Auth::user()->id);
        if(!$user || $user->role !== 'admin')
        {
            return response()->json([
                'status' => 'Failed',
                'message' => 'You are not Admin',
            ]);
        }

        return $next($request);
    }
}
