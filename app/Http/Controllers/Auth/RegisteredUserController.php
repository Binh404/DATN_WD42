<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\ChucVu;
use App\Models\VaiTro;
use App\Models\PhongBan;
use App\Models\NguoiDung;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\NguoiDungVaiTro;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\LoaiNghiPhep;
use App\Models\SoDuNghiPhepNhanVien;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;


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
        // Gán vai trò cho người dùng
        $nguoiDungVT = NguoiDungVaiTro::create([
            'nguoi_dung_id' => $user->id,
            'vai_tro_id' => $request->vai_tro_id,
            'model_type' => NguoiDung::class,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        event(new Registered($user));

        // Tạo số dư nghỉ phép cho nhân viên
        $loaiNghiPhep = LoaiNghiPhep::all();
        $thangBatDauLam = Carbon::parse($user->created_at)->month;
        $soThangLamTrongNam = 12 - $thangBatDauLam + 1;

        foreach ($loaiNghiPhep as $item) {
            $soNgayDuocCap = $item->tinh_theo_ty_le
                ? round($item->so_ngay_nam * $soThangLamTrongNam / 12)
                : $item->so_ngay_nam;

            SoDuNghiPhepNhanVien::create([
                'nguoi_dung_id' => $user->id,
                'loai_nghi_phep_id' => $item->id,
                'nam' => now()->year,
                'so_ngay_duoc_cap' => $soNgayDuocCap,
                'so_ngay_da_dung' => 0,
                'so_ngay_cho_duyet' => 0,
                'so_ngay_con_lai' => $soNgayDuocCap,
                'so_ngay_chuyen_tu_nam_truoc' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect(route('hr.dashboard', absolute: false));
    }
}
