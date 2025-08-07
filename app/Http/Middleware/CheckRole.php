<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        $userRoles = optional($user->vaiTros)->pluck('name')->toArray();
        // dd(...$userRoles);

        Log::info('Đang kiểm tra role cho route: ' . $request->path());
        Log::info('User Roles: ' . json_encode($userRoles));


        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        // Nếu quan hệ belongsTo
        $userRole = optional($user->vaiTro)->name;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cậpp.');
    }
}
