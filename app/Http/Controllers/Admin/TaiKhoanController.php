<?php

namespace App\Http\Controllers\admin;

// use DB;
use App\Models\VaiTro;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class TaiKhoanController extends Controller
{
    public function getall(Request $request)
    {
        $taikhoan = NguoiDung::with(['phongBan', 'chucVu'])->get(); // lấy toàn bộ
        return view('admin.taikhoan.index', compact('taikhoan'));
    }

    public function edit($id)
    {

        $taikhoan = NguoiDung::findOrFail($id);
        // $taikhoan = NguoiDung::with('vaiTro')->get();
        $ds_vaitro = VaiTro::all();
        return view('admin.taikhoan.edit', compact('taikhoan', 'ds_vaitro'));
    }
    public function update(Request $request, $id)
    {
        $taikhoan = NguoiDung::findOrFail($id);

        $request->validate([
            'ten_dang_nhap' => 'required|max:255',
            'email' => 'required|email',
            'trang_thai' => 'required|boolean',
            'trang_thai_cong_viec' => 'required|in:dang_lam,da_nghi',
            'vai_tro_id' => 'required|exists:vai_tro,id',
        ]);

        // 1. Cập nhật bảng nguoi_dung
        $taikhoan->update([
            'ten_dang_nhap' => $request->ten_dang_nhap,
            'email' => $request->email,
            'trang_thai' => $request->trang_thai,
            'trang_thai_cong_viec' => $request->trang_thai_cong_viec,
            'vai_tro_id' => $request->vai_tro_id, // nếu bạn còn dùng cột này
        ]);

        // 2. Cập nhật bảng nguoi_dung_vai_tro (nhiều – nhiều)
        DB::table('nguoi_dung_vai_tro')
            ->where('nguoi_dung_id', $id)
            ->update([
                'vai_tro_id' => $request->vai_tro_id,
                'model_type' => \App\Models\NguoiDung::class,
                'updated_at' => now()
            ]);

        return redirect()->route('tkall')->with('success', 'Cập nhật tài khoản thành công!');
    }
}
