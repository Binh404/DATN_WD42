<?php

namespace App\Http\Controllers\admin;

// use DB;
use App\Models\VaiTro;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChucVu;
use App\Models\PhongBan;
use Illuminate\Support\Facades\DB;

class TaiKhoanController extends Controller
{
    public function getall(Request $request)
    {
        $query = NguoiDung::with(['vaiTro', 'chucVu', 'PhongBan', 'hoSo']);

        // Tìm kiếm theo họ tên hoặc mã nhân viên
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('hoSo', function ($q) use ($keyword) {
                $q->where('ho', 'like', "%$keyword%")
                    ->orWhere('ten', 'like', "%$keyword%")
                    ->orWhere('ma_nhan_vien', 'like', "%$keyword%");
            });
        }

        // Lọc theo phòng ban
        if ($request->filled('phong_ban')) {
            $query->where('phong_ban_id', $request->phong_ban);
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $taikhoan = $query->paginate(20)->appends($request->query());
        $phongBans = PhongBan::all();

        return view('admin.taikhoan.index', compact('taikhoan', 'phongBans'));
    }

    public function edit($id)
    {

        $taikhoan = NguoiDung::findOrFail($id);
        // $taikhoan = NguoiDung::with('vaiTro')->get();
        $ds_vaitro = VaiTro::all();
        $ds_phongban = PhongBan::all();
        $ds_chucvu = ChucVu::all();
        return view('admin.taikhoan.edit', compact('taikhoan', 'ds_vaitro', 'ds_phongban', 'ds_chucvu'));
    }
    public function update(Request $request, $id)
    {
        $taikhoan = NguoiDung::findOrFail($id);

        $request->validate([
            'ten_dang_nhap' => 'required|max:255',
            'email'         => 'required|email',
            'trang_thai'    => 'required|boolean',
            'vai_tro_id'    => 'required|exists:vai_tro,id',
            'phong_ban_id'  => 'required|exists:phong_ban,id',
            'chuc_vu_id'    => 'required|exists:chuc_vu,id',
           
        ]);

        // 1. Cập nhật bảng nguoi_dung
        $taikhoan->update([
            'ten_dang_nhap' => $request->ten_dang_nhap,
            'email'         => $request->email,
            'trang_thai'    => $request->trang_thai,
            'vai_tro_id'    => $request->vai_tro_id,    
            'phong_ban_id'  => $request->phong_ban_id,
            'chuc_vu_id'    => $request->chuc_vu_id,
           
        ]);



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
