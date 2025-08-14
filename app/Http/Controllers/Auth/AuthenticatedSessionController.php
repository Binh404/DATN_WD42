<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý request đăng nhập.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();


        $user = Auth::user();
        if ($user->trang_thai_cong_viec === 'da_nghi') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản này đã nghỉ việc, không thể đăng nhập.',
            ]);
        }
    // Đảm bảo đã load vai trò
        // dd($request->session()->get('_token'));

        $roles = $user->vaiTros->pluck('ten')->toArray();

        if (in_array('admin', $roles)) {
            return redirect()->route('admin.dashboard');
        } elseif (in_array('hr', $roles)) {
            return redirect()->route('hr.dashboard');
        } elseif (in_array('employee', $roles)) {
            return redirect()->route('employee.dashboard');
        } elseif (in_array('department', $roles)) {
            return redirect()->route('department.dashboard');
        }

        // Không có vai trò phù hợp
        Auth::logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Tài khoản không có quyền truy cập hệ thống.',
        ]);
    }
    

    /**
     * Đăng xuất khỏi phiên đăng nhập.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
