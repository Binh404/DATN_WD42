<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CongViec;
use App\Models\PhongBan;
use Illuminate\Http\Request;

class CongViecController extends Controller
{
    public function index()
    {
        $congviecs = CongViec::orderBy('id', 'desc')->get();
        return view('admin.congviec.index', compact('congviecs'));
    }

    public function create()
    {
        // $phongBans = PhongBan::all();
        return view('admin.congviec.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_cong_viec' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:chua_bat_dau, dang_lam, hoan_thanh',  // Kiểm tra giá trị trạng thái hợp lệ
            'do_uu_tien' => 'required|in:cao, trung_binh, thap',  // Kiểm tra giá trị độ ưu tiên hợp lệ
            'ngay_bat_dau' => 'required|date',
            'deadline' => 'required|date',
            'ngay_hoan_thanh' => 'nullable|date|after_or_equal:ngay_bat_dau',
        ], [
            'ten_cong_viec.required' => 'Tên công việc là bắt buộc.',
            'trang_thai.required' => 'Trạng thái công việc là bắt buộc.',
            'do_uu_tien.required' => 'Độ ưu tiên là bắt buộc.',
            'ngay_bat_dau.required' => 'Ngày bắt đầu là bắt buộc.',
            'deadline.required' => 'Deadline là bắt buộc.',
            'ngay_hoan_thanh.after_or_equal' => 'Ngày hoàn thành phải sau hoặc bằng ngày bắt đầu.',
        ]);
        CongViec::create($validated);

        // Quay lại trang danh sách công việc với thông báo thành công
        return redirect('/congviec')->with('success', 'Công việc đã được thêm thành công!');
    }

    public function show($id)
    {
        $congviec = CongViec::findOrFail($id);
        return view('admin.congviec.show', compact('congviec'));
    }

    public function edit($id)
    {
        $congviec = CongViec::findOrFail($id);  // Tìm công việc theo ID
        // $phongBans = PhongBan::all();  // Lấy danh sách phòng ban
        return view('admin.congviec.edit', compact('congviec'));
    }

    // Cập nhật công việc sau khi sửa
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ten_cong_viec' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|in:Chua bat dau, Dang lam, Hoan thanh',
            'do_uu_tien' => 'required|in:Cao, Trung bình, Thấp',
            'ngay_bat_dau' => 'required|date',
            'deadline' => 'required|date',
            'ngay_hoan_thanh' => 'nullable|date|after_or_equal:ngay_bat_dau',
        ]);

        $congviec = CongViec::findOrFail($id);
        $congviec->update($validated);

        return redirect()->route('congviec.index')->with('success', 'Công việc đã được cập nhật thành công!');
    }
    // Xóa công việc
    public function destroy($id)
    {
        $congviec = CongViec::findOrFail($id);
        $congviec->delete();

        return redirect('/congviec')->with('success', 'Công việc đã được xóa thành công!');
    }
}
