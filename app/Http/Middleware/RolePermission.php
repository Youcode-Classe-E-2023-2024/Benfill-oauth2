<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\UserHasRole;
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
        $userRole = UserHasRole::where('user_id', Auth::id())->first();

        if (!isset($userRole)) {
            return response()->json([
                'error' => 'User role not found'
            ], 404);
        }

        $role_id = Role::where('name', 'admin')->value('id');

        if (!$role_id) {
            return response()->json([
                'error' => 'Role not found'
            ], 404);
        }

        if ($userRole->role_id !== $role_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to perform this action.'
            ], 403);
        }

        return $next($request);
    }
}
