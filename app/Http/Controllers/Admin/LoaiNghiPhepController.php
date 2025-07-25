<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoaiNghiPhep;
use Illuminate\Http\Request;

class LoaiNghiPhepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loaiNghiPheps = LoaiNghiPhep::all();
        return view('admin.nghiphep.loainghiphep.index', compact('loaiNghiPheps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.nghiphep.loainghiphep.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            'ma' => 'required|string|max:255|unique:loai_nghi_phep,ma',
            'mo_ta' => 'nullable|string',
            'so_ngay_nam' => 'required|integer|min:0',
            'toi_da_ngay_lien_tiep' => 'required|integer|min:0',
            'so_ngay_bao_truoc' => 'required|integer|min:0|max:127',
            'cho_phep_chuyen_nam' => 'required|boolean',
            'toi_da_ngay_chuyen' => 'min:0|max:255',
            'gioi_tinh_ap_dung' => 'required|in:tat_ca,nam,nu',
            'yeu_cau_giay_to' => 'required|boolean',
            'co_luong' => 'required|boolean',
            'trang_thai' => 'required|boolean',
        ], [
            'ten.required' => 'Tên loại nghỉ phép không được để trống.',

            'ma.required' => 'Mã loại nghỉ phép không được để trống.',
            'ma.unique' => 'Mã loại nghỉ phép đã tồn tại.',

            'so_ngay_nam.required' => 'Vui lòng nhập số ngày nghỉ phép trong năm.',
            'so_ngay_nam.integer' => 'Số ngày phải là số nguyên.',
            'so_ngay_nam.min' => 'Số ngày phải lớn hơn hoặc bằng 0.',

            'toi_da_ngay_lien_tiep.required' => 'Vui lòng nhập số ngày nghỉ liên tiếp tối đa.',
            'toi_da_ngay_lien_tiep.integer' => 'Số ngày liên tiếp phải là số nguyên.',
            'toi_da_ngay_lien_tiep.min' => 'Số ngày liên tiếp phải lớn hơn hoặc bằng 0.',

            'so_ngay_bao_truoc.required' => 'Vui lòng nhập số ngày báo trước.',
            'so_ngay_bao_truoc.integer' => 'Số ngày báo trước phải là số nguyên.',
            'so_ngay_bao_truoc.min' => 'Số ngày báo trước không được âm.',
            'so_ngay_bao_truoc.max' => 'Số ngày báo trước tối đa là :max.',

            'toi_da_ngay_chuyen.integer' => 'Số ngày chuyển phải là số nguyên.',
            'toi_da_ngay_chuyen.min' => 'Số ngày chuyển không được âm.',
            'toi_da_ngay_chuyen.max' => 'Số ngày chuyển tối đa là :max.',

            'gioi_tinh_ap_dung.required' => 'Vui lòng chọn giới tính áp dụng.',
            'gioi_tinh_ap_dung.in' => 'Giới tính áp dụng không hợp lệ.',
        ]);

        LoaiNghiPhep::create($validated);

        return redirect()->route('hr.loainghiphep.index')
            ->with('success', 'Thêm loại nghỉ phép thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $loaiNghiPhep = LoaiNghiPhep::findOrFail($id);
        return view('admin.nghiphep.loainghiphep.show', compact('loaiNghiPhep'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loaiNghiPhep = LoaiNghiPhep::findOrFail($id);
        return view('admin.nghiphep.loainghiphep.edit', compact('loaiNghiPhep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loaiNghiPhep = LoaiNghiPhep::findOrFail($id);

        $validated = $request->validate([
            'ten' => 'required|string|max:255',
            // 'ma' => 'required|string|max:255|unique:loai_nghi_phep,ma,' . $loaiNghiPhep->id,
            'mo_ta' => 'nullable|string',
            'so_ngay_nam' => 'required|integer|min:0',
            'toi_da_ngay_lien_tiep' => 'required|integer|min:0',
            'so_ngay_bao_truoc' => 'required|integer|min:0|max:127',
            'cho_phep_chuyen_nam' => 'required|boolean',
            'toi_da_ngay_chuyen' => 'required|integer|min:0|max:255',
            'gioi_tinh_ap_dung' => 'required|in:tat_ca,nam,nu',
            'yeu_cau_giay_to' => 'required|boolean',
            'co_luong' => 'required|boolean',
            'trang_thai' => 'required|boolean',
        ]);

        $loaiNghiPhep->update($validated);

        return redirect()->route('hr.loainghiphep.index')
            ->with('success', 'Cập nhật loại nghỉ phép thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loaiNghiPhep = LoaiNghiPhep::findOrFail($id)->delete();
        return redirect()->route('hr.loainghiphep.index')->with('success', "Đã xóa loại nghỉ phép thành công!");
    }
}
