<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TinTuyenDung;
use App\Models\UngTuyen;
use App\Models\UngVien;
use Illuminate\Http\Request;

class UngTuyenController extends Controller
{

    // Admin Ung Tuyen
    public function index() {
        $ungViens = UngTuyen::with('tinTuyenDung')->orderBy('id', 'desc')->get();
        return view('admin.ungtuyen.index', compact('ungViens'));
    }


    // Client Application
    public function store(Request $request)
    {
            // Validate dữ liệu form
            $validated = $request->validate([
                'ten_ung_vien' => 'required|string|max:255',
                'email' => 'required|email',
                'so_dien_thoai' => 'required|string|max:20',
                'kinh_nghiem' => 'nullable|string|max:50',
                'ky_nang' => 'nullable|string|max:255',
                'thu_gioi_thieu' => 'nullable|string|max:1000',
                'tai_cv' => 'required|mimes:pdf,doc,docx|max:2048', // 2MB
                'tin_tuyen_dung_id' => 'required|exists:tin_tuyen_dung,id',
            ], [
                'ten_ung_vien.required' => 'Tên ứng viên là bắt buộc.',
                'ten_ung_vien.max' => 'Tên ứng viên không được vượt quá 255 ký tự.',
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không đúng định dạng.',
                'so_dien_thoai.required' => 'Số điện thoại là bắt buộc.',
                'so_dien_thoai.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
                'tai_cv.required' => 'File CV là bắt buộc.',
                'tai_cv.mimes' => 'File CV phải là định dạng pdf, doc hoặc docx.',
                'tai_cv.max' => 'File CV không được vượt quá 2MB.',
                'tin_tuyen_dung_id.required' => 'Tin tuyển dụng là bắt buộc.',
                'tin_tuyen_dung_id.exists' => 'Tin tuyển dụng không tồn tại.',
                'kinh_nghiem.max' => 'Kinh nghiệm không được vượt quá 50 ký tự.',
                'ky_nang.max' => 'Kỹ năng không được vượt quá 255 ký tự.',
                'thu_gioi_thieu.max' => 'Thư giới thiệu không được vượt quá 1000 ký tự.',
            ]);

            // Lưu file CV
            if ($request->hasFile('tai_cv')) {
                $cvPath = $request->file('tai_cv')->store('applications/tai_cv', 'public');
                $validated['tai_cv'] = $cvPath;
            }

            // Tạo đơn ứng tuyển
            $application = UngTuyen::create($validated);
            
            echo "<script>alert('Đăng ký ứng tuyển thành công!'); window.location.href = '/homepage/job';</script>";
    }

    // Admin xóa đơn ứng tuyển
    public function destroy($id) {
        $ungVien = UngTuyen::findOrFail($id)->delete();
        return redirect('/ungvien')->with('success', 'Đơn ứng tuyển đã được xóa thành công!');
    }

    public function show($id) {
        $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);
        return view('admin.ungtuyen.show', compact('ungVien'));
    }
}
