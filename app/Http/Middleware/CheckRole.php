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


    foreach ($vaiTro as $role) {
        if (in_array($role, $userRoles)) {
            return $next($request);
        }
    }
// Log::info('User ID: ' . $user->id);
// Log::info('Roles: ' . json_encode($user->vaiTros->pluck('ten')->toArray())); // log để check login vào user id và role nào
    return abort(403, 'Bạn không có quyền truy cập.');
}

}