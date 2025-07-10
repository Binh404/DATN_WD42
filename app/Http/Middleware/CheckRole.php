<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$vaiTro)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRoles = optional($user->vaiTros)->pluck('ten')->toArray();
        // dd($userRoles);
        Log::info('Đang kiểm tra role cho route: ' . $request->path());
        Log::info('User Roles: ' . json_encode($userRoles));


        foreach ($vaiTro as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        return abort(403, 'Bạn không có quyền truy cập.');
    }
}
