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
        
        // Sort by diem_danh_gia if requested
        if ($request->filled('sort_by_score')) {
            $ungVienQuery->orderBy('diem_danh_gia', 'desc');
        }
        
        $ungViens = $ungVienQuery->get();
        
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
    public function destroy($id)
    {
        $ungVien = UngTuyen::findOrFail($id)->delete();
        return redirect('/ungvien')->with('success', 'Đơn ứng tuyển đã được xóa thành công!');
    }

    public function show($id)
    {
        $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);
        
        try {
            // Tính điểm matching dựa trên hàm có sẵn
            $diemDanhGia = $ungVien->tinhDiemDanhGia();
            
            // Debug thông tin
            \Log::info('Tính điểm ứng viên:', [
                'id' => $ungVien->id,
                'ky_nang' => $ungVien->ky_nang,
                'kinh_nghiem' => $ungVien->kinh_nghiem,
                'thu_gioi_thieu' => $ungVien->thu_gioi_thieu,
                'diem_danh_gia' => $diemDanhGia
            ]);

            // Lưu điểm vào database
            $ungVien->update([
                'diem_danh_gia' => $diemDanhGia
            ]);

            \Log::info('Đã lưu điểm thành công');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi lưu điểm:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

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
        
        return view('admin.ungtuyen.show', compact('ungVien', 'matchingDetails'));
    }

    public function luuDiemDanhGia(Request $request, $id)
    {
        $request->validate([
            'diem_phong_van' => 'required|numeric|min:0|max:10',
            'ghi_chu_phong_van' => 'nullable|string|max:1000'
        ]);

        $ungVien = UngTuyen::findOrFail($id);
        
        $ungVien->update([
            'diem_phong_van' => $request->diem_phong_van,
            'ghi_chu_phong_van' => $request->ghi_chu_phong_van,
            'nguoi_cap_nhat_cuoi_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Đã lưu điểm đánh giá thành công');
    }

    public function danhSachTiemNang(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with(['tinTuyenDung', 'nguoiCapNhatTrangThai'])
            ->whereIn('trang_thai', ['cho_xu_ly', 'tu_choi'])
            ->where('diem_danh_gia', '>=', 70)
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

        if ($request->filled('trang_thai')) {
            $ungVienQuery->where('trang_thai', $request->trang_thai);
        }
        
        $ungViens = $ungVienQuery->get();
        
        return view('admin.ungtuyen.tiem-nang', compact('ungViens', 'viTriList'));
    }

    public function pheDuyet(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:ung_tuyen,id',
            'trang_thai' => 'required|in:phe_duyet,tu_choi',
            'ly_do' => 'required|string|max:1000'
        ], [
            'selected_ids.required' => 'Vui lòng chọn ít nhất một ứng viên',
            'selected_ids.*.exists' => 'Ứng viên không tồn tại',
            'trang_thai.required' => 'Vui lòng chọn trạng thái',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
            'ly_do.required' => 'Vui lòng nhập lý do',
            'ly_do.max' => 'Lý do không được vượt quá 1000 ký tự'
        ]);

        try {
            UngTuyen::whereIn('id', $request->selected_ids)
                ->update([
                    'trang_thai' => $request->trang_thai,
                    'ly_do' => $request->ly_do,
                    'nguoi_cap_nhat_id' => auth()->id(),
                    'ngay_cap_nhat' => now()
                ]);

            return redirect()->route('ungvien.tiem-nang')
                ->with('success', 'Cập nhật trạng thái thành công');
        } catch (\Exception $e) {
            return redirect()->route('ungvien.tiem-nang')
                ->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
        }
    }

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
        
        $ungViens = $ungVienQuery->get()->map(function($uv) {
            // Nếu trang_thai_pv là null, set là 0 (chưa phỏng vấn)
            if ($uv->trang_thai_pv === null) {
                $uv->update(['trang_thai_pv' => 0]);
            }
            return $uv;
        });
        
        return view('admin.ungtuyen.phong-van', compact('ungViens', 'viTriList'));
    }

    public function capNhatDiemPhongVan(Request $request, $id)
    {
        $rules = [
            'trang_thai_pv' => 'required|in:đã phỏng vấn,pass,fail',
            'ghi_chu_phong_van' => 'nullable|string'
        ];

        // Chỉ validate điểm khi trạng thái là "đã phỏng vấn"
        if ($request->trang_thai_pv === 'đã phỏng vấn') {
            $rules['diem_phong_van'] = 'required|numeric|min:0|max:10';
        }

        $request->validate($rules);

        $data = [
            'trang_thai_pv' => $request->trang_thai_pv,
            'ghi_chu_phong_van' => $request->ghi_chu_phong_van
        ];

        // Chỉ cập nhật điểm khi trạng thái là "đã phỏng vấn"
        if ($request->trang_thai_pv === 'đã phỏng vấn') {
            $data['diem_phong_van'] = $request->diem_phong_van;
        } else {
            $data['diem_phong_van'] = null; // Reset điểm về null khi chuyển sang trạng thái khác
        }

        $ungVien = UngTuyen::findOrFail($id);
        $ungVien->update($data);

        return redirect()->back()->with('success', 'Đã cập nhật thông tin phỏng vấn thành công!');
    }
}
