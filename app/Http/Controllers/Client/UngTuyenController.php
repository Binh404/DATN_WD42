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
    public function index(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with('tinTuyenDung')->orderBy('id', 'desc');
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

        // Calculate matching score for each candidate
        foreach ($ungViens as $ungVien) {
            $ungVien->matching_score = $ungVien->calculateMatchingPercentage();
        }

        // Sort by matching score if requested
        if ($request->filled('sort_by_score')) {
            $ungViens = $ungViens->sortByDesc('matching_score');
        }

        return view('admin.ungtuyen.index', compact('ungViens', 'viTriList'));
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

        // Kiểm tra email đã ứng tuyển vào tin này chưa
        $kiemtra = UngTuyen::where('email', $request->email)
            ->where('tin_tuyen_dung_id', $request->tin_tuyen_dung_id)->first();

        if ($kiemtra) {
            return back()->withErrors(['email' => 'Bạn đã ứng tuyển vị trí này rồi.'])->withInput();
        }

        // Lưu file CV
        if ($request->hasFile('tai_cv')) {
            $cvPath = $request->file('tai_cv')->store('applications/tai_cv', 'public');
            $validated['tai_cv'] = $cvPath;
        }

        // Sinh mã ứng tuyển tự động
        $maUngTuyen = UngTuyen::max('id') ?? 0;
        $validated['ma_ung_tuyen'] = 'UT' . str_pad($maUngTuyen + 1, 5, '0', STR_PAD_LEFT);

        // Tạo đơn ứng tuyển
        $application = UngTuyen::create($validated);

        echo "<script>alert('Đăng ký ứng tuyển thành công!'); window.location.href = '/homepage/job';</script>";
    }

    // Admin xóa đơn ứng tuyển
    public function destroy($id)
    {
        $ungVien = UngTuyen::findOrFail($id)->delete();
        return redirect('/ungvien')->with('success', 'Đơn ứng tuyển đã được xóa thành công!');
    }

    public function show($id)
    {
        $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);
        $matchingPercentage = $ungVien->calculateMatchingPercentage();

        // Get matching details
        $matchingDetails = [
            'skills' => [
                'candidate' => array_map('trim', explode(',', strtolower($ungVien->ky_nang))),
                'required' => array_map('strtolower', $ungVien->tinTuyenDung->ky_nang_yeu_cau)
            ],
            'experience' => [
                'candidate' => (int) filter_var($ungVien->kinh_nghiem, FILTER_SANITIZE_NUMBER_INT),
                'required' => [
                    'min' => $ungVien->tinTuyenDung->kinh_nghiem_toi_thieu,
                    'max' => $ungVien->tinTuyenDung->kinh_nghiem_toi_da
                ]
            ]
        ];

        return view('admin.ungtuyen.show', compact('ungVien', 'matchingPercentage', 'matchingDetails'));
    }
}
