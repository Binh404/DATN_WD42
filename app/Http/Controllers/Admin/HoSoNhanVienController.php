<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Models\HoSoNguoiDung;
use Illuminate\Validation\Rule;

class HoSoNhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nhanVien = NguoiDung::with(['hoSo', 'phongBan', 'chucVu'])->get();

        return view('admin.hoso.index', compact('nhanVien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NguoiDung $nguoiDung)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NguoiDung $nguoiDung, $id)
    {
        $hoSo = HoSoNguoiDung::findOrFail($id);
        return view('admin.hoso.edit', compact('hoSo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NguoiDung $nguoiDung, $id)
    {
        $hoSo = HoSoNguoiDung::findOrFail($id);

    $request->validate([
        // Không cho sửa ma_nhan_vien
        'ho' => 'required|string|max:50',
        'ten' => 'required|string|max:50',
        'email_cong_ty' => [
            'nullable', 'email',
            Rule::unique('ho_so_nguoi_dung')->ignore($hoSo->id)
        ],
        'so_dien_thoai' => 'nullable|string|max:15',
        'ngay_sinh' => 'nullable|date',
        'gioi_tinh' => 'nullable|in:nam,nu,khac',
        'dia_chi_hien_tai' => 'nullable|string',
        'dia_chi_thuong_tru' => 'nullable|string',
        'cmnd_cccd' => [
            'nullable', 'string',
            Rule::unique('ho_so_nguoi_dung')->ignore($hoSo->id)
        ],
        'so_ho_chieu' => 'nullable|string|max:20',
        'tinh_trang_hon_nhan' => 'nullable|in:doc_than,da_ket_hon,ly_hon,goa',
        'lien_he_khan_cap' => 'nullable|string|max:50',
        'sdt_khan_cap' => 'nullable|string|max:15',
        'quan_he_khan_cap' => 'nullable|string|max:50',
    ]);

    $hoSo->update($request->except('ma_nhan_vien'));

    return redirect()->route('hoso.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NguoiDung $nguoiDung)
    {
        //
    }
}
