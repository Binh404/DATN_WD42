<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinTuyenDung;
use App\Models\UngTuyen;
use Illuminate\Http\Request;

class UngTuyenController extends Controller
{
    public function danhSachPhongVan(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with('tinTuyenDung')
            ->where('trang_thai', 'phe_duyet')
            ->orderBy('diem_danh_gia', 'desc');
        
        if ($request->filled('ten_ung_vien')) {
            $ungVienQuery->where('ten_ung_vien', 'like', '%' . $request->ten_ung_vien . '%');
        }

        if ($request->filled('ky_nang')) {
            $ungVienQuery->where('ky_nang', 'like', '%' . $request->ky_nang . '%');
        }

        if ($request->filled('kinh_nghiem')) {
            $ungVienQuery->where('kinh_nghiem', $request->kinh_nghiem);
        }

        if ($request->filled('vi_tri')) {
            $ungVienQuery->where('tin_tuyen_dung_id', $request->vi_tri);
        }
        
        $ungViens = $ungVienQuery->get();
        
        return view('admin.ungtuyen.phong-van', compact('ungViens', 'viTriList'));
    }

    public function capNhatDiemPhongVan(Request $request, $id)
    {
        $request->validate([
            'diem_phong_van' => 'required|numeric|min:0|max:10',
            'ghi_chu_phong_van' => 'nullable|string'
        ]);

        $ungVien = UngTuyen::findOrFail($id);
        $ungVien->update([
            'diem_phong_van' => $request->diem_phong_van,
            'ghi_chu_phong_van' => $request->ghi_chu_phong_van,
            'trang_thai_pv' => true
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật điểm phỏng vấn thành công!');
    }
} 