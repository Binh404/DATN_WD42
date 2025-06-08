<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\PhongBan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use App\Models\NguoiDung;
use App\Models\VaiTro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function create(): View
    {
        $phongban = PhongBan::all();
        $chucvu = ChucVu::all();
        $vaitro = VaiTro::all();
        return view('auth.register', compact('phongban', 'chucvu', 'vaitro'));
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten_dang_nhap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . NguoiDung::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'vai_tro_id' => ['required', 'exists:vai_tro,id'],
            'phong_ban_id' => ['required', 'exists:phong_ban,id'],
            'chuc_vu_id' => ['required', 'exists:chuc_vu,id'], 
        ]);


        $user = NguoiDung::create([
            'ten_dang_nhap' => $request->ten_dang_nhap,
            'email' => $request->email,
            'vai_tro_id' => $request->vai_tro_id,
            'phong_ban_id' => $request->phong_ban_id,
            'chuc_vu_id' => $request->chuc_vu_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));


        return redirect(route('/', absolute: false));
    }
}
