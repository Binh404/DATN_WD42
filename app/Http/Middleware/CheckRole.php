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

        if (!$user) {
            abort(401); // chưa đăng nhập
        }

        // Nếu quan hệ belongsTo
        $userRole = optional($user->vaiTro)->ten;

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập.');
    }
}