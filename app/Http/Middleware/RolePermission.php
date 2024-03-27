<?php

namespace App\Http\Middleware;

use App\Http\Controllers\RoleController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!RoleController::UserHasRole(Auth::id(), 'admin'))
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to perform this action.'
            ], 403);

        return $next($request);
    }
}
