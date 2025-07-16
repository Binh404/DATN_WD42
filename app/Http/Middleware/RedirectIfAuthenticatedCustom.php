<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedCustom
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roles = optional($user->vaiTros)->pluck('ten')->toArray();
            // dd($roles);
            if (in_array('admin', $roles)) {
                return redirect()->route('admin.dashboard');
            } elseif (in_array('hr', $roles)) {
                return redirect()->route('hr.dashboard');
            } elseif (in_array('department', $roles)) {
                return redirect()->route('department.dashboard');
            }elseif (in_array('employee', $roles)) {
                return redirect()->route('employee.dashboard');
            }

            return redirect('/'); // fallback nếu không có vai trò
        }

        return $next($request);
    }
}
