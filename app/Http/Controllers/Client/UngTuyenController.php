<?php

namespace App\Http\Controllers\Client;

use App\Exports\TrungTuyenExport;
use App\Exports\UngTuyenExport;
use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Models\NguoiDungVaiTro;
use App\Models\TinTuyenDung;
use App\Models\UngTuyen;
use App\Models\UngVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\VaiTro;

class UngTuyenController extends Controller
{

    // Admin Ung Tuyen
    public function index(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with('tinTuyenDung');

        // Apply filters
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

        // Sort by score if requested
        if ($request->filled('sort_by_score')) {
            $ungVienQuery->orderBy('diem_danh_gia', 'desc');
        } else {
            $ungVienQuery->orderBy('id', 'desc');
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

    public function luuDiemDanhGia(Request $request, $id)
    {
        $request->validate([
            'diem_danh_gia' => 'required|numeric|min:0|max:100',
            'ghi_chu_danh_gia_cv' => 'nullable|string|max:1000'
        ]);

        $ungVien = UngTuyen::findOrFail($id);

        $ungVien->update([
            'diem_danh_gia' => $request->diem_danh_gia,
            'ghi_chu_danh_gia_cv' => $request->ghi_chu_danh_gia_cv,
        ]);

        return redirect('/ungvien')->with('success', 'Đã lưu điểm đánh giá thành công');
    }

    public function danhSachTiemNang(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with(['tinTuyenDung', 'nguoiCapNhatTrangThai'])
            ->whereIn('trang_thai', ['cho_xu_ly', 'tu_choi'])
            ->where('diem_danh_gia', '>=', 60)
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
                    'nguoi_cap_nhat_id' => Auth::id(),
                    'ngay_cap_nhat' => now()
                ]);

            if ($request->trang_thai === 'phe_duyet') {
                return redirect()->route('ungvien.phong-van')
                    ->with('success', 'Phê duyệt ứng viên thành công');
            }

            return redirect()->back()
                ->with('success', 'Cập nhật trạng thái thành công');
        } catch (\Exception $e) {
            return redirect()->back()
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

        $ungViens = $ungVienQuery->get()->map(function ($uv) {
            // Nếu trang_thai_pv là null, set là chưa phỏng vấn
            if ($uv->trang_thai_pv === null) {
                $uv->update(['trang_thai_pv' => 'Chưa phỏng vấn']);
            }
            return $uv;
        });

        return view('admin.ungtuyen.phong-van', compact('ungViens', 'viTriList'));
    }

    public function capNhatDiemPhongVan(Request $request, $id)
    {
        $rules = [
            'trang_thai_pv' => 'required|in:Chưa phỏng vấn,Đã phỏng vấn,Đạt,Khó',
            'ghi_chu' => 'nullable|string',
            'diem_phong_van' => 'required|nullable|numeric|min:0|max:10'
        ];

        // Yêu cầu điểm phỏng vấn khi trạng thái là đã phỏng vấn, đạt hoặc khó
        if (in_array($request->trang_thai_pv, ['Đã phỏng vấn', 'Đạt', 'Khó'])) {
            $rules['diem_phong_van'] = 'required|numeric|min:0|max:10';
        }

        $request->validate($rules);

        try {
            $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);

            $data = [
                'trang_thai_pv' => $request->trang_thai_pv,
                'ghi_chu' => $request->ghi_chu
            ];

            // Xử lý điểm phỏng vấn dựa trên trạng thái
            if (in_array($request->trang_thai_pv, ['Đã phỏng vấn', 'Đạt', 'Khó'])) {
                $data['diem_phong_van'] = $request->diem_phong_van;
            } else {
                $data['diem_phong_van'] = null;
            }

            // Nếu trạng thái là "Đạt", cập nhật thông tin phòng ban, chức vụ, vai trò từ tin tuyển dụng
            if ($request->trang_thai_pv === 'Đạt' && $ungVien->tinTuyenDung) {
                $tinTuyenDung = $ungVien->tinTuyenDung;

                if ($tinTuyenDung->phong_ban_id) {
                    $data['phong_ban_id'] = $tinTuyenDung->phong_ban_id;
                }

                if ($tinTuyenDung->chuc_vu_id) {
                    $data['chuc_vu_id'] = $tinTuyenDung->chuc_vu_id;
                }

                if ($tinTuyenDung->vai_tro_id) {
                    $data['vai_tro_id'] = $tinTuyenDung->vai_tro_id;
                }
            }

            // Log để debug
            Log::info('Dữ liệu cập nhật:', [
                'id' => $id,
                'data' => $data,
                'request_all' => $request->all()
            ]);

            $ungVien->update($data);

            return redirect()->back()->with('success', 'Đã cập nhật thông tin phỏng vấn thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật phỏng vấn: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin phỏng vấn: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);

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

        return view('admin.ungtuyen.show', compact('ungVien', 'matchingDetails'));
    }

    // Export danh sách ứng tuyển
    public function exportExcel()
    {
        return Excel::download(new UngTuyenExport, 'ung_tuyen.xlsx');
    }

    // Export danh sách trúng tuyển
    public function trungTuyenExport()
    {
        return Excel::download(new TrungTuyenExport, 'trung_tuyen.xlsx');
    }

    // Gửi email thông báo phỏng vấn
    public function guiemailAll(Request $request)
    {
        $request->validate([
            'dat_lich' => 'required|date|after:now'
        ], [
            'dat_lich.required' => 'Vui lòng chọn thời gian gửi email',
            'dat_lich.date' => 'Thời gian không hợp lệ',
            'dat_lich.after' => 'Thời gian gửi phải sau thời điểm hiện tại'
        ]);

        // Lọc các ứng viên chưa gửi email
        $ungviens = UngTuyen::where('trang_thai_email', 'chua_gui')->get();

        // Kiểm tra nếu không có ứng viên nào cần gửi
        if ($ungviens->isEmpty()) {
            return redirect('/ungvien/phong-van')->with('error', 'Không có ứng viên nào cần gửi email.');
        }

        // Cập nhật thời gian gửi cho tất cả ứng viên và gửi thông tin đến n8n
        foreach ($ungviens as $ungvien) {
            Http::withOptions(['verify' => false])->post('https://quocbinh1.app.n8n.cloud/webhook/send-email', [

                'email' => $ungvien->email,
                'name' => $ungvien->ten_ung_vien,
                'vi_tri' => $ungvien->tinTuyenDung->tieu_de,
                'lich' => $request->dat_lich
            ]);
            $ungvien->trang_thai_email = 'da_gui';
            $ungvien->save();
        }

        return redirect('/ungvien/phong-van')->with('success', 'Đã gửi email cho tất cả ứng viên.');
    }


    // Gửi email thông báo đi làm
    // public function guiEmailDiLam(Request $request)
    // {
    //     $request->validate([
    //         'dat_lich' => 'required|date|after:now'
    //     ], [
    //         'dat_lich.required' => 'Vui lòng chọn thời gian gửi email',
    //         'dat_lich.date' => 'Thời gian không hợp lệ',
    //         'dat_lich.after' => 'Thời gian gửi phải sau thời điểm hiện tại'
    //     ]);

    //     // Lọc các ứng viên chưa gửi email
    //     $ungviens = UngTuyen::with(['phongBan', 'chucVu', 'vaiTro', 'tinTuyenDung'])
    //         ->where('trang_thai_pv', 'Đạt')
    //         ->where('trang_thai_email_trungtuyen', 'chua_gui')->get();

    //     // Kiểm tra nếu không có ứng viên nào cần gửi
    //     if ($ungviens->isEmpty()) {
    //         return redirect('/ungvien/trung-tuyen')->with('error', 'Không có ứng viên nào cần gửi email.');
    //     }


    //     // Cập nhật thời gian gửi cho tất cả ứng viên và gửi thông tin đến n8n
    //     foreach ($ungviens as $ungvien) {
    //         // Cập nhật thông tin phòng ban, chức vụ, vai trò từ tin tuyển dụng nếu chưa có
    //         if (!$ungvien->phong_ban_id || !$ungvien->chuc_vu_id || !$ungvien->vai_tro_id) {
    //             $tinTuyenDung = $ungvien->tinTuyenDung;
    //             if ($tinTuyenDung) {
    //                 $updateData = [];

    //                 if (!$ungvien->phong_ban_id && $tinTuyenDung->phong_ban_id) {
    //                     $updateData['phong_ban_id'] = $tinTuyenDung->phong_ban_id;
    //                 }

    //                 if (!$ungvien->chuc_vu_id && $tinTuyenDung->chuc_vu_id) {
    //                     $updateData['chuc_vu_id'] = $tinTuyenDung->chuc_vu_id;
    //                 }

    //                 if (!$ungvien->vai_tro_id && $tinTuyenDung->vai_tro_id) {
    //                     $updateData['vai_tro_id'] = $tinTuyenDung->vai_tro_id;
    //                     Log::info('Cập nhật vai_tro_id từ tin tuyển dụng:', [
    //                         'tin_tuyen_dung_vai_tro_id' => $tinTuyenDung->vai_tro_id
    //                     ]);
    //                 }

    //                 if (!empty($updateData)) {
    //                     $ungvien->update($updateData);
    //                     // Reload relationships sau khi update
    //                     $ungvien->load(['phongBan', 'chucVu', 'vaiTro']);
    //                     Log::info('Đã cập nhật ứng viên từ tin tuyển dụng:', [
    //                         'update_data' => $updateData,
    //                         'sau_khi_update_vai_tro_id' => $ungvien->vai_tro_id
    //                     ]);
    //                 }
    //             }
    //         }

    //         // Tạo email và mật khẩu
    //         $emailPrefix = Str::slug($ungvien->ten_ung_vien, '');
    //         $maSo = substr($ungvien->ma_ung_tuyen, 2); // bỏ 'ut'
    //         $email = strtolower($emailPrefix . 'dv' . $maSo . '@gmail.com');
    //         $password = Str::random(10);
    //         $tenDangNhap = Str::slug($ungvien->ten_ung_vien);

    //         // Gửi thông tin đến webhook (bỏ qua lỗi nếu có)
    //         try {
    //             Http::withOptions(['verify' => false])->timeout(5)->post('https://nguyencong.app.n8n.cloud/webhook-test/email-di-lam', [
    //                 'ma_ung_vien' => $ungvien->ma_ung_tuyen,
    //                 'ten_dang_nhap' => $email,
    //                 'email' => $ungvien->email,
    //                 'name' => $ungvien->ten_ung_vien,
    //                 'vi_tri' => $ungvien->tinTuyenDung->tieu_de,
    //                 'lich' => $request->dat_lich,
    //                 'mat_khau' => $password
    //             ]);
    //         } catch (\Exception $e) {
    //             // Log lỗi nhưng không dừng quá trình
    //             Log::warning('Không thể gửi webhook đầu tiên: ' . $e->getMessage());
    //         }

    //         // Kiểm tra xem tài khoản đã tồn tại chưa
    //         $existingUser = NguoiDung::where('email', $email)->first();

    //         if ($existingUser) {
    //             // Nếu tài khoản đã tồn tại, sử dụng tài khoản cũ
    //             $nguoiDung = $existingUser;
    //             $password = 'Đã có tài khoản';

    //             // Cập nhật thông tin phòng ban, chức vụ nếu chưa có
    //             $updateData = [];
    //             if ($ungvien->phong_ban_id && !$existingUser->phong_ban_id) {
    //                 $updateData['phong_ban_id'] = $ungvien->phong_ban_id;
    //             }
    //             if ($ungvien->chuc_vu_id && !$existingUser->chuc_vu_id) {
    //                 $updateData['chuc_vu_id'] = $ungvien->chuc_vu_id;
    //             }
    //             if ($ungvien->vai_tro_id && !$existingUser->vai_tro_id) {
    //                 $updateData['vai_tro_id'] = $ungvien->vai_tro_id;
    //             }

    //             if (!empty($updateData)) {
    //                 $existingUser->update($updateData);
    //                 Log::info('Đã cập nhật thông tin người dùng hiện có:', [
    //                     'nguoi_dung_id' => $existingUser->id,
    //                     'email' => $existingUser->email,
    //                     'update_data' => $updateData
    //                 ]);
    //             }
    //         } else {
    //             // Tạo tài khoản nhân viên mới với đầy đủ thông tin
    //             $nguoiDungData = [
    //                 'ten_dang_nhap' => $tenDangNhap,
    //                 'email' => $email,
    //                 'password' => Hash::make($password),
    //             ];

    //             // Thêm thông tin phòng ban, chức vụ nếu có
    //             if ($ungvien->phong_ban_id) {
    //                 $nguoiDungData['phong_ban_id'] = $ungvien->phong_ban_id;
    //             }
    //             if ($ungvien->chuc_vu_id) {
    //                 $nguoiDungData['chuc_vu_id'] = $ungvien->chuc_vu_id;
    //             }
    //             if ($ungvien->vai_tro_id) {
    //                 $nguoiDungData['vai_tro_id'] = $ungvien->vai_tro_id;
    //                 Log::info('Thêm vai_tro_id vào dữ liệu tạo tài khoản:', [
    //                     'vai_tro_id' => $ungvien->vai_tro_id,
    //                     'nguoiDungData' => $nguoiDungData
    //                 ]);
    //             } else {
    //                 Log::info('Không có vai_tro_id để thêm:', [
    //                     'ungvien_vai_tro_id' => $ungvien->vai_tro_id
    //                 ]);
    //             }
    //             $nguoiDung = NguoiDung::create($nguoiDungData);

    //             Log::info('Đã tạo tài khoản mới với thông tin đầy đủ:', [
    //                 'nguoi_dung_id' => $nguoiDung->id,
    //                 'email' => $nguoiDung->email,
    //                 'ten_dang_nhap' => $nguoiDung->ten_dang_nhap,
    //                 'phong_ban_id' => $nguoiDung->phong_ban_id,
    //                 'chuc_vu_id' => $nguoiDung->chuc_vu_id,
    //                 'vai_tro_id' => $nguoiDung->vai_tro_id,
    //                 'create_data' => $nguoiDungData
    //             ]);
    //         }

    //         // Lấy thông tin phòng ban, chức vụ, vai trò
    //         $phongBan = $ungvien->phongBan->ten_phong_ban ?? 'Chưa rõ';
    //         $chucVu = $ungvien->chucVu->ten ?? 'Chưa rõ';
    //         $vaiTro = $ungvien->vaiTro->ten ?? 'Chưa rõ';

    //         // Log để debug
    //         Log::info('Thông tin ứng viên trúng tuyển:', [
    //             'ma_ung_vien' => $ungvien->ma_ung_tuyen,
    //             'ten_ung_vien' => $ungvien->ten_ung_vien,
    //             'phong_ban_id' => $ungvien->phong_ban_id,
    //             'chuc_vu_id' => $ungvien->chuc_vu_id,
    //             'vai_tro_id' => $ungvien->vai_tro_id,
    //             'phong_ban' => $phongBan,
    //             'chuc_vu' => $chucVu,
    //             'vai_tro' => $vaiTro,
    //             'existing_user' => $existingUser ? 'Có' : 'Không',
    //             'nguoi_dung_id' => $nguoiDung->id ?? null
    //         ]);


    //         // Gán vai trò cho người dùng (chỉ khi tạo tài khoản mới)
    //         if (!$existingUser && $ungvien->vai_tro_id) {
    //             // Kiểm tra xem vai trò đã được gán chưa
    //             $existingRole = NguoiDungVaiTro::where('nguoi_dung_id', $nguoiDung->id)
    //                 ->where('vai_tro_id', $ungvien->vai_tro_id)
    //                 ->first();

    //             if (!$existingRole) {
    //                 NguoiDungVaiTro::create([
    //                     'nguoi_dung_id' => $nguoiDung->id,
    //                     'vai_tro_id' => $ungvien->vai_tro_id,
    //                     'model_type' => NguoiDung::class,
    //                     'created_at' => now(),
    //                     'updated_at' => now()
    //                 ]);
    //             }
    //         }

    //         // Gửi thông tin đến webhook (bỏ qua lỗi nếu có)
    //         try {
    //             Http::timeout(5)->post('https://workflow.aichatbot360.io.vn/webhook-test/email-di-lam', [
    //                 'ma_ung_vien' => $ungvien->ma_ung_tuyen,
    //                 'ten_dang_nhap' => $email,
    //                 'email' => $ungvien->email,
    //                 'name' => $ungvien->ten_ung_vien,
    //                 'vi_tri' => $ungvien->tinTuyenDung->tieu_de,
    //                 'lich' => $request->dat_lich,
    //                 'mat_khau' => $password,
    //                 'phong_ban' => $phongBan,
    //                 'chuc_vu' => $chucVu,
    //                 'vai_tro' => $vaiTro,
    //             ]);
    //         } catch (\Exception $e) {
    //             // Log lỗi nhưng không dừng quá trình
    //             Log::warning('Không thể gửi webhook: ' . $e->getMessage());
    //         }

    //         $ungvien->trang_thai_email_trungtuyen = 'da_gui';
    //         $ungvien->save();
    //     }

    //     return redirect('/ungvien/trung-tuyen')->with('success', 'Đã gửi email cho tất cả ứng viên.');
    // }






    public function guiEmailDiLam(Request $request)
    {
        $request->validate([
            'dat_lich' => 'required|date|after:now'
        ], [
            'dat_lich.required' => 'Vui lòng chọn thời gian gửi email',
            'dat_lich.date' => 'Thời gian không hợp lệ',
            'dat_lich.after' => 'Thời gian gửi phải sau thời điểm hiện tại'
        ]);

        $ungviens = UngTuyen::with(['phongBan', 'chucVu', 'vaiTro', 'tinTuyenDung'])
            ->where('trang_thai_pv', 'Đạt')
            ->where('trang_thai_email_trungtuyen', 'chua_gui')
            ->get();

        if ($ungviens->isEmpty()) {
            return redirect('/ungvien/trung-tuyen')->with('error', 'Không có ứng viên nào cần gửi email.');
        }

        foreach ($ungviens as $ungvien) {
            $emailPrefix = Str::slug($ungvien->ten_ung_vien, '');
            $maSo = substr($ungvien->ma_ung_tuyen, 2);
            $email = strtolower($emailPrefix . 'dv' . $maSo . '@gmail.com');
            $password = Str::random(10);
            $tenDangNhap = Str::slug($ungvien->ten_ung_vien);

            $vaiTroId = $ungvien->vai_tro_id ?? optional($ungvien->tinTuyenDung)->vai_tro_id;
            $phongBanId = $ungvien->phong_ban_id ?? optional($ungvien->phongBan)->id;
            $chucVuId = $ungvien->chuc_vu_id ?? optional($ungvien->chucVu)->id;

            if ($vaiTroId && !NguoiDung::where('email', $email)->exists()) {
                Http::withOptions(['verify' => false])->post('https://nguyencong.app.n8n.cloud/webhook-test/email-di-lam', [
                    'ma_ung_vien' => $ungvien->ma_ung_tuyen,
                    'ten_dang_nhap' => $email,
                    'email' => $ungvien->email,
                    'name' => $ungvien->ten_ung_vien,
                    'vi_tri' => optional($ungvien->tinTuyenDung)->tieu_de,
                    'lich' => $request->dat_lich,
                    'mat_khau' => $password
                ]);

                $nguoiDung = NguoiDung::create([
                    'ten_dang_nhap' => $tenDangNhap,
                    'name' => $ungvien->ten_ung_vien,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'ma_ung_tuyen' => $ungvien->ma_ung_tuyen,
                    'vai_tro_id' => $vaiTroId,
                    'phong_ban_id' => $phongBanId,
                    'chuc_vu_id' => $chucVuId,
                ]);

                NguoiDungVaiTro::create([
                    'nguoi_dung_id' => $nguoiDung->id,
                    'vai_tro_id' => $vaiTroId,
                    'model_type' => NguoiDung::class,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $ungvien->update(['trang_thai_email_trungtuyen' => 'da_gui']);
            }
        }

        return redirect('/ungvien/trung-tuyen')->with('success', 'Đã gửi email cho tất cả ứng viên hợp lệ.');
    }




    // Method test đơn giản để kiểm tra vai_tro_id
    // public function testVaiTro($ungVienId)
    // {
    //     try {
    //         $ungvien = UngTuyen::with(['phongBan', 'chucVu', 'vaiTro', 'tinTuyenDung'])
    //             ->findOrFail($ungVienId);

    //         $tinTuyenDung = $ungvien->tinTuyenDung;

    //         return response()->json([
    //             'ungvien' => [
    //                 'id' => $ungvien->id,
    //                 'ma_ung_vien' => $ungvien->ma_ung_tuyen,
    //                 'ten_ung_vien' => $ungvien->ten_ung_vien,
    //                 'phong_ban_id' => $ungvien->phong_ban_id,
    //                 'chuc_vu_id' => $ungvien->chuc_vu_id,
    //                 'vai_tro_id' => $ungvien->vai_tro_id,
    //             ],
    //             'tin_tuyen_dung' => $tinTuyenDung ? [
    //                 'id' => $tinTuyenDung->id,
    //                 'tieu_de' => $tinTuyenDung->tieu_de,
    //                 'phong_ban_id' => $tinTuyenDung->phong_ban_id,
    //                 'chuc_vu_id' => $tinTuyenDung->chuc_vu_id,
    //                 'vai_tro_id' => $tinTuyenDung->vai_tro_id,
    //             ] : null,
    //             'relationships' => [
    //                 'phong_ban' => $ungvien->phongBan ? $ungvien->phongBan->ten_phong_ban : null,
    //                 'chuc_vu' => $ungvien->chucVu ? $ungvien->chucVu->ten : null,
    //                 'vai_tro' => $ungvien->vaiTro ? $ungvien->vaiTro->ten : null,
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Lỗi: ' . $e->getMessage()]);
    //     }
    // }

    public function danhSachLuuTru(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with(['tinTuyenDung', 'nguoiCapNhatTrangThai'])
            ->where(function ($query) {
                $query->where('trang_thai', 'tu_choi')
                    ->orWhere('trang_thai_pv', 'Khó');
            })
            ->orderBy('ngay_cap_nhat', 'desc');

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

        return view('admin.ungtuyen.luu-tru', compact('ungViens', 'viTriList'));
    }


    // Danh sách Email đã gửi đi phỏng vấn
    public function emailDaGui(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with('tinTuyenDung')
            ->where('trang_thai', 'phe_duyet')
            ->where('trang_thai_email', 'da_gui')
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

        $ungViens = $ungVienQuery->get()->map(function ($uv) {
            // Nếu trang_thai_pv là null, set là chưa phỏng vấn
            if ($uv->trang_thai_pv === null) {
                $uv->update(['trang_thai_pv' => 'Chưa phỏng vấn']);
            }
            return $uv;
        });

        return view('admin.ungtuyen.email_da_gui', compact('ungViens', 'viTriList'));
    }


    // Danh sách ứng viên trúng tuyển
    public function danhSachTrungTuyen(Request $request)
    {
        $viTriList = TinTuyenDung::pluck('tieu_de', 'id');
        $ungVienQuery = UngTuyen::with(['tinTuyenDung', 'phongBan', 'chucVu', 'vaiTro'])
            ->where('trang_thai_pv', 'Đạt');

        // Apply filters
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

        // Sort by score if requested
        if ($request->filled('sort_by_score')) {
            $ungVienQuery->orderBy('diem_danh_gia', 'desc');
        } else {
            $ungVienQuery->orderBy('id', 'desc');
        }

        $ungViens = $ungVienQuery->get();

        return view('admin.ungtuyen.trungtuyen', compact('ungViens', 'viTriList'));
    }

    // Method để cập nhật thông tin phòng ban, chức vụ, vai trò cho ứng viên trúng tuyển
    public function capNhatThongTinTrungTuyen($id)
    {
        try {
            $ungVien = UngTuyen::with('tinTuyenDung')->findOrFail($id);

            if ($ungVien->trang_thai_pv !== 'Đạt') {
                return redirect()->back()->with('error', 'Ứng viên chưa đạt phỏng vấn');
            }

            $tinTuyenDung = $ungVien->tinTuyenDung;
            if (!$tinTuyenDung) {
                return redirect()->back()->with('error', 'Không tìm thấy thông tin tin tuyển dụng');
            }

            $updateData = [];

            if ($tinTuyenDung->phong_ban_id) {
                $updateData['phong_ban_id'] = $tinTuyenDung->phong_ban_id;
            }

            if ($tinTuyenDung->chuc_vu_id) {
                $updateData['chuc_vu_id'] = $tinTuyenDung->chuc_vu_id;
            }

            if ($tinTuyenDung->vai_tro_id) {
                $updateData['vai_tro_id'] = $tinTuyenDung->vai_tro_id;
            }

            if (!empty($updateData)) {
                $ungVien->update($updateData);
                Log::info('Đã cập nhật thông tin trúng tuyển cho ứng viên:', [
                    'ma_ung_vien' => $ungVien->ma_ung_tuyen,
                    'ten_ung_vien' => $ungVien->ten_ung_vien,
                    'update_data' => $updateData
                ]);

                return redirect()->back()->with('success', 'Đã cập nhật thông tin phòng ban, chức vụ, vai trò thành công!');
            } else {
                return redirect()->back()->with('warning', 'Không có thông tin để cập nhật');
            }
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật thông tin trúng tuyển: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin: ' . $e->getMessage());
        }
    }
}
