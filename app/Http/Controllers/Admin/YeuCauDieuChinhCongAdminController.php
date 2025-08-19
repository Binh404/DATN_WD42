<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BangLuong;
use App\Models\ChamCong;
use App\Models\Luong;
use App\Models\PhongBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\YeuCauDieuChinhCong;
use App\Models\NguoiDung;

class YeuCauDieuChinhCongAdminController extends Controller
{
    /**
     * Hiển thị danh sách tất cả yêu cầu điều chỉnh công
     */
    public function index(Request $request)
    {
        $query = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet','nguoiDung.hoSo', 'nguoiDung.phongBan']);

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Lọc theo phòng ban
        if ($request->filled('phong_ban_id')) {
            $query->whereHas('nguoiDung', function ($q) use ($request) {
                $q->where('phong_ban_id', $request->get('phong_ban_id'));
            });
        }

        // Lọc theo ngày
        if ($request->filled('tu_ngay')) {
            $query->where('ngay', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->where('ngay', '<=', $request->den_ngay);
        }

        // Tìm kiếm theo tên nhân viên
        if ($request->filled('tim_kiem')) {
            $tenNhanVien = $request->get('tim_kiem');
            $query->whereHas('nguoiDung.hoSo', function ($q) use ($tenNhanVien) {
                $q->where('ho', 'LIKE', "%{$tenNhanVien}%")
                    ->orWhere('ten', 'LIKE', "%{$tenNhanVien}%")
                    ->orWhereRaw("CONCAT(ho, ' ', ten) LIKE ?", ["%{$tenNhanVien}%"]);
            });
        }

        $yeuCauList = $query->orderBy('created_at', 'desc')->paginate(15);

        // Thống kê tổng quan
        $thongKe = [
            'tong_so' => YeuCauDieuChinhCong::count(),
            'cho_duyet' => YeuCauDieuChinhCong::where('trang_thai', 'cho_duyet')->count(),
            'da_duyet' => YeuCauDieuChinhCong::where('trang_thai', 'da_duyet')->count(),
            'tu_choi' => YeuCauDieuChinhCong::where('trang_thai', 'tu_choi')->count(),
        ];

        // Danh sách phòng ban để filter
        $phongBanList = PhongBan::orderBy('ten_phong_ban')->get();

        return view('admin.yeu-cau-dieu-chinh-cong.index', [
            'yeuCauList' => $yeuCauList,
            'thongKe' => $thongKe,
            'phongBanList' => $phongBanList,
            'filters' => $request->all()
        ]);
    }

    /**
     * Hiển thị chi tiết yêu cầu
     */
    public function show($id)
    {
        $yeuCau = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet','nguoiDung.hoSo', 'nguoiDung.phongBan'])
            ->findOrFail($id);

        return view('admin.yeu-cau-dieu-chinh-cong.show', [
            'yeuCau' => $yeuCau
        ]);
    }

    /**
     * Duyệt yêu cầu điều chỉnh công
     */
    public function duyet(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'hanh_dong' => 'required|in:duyet,tu_choi',
            'ghi_chu_duyet' => 'nullable|string|max:1000'
        ], [
            'hanh_dong.required' => 'Vui lòng chọn hành động',
            'hanh_dong.in' => 'Hành động không hợp lệ',
            'ghi_chu_duyet.max' => 'Ghi chú không được vượt quá 1000 ký tự'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $yeuCau = YeuCauDieuChinhCong::where('trang_thai', 'cho_duyet')
            ->findOrFail($id);
        $chamCong = ChamCong::where('nguoi_dung_id', $yeuCau->nguoi_dung_id)
            ->where('ngay_cham_cong', $yeuCau->ngay)
            ->first();
            // dd($yeuCau->gio_ra->format('H:i:s'));
        // DB::beginTransaction();

        try {
            $trangThaiMoi = $request->hanh_dong === 'duyet' ? 'da_duyet' : 'tu_choi';
            if ($trangThaiMoi === 'da_duyet') {
                // Lấy tháng/năm từ ngày yêu cầu
                $thang = \Carbon\Carbon::parse($yeuCau->ngay)->month;
                $nam   = \Carbon\Carbon::parse($yeuCau->ngay)->year;

                // Kiểm tra đã chốt lương chưa
                $daChotLuong = BangLuong::where('nguoi_xu_ly_id', $yeuCau->nguoi_dung_id)
                    ->where('thang', $thang)
                    ->where('nam', $nam)
                    ->first();
                // dd($thang, $nam, $daChotLuong);
                if ($daChotLuong) {
                    $nguoiChot = $daChotLuong->nguoiXuLy; // Giả sử BangLuong có quan hệ với User là nguoiXuLy
                    $email = $nguoiChot ? $nguoiChot->email : 'không xác định';
                    // dd(session()->all());
                    return redirect()->route('admin.yeu-cau-dieu-chinh-cong.index')->withErrors([   'error' => 'Nhân viên ' . $email . ' - Tháng ' . $thang . '/' . $nam . ' đã được chốt lương, không thể phê duyệt. Vui lòng từ chối yêu cầu.']);
                }

                if ($chamCong) {
                    // Nếu đã có thì cập nhật
                    $chamCong->update([
                        'gio_vao'  => $yeuCau->gio_vao,
                        'gio_ra'   => $yeuCau->gio_ra,
                        'ghi_chu'  => $yeuCau->ly_do, // có thể thay bằng trường khác nếu bạn muốn
                        'trang_thai_duyet' => 1
                    ]);
                } else {
                    // Nếu chưa có thì tạo mới
                    $chamCong = ChamCong::create([
                        'nguoi_dung_id'  => $yeuCau->nguoi_dung_id,
                        'ngay_cham_cong' => $yeuCau->ngay,
                        'gio_vao'        => $yeuCau->gio_vao,
                        'gio_ra'         => $yeuCau->gio_ra,
                        'ghi_chu'        => $yeuCau->ly_do,
                        'trang_thai_duyet' => 1

                    ]);
                }

                // Sau đó chắc chắn $chamCong đã tồn tại
                $chamCong->capNhatTrangThai();
                $chamCong->save();
                // dd($chamCong);
            }

            $yeuCau->update([
                'trang_thai' => $trangThaiMoi,
                'duyet_boi' => Auth::id(),
                'duyet_vao' => Carbon::now(),
                'ghi_chu_duyet' => $request->ghi_chu_duyet
            ]);

            // DB::commit();

            $thongBao = $request->hanh_dong === 'duyet'
                ? 'Đã duyệt yêu cầu thành công!'
                : 'Đã từ chối yêu cầu thành công!';

            return redirect()->route('admin.yeu-cau-dieu-chinh-cong.index')
                ->with('success', $thongBao);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
    }

    /**
     * Duyệt hàng loạt
     */
    public function duyetHangLoat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yeu_cau_ids' => 'required|array|min:1',
            'yeu_cau_ids.*' => 'exists:yeu_cau_dieu_chinh_cong,id',
            'hanh_dong' => 'required|in:duyet,tu_choi',
            'ghi_chu_duyet' => 'nullable|string|max:1000'
        ], [
            'yeu_cau_ids.required' => 'Vui lòng chọn ít nhất một yêu cầu',
            'yeu_cau_ids.min' => 'Vui lòng chọn ít nhất một yêu cầu',
            'hanh_dong.required' => 'Vui lòng chọn hành động',
            'hanh_dong.in' => 'Hành động không hợp lệ',
            'ghi_chu_duyet.max' => 'Ghi chú không được vượt quá 1000 ký tự'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // DB::beginTransaction();

        try {
            $trangThaiMoi = $request->hanh_dong === 'duyet' ? 'da_duyet' : 'tu_choi';
              // Lấy danh sách yêu cầu cần duyệt
            $dsYeuCau = YeuCauDieuChinhCong::whereIn('id', $request->yeu_cau_ids)
                ->where('trang_thai', 'cho_duyet')
                ->get();
             $soLuongCapNhat = 0;

            foreach ($dsYeuCau as $yeuCau) {
                $yeuCau->update([
                    'trang_thai'    => $trangThaiMoi,
                    'duyet_boi'     => Auth::id(),
                    'duyet_vao'     => Carbon::now(),
                    'ghi_chu_duyet' => $request->ghi_chu_duyet
                ]);

                if ($trangThaiMoi === 'da_duyet') {
                    // Lấy tháng/năm từ ngày yêu cầu
                    $thang = \Carbon\Carbon::parse($yeuCau->ngay)->month;
                    $nam   = \Carbon\Carbon::parse($yeuCau->ngay)->year;

                    // Kiểm tra đã chốt lương chưa
                    $daChotLuong = BangLuong::where('nguoi_xu_ly_id', $yeuCau->nguoi_dung_id)
                        ->where('thang', $thang)
                        ->where('nam', $nam)
                        ->first();
                    // dd($thang, $nam, $daChotLuong);
                    if ($daChotLuong) {
                        $nguoiChot = $daChotLuong->nguoiXuLy; // Giả sử BangLuong có quan hệ với User là nguoiXuLy
                        $email = $nguoiChot ? $nguoiChot->email : 'không xác định';
                        // dd(session()->all());
                        return redirect()->route('admin.yeu-cau-dieu-chinh-cong.index')->withErrors([   'error' => 'Nhân viên ' . $email . ' - Tháng ' . $thang . '/' . $nam . ' đã được chốt lương, không thể phê duyệt. Vui lòng từ chối yêu cầu.']);
                    }
                    // tìm chấm công cùng ngày + user
                    $chamCong = ChamCong::where('nguoi_dung_id', $yeuCau->nguoi_dung_id)
                        ->where('ngay_cham_cong', $yeuCau->ngay)
                        ->first();

                    if ($chamCong) {
                        // Cập nhật
                        $chamCong->update([
                            'gio_vao'        => $yeuCau->gio_vao,
                            'gio_ra'         => $yeuCau->gio_ra,
                            'ghi_chu'        => $yeuCau->ly_do,
                            'trang_thai_duyet' => 1
                        ]);
                    } else {
                        // Tạo mới
                        $chamCong = ChamCong::create([
                            'nguoi_dung_id'   => $yeuCau->nguoi_dung_id,
                            'ngay_cham_cong'  => $yeuCau->ngay,
                            'gio_vao'         => $yeuCau->gio_vao,
                            'gio_ra'          => $yeuCau->gio_ra,
                            'ghi_chu'         => $yeuCau->ly_do,
                            'trang_thai_duyet'=> 1
                        ]);
                    }

                    // chắc chắn cập nhật trạng thái hợp lệ
                    $chamCong->capNhatTrangThai();
                    $chamCong->save();
                }

                $soLuongCapNhat++;
            }

            // DB::commit();

            $thongBao = $request->hanh_dong === 'duyet'
                ? "Đã duyệt {$soLuongCapNhat} yêu cầu thành công!"
                : "Đã từ chối {$soLuongCapNhat} yêu cầu thành công!";

            return redirect()->back()->with('success', $thongBao);

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
    }

    /**
     * Download file đính kèm
     */
    public function downloadFile($id)
    {
        $yeuCau = YeuCauDieuChinhCong::findOrFail($id);

        if (!$yeuCau->tep_dinh_kem || !Storage::disk('public')->exists($yeuCau->tep_dinh_kem)) {
            abort(404, 'File không tồn tại');
        }

        $filePath = Storage::disk('public')->path($yeuCau->tep_dinh_kem);
        $fileName = basename($yeuCau->tep_dinh_kem);

        return response()->download($filePath, $fileName);
    }

    /**
     * Xóa yêu cầu (chỉ admin mới được xóa)
     */
    public function destroy($id)
    {
        $yeuCau = YeuCauDieuChinhCong::findOrFail($id);

        DB::beginTransaction();

        try {
            // Xóa file đính kèm nếu có
            if ($yeuCau->tep_dinh_kem) {
                Storage::disk('public')->delete($yeuCau->tep_dinh_kem);
            }

            $yeuCau->delete();

            DB::commit();

            return redirect()->route('admin.yeu-cau-dieu-chinh-cong.index')
                ->with('success', 'Xóa yêu cầu thành công!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra, vui lòng thử lại']);
        }
    }

    /**
     * Báo cáo thống kê
     */
    public function baoCao(Request $request)
    {
        $tuNgay = $request->input('tu_ngay', Carbon::now()->subMonth()->format('Y-m-d'));
        $denNgay = $request->input('den_ngay', Carbon::now()->format('Y-m-d'));
        // dd($tuNgay, $denNgay);
        // Thống kê theo trạng thái
        $thongKeTheoTrangThai = YeuCauDieuChinhCong::whereBetween('ngay', [$tuNgay, $denNgay])
            ->selectRaw('trang_thai, COUNT(*) as so_luong')
            ->groupBy('trang_thai')
            ->pluck('so_luong', 'trang_thai')
            ->toArray();

        // Thống kê theo phòng ban
        $thongKeTheoPhongBan = YeuCauDieuChinhCong::with('nguoiDung.phongBan')
        ->whereBetween('ngay', [$tuNgay, $denNgay])
        ->get()
        ->groupBy(function ($item) {
            return optional($item->nguoiDung->phongBan)->ten_phong_ban ?? 'Chưa có phòng ban';
        })
        ->map(function ($items) {
            return [
                'tong_so'   => $items->count(),
                'cho_duyet' => $items->where('trang_thai', 'cho_duyet')->count(),
                'da_duyet'  => $items->where('trang_thai', 'da_duyet')->count(),
                'tu_choi'   => $items->where('trang_thai', 'tu_choi')->count(),
            ];
        });
        // dd($thongKeTheoPhongBan);

        // Thống kê theo tháng
        $thongKeTheoThang = YeuCauDieuChinhCong::whereBetween('ngay', [$tuNgay, $denNgay])
            ->selectRaw('DATE_FORMAT(ngay, "%Y-%m") as thang, COUNT(*) as so_luong, trang_thai')
            ->groupBy('thang', 'trang_thai')
            ->orderBy('thang')
            ->get()
            ->groupBy('thang')
            ->map(function ($items) {
                return [
                    'tong_so' => $items->sum('so_luong'),
                    'cho_duyet' => $items->where('trang_thai', 'cho_duyet')->sum('so_luong'),
                    'da_duyet' => $items->where('trang_thai', 'da_duyet')->sum('so_luong'),
                    'tu_choi' => $items->where('trang_thai', 'tu_choi')->sum('so_luong'),
                ];
            });

        // Top nhân viên có nhiều yêu cầu nhất
        $topNhanVien = YeuCauDieuChinhCong::with('nguoiDung.phongBan','nguoiDung','nguoiDung.hoSo')
            ->whereBetween('ngay', [$tuNgay, $denNgay])
            ->selectRaw('nguoi_dung_id, COUNT(*) as so_luong')
            ->groupBy('nguoi_dung_id')
            ->orderByDesc('so_luong')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'ho_ten' => $item->nguoiDung->hoSo->ho . ' ' . $item->nguoiDung->hoSo->ten,
                    'ma_nhan_vien' => $item->nguoiDung->hoSo->ma_nhan_vien,
                    'phong_ban' => $item->nguoiDung->phongBan->ten_phong_ban,
                    'so_luong' => $item->so_luong
                ];
            });

        return view('admin.yeu-cau-dieu-chinh-cong.baocao', [
            'thongKeTheoTrangThai' => $thongKeTheoTrangThai,
            'thongKeTheoPhongBan' => $thongKeTheoPhongBan,
            'thongKeTheoThang' => $thongKeTheoThang,
            'topNhanVien' => $topNhanVien,
            'tuNgay' => $tuNgay,
            'denNgay' => $denNgay
        ]);
    }

    /**
     * Export báo cáo Excel
     */
    public function exportBaoCao(Request $request)
    {
        $tuNgay = $request->input('tu_ngay', Carbon::now()->subMonth()->format('Y-m-d'));
        $denNgay = $request->input('den_ngay', Carbon::now()->format('Y-m-d'));

        $yeuCauList = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet'])
            ->whereBetween('created_at', [$tuNgay, $denNgay])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tạo dữ liệu cho Excel
        $data = $yeuCauList->map(function ($yeuCau) {
            return [
                'ID' => $yeuCau->id,
                'Nhân viên' => $yeuCau->nguoiDung->ho_ten,
                'Mã NV' => $yeuCau->nguoiDung->ma_nhan_vien,
                'Phòng ban' => $yeuCau->nguoiDung->phong_ban,
                'Ngày điều chỉnh' => $yeuCau->ngay,
                'Giờ vào' => $yeuCau->gio_vao,
                'Giờ ra' => $yeuCau->gio_ra,
                'Lý do' => $yeuCau->ly_do,
                'Trạng thái' => $yeuCau->trang_thai,
                'Người duyệt' => $yeuCau->nguoiDuyet->ho_ten ?? '',
                'Ngày duyệt' => $yeuCau->duyet_vao ? $yeuCau->duyet_vao->format('Y-m-d H:i:s') : '',
                'Ghi chú duyệt' => $yeuCau->ghi_chu_duyet,
                'Ngày tạo' => $yeuCau->created_at->format('Y-m-d H:i:s')
            ];
        })->toArray();

        // Sử dụng library export Excel (VD: Maatwebsite/Excel)
        // return Excel::download(new YeuCauDieuChinhCongExport($data), 'bao-cao-yeu-cau-dieu-chinh-cong.xlsx');

        // Tạm thời return JSON cho demo
        return response()->json([
            'message' => 'Export thành công',
            'data' => $data,
            'count' => count($data)
        ]);
    }

    /**
     * Lấy dữ liệu JSON cho Ajax
     */
    public function getAjaxData(Request $request)
    {
        $query = YeuCauDieuChinhCong::with(['nguoiDung', 'nguoiDuyet']);

        // Áp dụng các filter
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('phong_ban')) {
            $query->whereHas('nguoiDung', function($q) use ($request) {
                $q->where('phong_ban', $request->phong_ban);
            });
        }

        if ($request->filled('tu_ngay')) {
            $query->where('ngay', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->where('ngay', '<=', $request->den_ngay);
        }

        if ($request->filled('tim_kiem')) {
            $query->whereHas('nguoiDung', function($q) use ($request) {
                $q->where('ho_ten', 'like', '%' . $request->tim_kiem . '%')
                  ->orWhere('ma_nhan_vien', 'like', '%' . $request->tim_kiem . '%');
            });
        }

        $yeuCauList = $query->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($yeuCau) {
                return [
                    'id' => $yeuCau->id,
                    'nguoi_dung' => [
                        'ho_ten' => $yeuCau->nguoiDung->ho_ten,
                        'ma_nhan_vien' => $yeuCau->nguoiDung->ma_nhan_vien,
                        'phong_ban' => $yeuCau->nguoiDung->phong_ban,
                    ],
                    'ngay' => $yeuCau->ngay,
                    'gio_vao' => $yeuCau->gio_vao,
                    'gio_ra' => $yeuCau->gio_ra,
                    'ly_do' => $yeuCau->ly_do,
                    'tep_dinh_kem' => $yeuCau->tep_dinh_kem ? basename($yeuCau->tep_dinh_kem) : null,
                    'trang_thai' => $yeuCau->trang_thai,
                    'nguoi_duyet' => $yeuCau->nguoiDuyet->ho_ten ?? null,
                    'duyet_vao' => $yeuCau->duyet_vao ? $yeuCau->duyet_vao->format('Y-m-d H:i:s') : null,
                    'ghi_chu_duyet' => $yeuCau->ghi_chu_duyet,
                    'created_at' => $yeuCau->created_at->format('Y-m-d H:i:s'),
                    'can_approve' => $yeuCau->trang_thai === 'cho_duyet'
                ];
            });

        return response()->json([
            'yeuCauList' => $yeuCauList,
            'total' => $yeuCauList->count()
        ]);
    }
}
