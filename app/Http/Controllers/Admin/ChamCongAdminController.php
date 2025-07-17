<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ChamCongExport;
use App\Http\Controllers\Controller;
use App\Models\ChamCong;
use App\Models\NguoiDung;
use App\Models\PhongBan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ChamCongAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ChamCong::with(['nguoiDung.hoSo', 'nguoiDung.phongBan','nguoiDung.vaiTro']);

        // Tìm kiếm theo tên nhân viên
        if ($request->filled('ten_nhan_vien')) {
            $tenNhanVien = $request->get('ten_nhan_vien');
            $query->whereHas('nguoiDung.hoSo', function ($q) use ($tenNhanVien) {
                $q->where('ho', 'LIKE', "%{$tenNhanVien}%")
                    ->orWhere('ten', 'LIKE', "%{$tenNhanVien}%")
                    ->orWhereRaw("CONCAT(ho, ' ', ten) LIKE ?", ["%{$tenNhanVien}%"]);
            });
        }

        // Tìm kiếm theo phòng ban
        if ($request->filled('phong_ban_id')) {
            $query->whereHas('nguoiDung', function ($q) use ($request) {
                $q->where('phong_ban_id', $request->get('phong_ban_id'));
            });
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->get('trang_thai'));
        }
        // Tìm kiếm theo trạng thái
        if ($request->filled('trang_thai_duyet')) {
            $query->where('trang_thai_duyet', $request->get('trang_thai_duyet'));
        }

        // Tìm kiếm theo ngày cụ thể
        if ($request->filled('ngay_cham_cong')) {
            $query->where('ngay_cham_cong', $request->get('ngay_cham_cong'));
        }

        // Tìm kiếm theo khoảng thời gian
        if ($request->filled('tu_ngay')) {
            $query->where('ngay_cham_cong', '>=', $request->get('tu_ngay'));
        }

        if ($request->filled('den_ngay')) {
            $query->where('ngay_cham_cong', '<=', $request->get('den_ngay'));
        }

        // Tìm kiếm theo tháng và năm
        if ($request->filled('thang')) {
            $query->whereMonth('ngay_cham_cong', $request->get('thang'));
        }

        if ($request->filled('nam')) {
            $query->whereYear('ngay_cham_cong', $request->get('nam'));
        }

        // Tìm kiếm theo giờ vào
        if ($request->filled('gio_vao_tu')) {
            $query->whereTime('gio_vao', '>=', $request->get('gio_vao_tu'));
        }

        if ($request->filled('gio_vao_den')) {
            $query->whereTime('gio_vao', '<=', $request->get('gio_vao_den'));
        }


        $user = auth()->user();
        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin và HR xem tất cả dữ liệu, không giới hạn
        } else if ($user->coVaiTro('department')) {
            $phongBanId = $user->phong_ban_id;
            $userId = $user->id;

            // Lọc chỉ những người cùng phòng ban và không lấy user hiện tại
            $query->whereHas('nguoiDung', function ($q) use ($phongBanId, $userId) {
                $q->where('phong_ban_id', $phongBanId)
                ->where('id', '<>', $userId)
                ->whereHas('vaiTro', function ($qr) {
                    $qr->where('ten', '<>', 'department'); // loại trưởng phòng khác
                });;
            });
        } else {
            // Nếu không phải Admin, HR, department thì không có quyền xem
            abort(403, 'Bạn không có quyền truy cập.');
        }
        // Sắp xếp theo thời gian mới nhất
        $chamCong = $query->orderBy('ngay_cham_cong', 'desc')
            ->orderBy('gio_vao', 'desc')
            ->paginate(20)
            ->appends($request->all());

        // Lấy danh sách phòng ban để hiển thị trong dropdown
        $phongBan = PhongBan::orderBy('ten_phong_ban')->get();

        // Lấy các trạng thái để hiển thị trong dropdown
        $trangThaiList = [
            'binh_thuong' => 'Bình thường',
            'di_muon' => 'Đi muộn',
            've_som' => 'Về sớm',
            'vang_mat' => 'Vắng mặt',
            'nghi_phep' => 'Nghỉ phép'
        ];
        $trangThaiDuyetList = [
            3 => 'Chờ duyệt',
            0 => 'Chưa gửi lý do',
            1 => 'Đã duyệt',
            2 => 'Từ chối',
        ];

        // Thống kê tổng quan
        $donDuyet =( clone $query)->where('trang_thai_duyet', 3)->count();
        $tongSoBanGhi = ( clone $query)->count();
        $homNay = ( clone $query)->where('ngay_cham_cong', now()->format('Y-m-d'))->count();
        $soDungGio = ( clone $query)->where('trang_thai', 'binh_thuong')
            ->count();
            // dd($soDungGio);
        $tyLeDungGio = $tongSoBanGhi > 0 ? round(($soDungGio / $tongSoBanGhi) * 100, 2) : 0;
        // dd($soDungGio);
        return view('admin.cham-cong.quan_ly_cham_cong.index', compact(
            'chamCong',
            'phongBan',
            'trangThaiList',
            'tongSoBanGhi',
            'homNay',
            'tyLeDungGio',
            'donDuyet',
            'trangThaiDuyetList'
        ));
    }
    /**
     * Xuất dữ liệu chấm công theo yêu cầu
     */
    public function export(Request $request)
    {
        // dd($request->all());
        // Lấy dữ liệu theo điều kiện tìm kiếm
        $query = ChamCong::with(['nguoiDung.hoSo', 'nguoiDung.phongBan'])
            ->orderBy('ngay_cham_cong', 'desc');

        // Áp dụng các filter giống như trong index
        $this->applyFilters($query, $request);

        $chamCong = $query->get();
        // dd($chamCong);
        // Tạo tên file
        $fileName = 'cham-cong-' . date('Y-m-d-H-i-s');

        return Excel::download(new ChamCongExport($chamCong), $fileName . '.xlsx');
    }
    /**
     * Xuất báo cáo theo khoảng thời gian
     */
    public function exportReport(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel,pdf'
        ]);
        $query = ChamCong::with(['nguoiDung.hoSo', 'nguoiDung.phongBan'])
            ->whereBetween('ngay_cham_cong', [$request->start_date, $request->end_date])
            ->orderBy('ngay_cham_cong', 'desc');

        $chamCong = $query->get();
        // dd($chamCong);
        // Thống kê tổng hợp
        $statistics = $this->calculateStatistics($chamCong, $request->start_date, $request->end_date);

        $fileName = 'bao-cao-cham-cong-' .
                   Carbon::parse($request->start_date)->format('d-m-Y') . '-den-' .
                   Carbon::parse($request->end_date)->format('d-m-Y');

        if ($request->format === 'excel') {
            return Excel::download(
                new ChamCongExport($chamCong, $statistics),
                $fileName . '.xlsx'
            );
        } else {
            $pdf = Pdf::loadView('admin.cham-cong.report-pdf', compact('chamCong', 'statistics'))
                ->setPaper('a4', 'landscape');

            return $pdf->download($fileName . '.pdf');
        }
    }
    /**
     * Áp dụng các filter tìm kiếm
     */
    private function applyFilters($query, $request)
    {
        if ($request->filled('ten_nhan_vien')) {
            $query->whereHas('nguoiDung.hoSo', function ($q) use ($request) {
                $q->where('ho', 'like', '%' . $request->ten_nhan_vien . '%')
                  ->orWhere('ten', 'like', '%' . $request->ten_nhan_vien . '%');
            });
        }

        if ($request->filled('phong_ban_id')) {
            $query->whereHas('nguoiDung', function ($q) use ($request) {
                $q->where('phong_ban_id', $request->phong_ban_id);
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('ngay_cham_cong')) {
            $query->whereDate('ngay_cham_cong', $request->ngay_cham_cong);
        }

        if ($request->filled('tu_ngay')) {
            $query->whereDate('ngay_cham_cong', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->whereDate('ngay_cham_cong', '<=', $request->den_ngay);
        }

        if ($request->filled('thang') && $request->filled('nam')) {
            $query->whereMonth('ngay_cham_cong', $request->thang)
                  ->whereYear('ngay_cham_cong', $request->nam);
        } elseif ($request->filled('thang')) {
            $query->whereMonth('ngay_cham_cong', $request->thang);
        } elseif ($request->filled('nam')) {
            $query->whereYear('ngay_cham_cong', $request->nam);
        }
    }
    /**
     * Tính toán thống kê
     */
    private function calculateStatistics($chamCong, $startDate, $endDate)
    {
        return [
            'period' => [
                'start' => Carbon::parse($startDate)->format('d/m/Y'),
                'end' => Carbon::parse($endDate)->format('d/m/Y')
            ],
            'total_records' => $chamCong->count(),
            'total_employees' => $chamCong->pluck('nguoi_dung_id')->unique()->count(),
            'status_breakdown' => [
                'binh_thuong' => $chamCong->where('trang_thai', 'binh_thuong')->count(),
                'di_muon' => $chamCong->where('trang_thai', 'di_muon')->count(),
                've_som' => $chamCong->where('trang_thai', 've_som')->count(),
                'vang_mat' => $chamCong->where('trang_thai', 'vang_mat')->count(),
                'nghi_phep' => $chamCong->where('trang_thai', 'nghi_phep')->count(),
            ],
            'total_hours' => $chamCong->sum('so_gio_lam'),
            'total_workdays' => $chamCong->sum('so_cong'),
            'approval_status' => [
                'approved' => $chamCong->where('trang_thai_duyet', 1)->count(),
                'rejected' => $chamCong->where('trang_thai_duyet', 2)->count(),
                'pending' => $chamCong->where('trang_thai_duyet', 3)->count(),
            ]
        ];
    }


    /**
     * Bulk actions for multiple records
     */
    public function bulkAction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|json',
                'action' => 'required|in:1,2,delete',
                'reason' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ!'
                ], 400);
            }

            $ids = json_decode($request->ids, true);
            $action = $request->action;
            $reason = $request->reason;

            if (empty($ids) || !is_array($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có bản ghi nào được chọn!'
                ], 400);
            }

            DB::beginTransaction();

            if ($action === 'delete') {
                // Bulk delete
                $deletedCount = ChamCong::whereIn('id', $ids)->delete();
                $message = "Đã xóa {$deletedCount} bản ghi thành công!";
            } else {
                // Bulk approve/reject
                $updateData = [
                    'trang_thai_duyet' => (int) $action,
                    'thoi_gian_phe_duyet' => now(),
                    'nguoi_phe_duyet_id' => auth()->id()
                ];

                if ($action == 2 && $reason) {
                    $updateData['ghi_chu_duyet'] = $reason;
                }

                $updatedCount = ChamCong::whereIn('id', $ids)->update($updateData);

                $actionText = $action == 1 ? 'phê duyệt' : 'từ chối';
                $message = "Đã {$actionText} {$updatedCount} bản ghi thành công!";
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in PheDuyetController@bulkAction: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $nguoiDung = NguoiDung::with('hoSo')->orderBy('id')->get();
    //     return view('cham-cong.create', compact('nguoiDung'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
    //         'ngay_cham_cong' => 'required|date',
    //         'gio_vao' => 'nullable|date_format:H:i',
    //         'gio_ra' => 'nullable|date_format:H:i',
    //         'vi_tri_check_in' => 'nullable|string|max:255',
    //         'vi_tri_check_out' => 'nullable|string|max:255',
    //         'ghi_chu' => 'nullable|string',
    //     ]);

    //     // Kiểm tra đã chấm công trong ngày chưa
    //     $daChamCong = ChamCong::kiemTraDaChamCong(
    //         $validated['nguoi_dung_id'],
    //         $validated['ngay_cham_cong']
    //     );

    //     if ($daChamCong) {
    //         return back()->withErrors(['error' => 'Nhân viên đã chấm công trong ngày này!']);
    //     }

    //     // Tạo datetime từ ngày và giờ
    //     if ($validated['gio_vao']) {
    //         $validated['gio_vao'] = Carbon::parse($validated['ngay_cham_cong'] . ' ' . $validated['gio_vao']);
    //     }

    //     if ($validated['gio_ra']) {
    //         $validated['gio_ra'] = Carbon::parse($validated['ngay_cham_cong'] . ' ' . $validated['gio_ra']);
    //     }

    //     $validated['dia_chi_ip'] = $request->ip();

    //     $chamCong = ChamCong::create($validated);

    //     // Cập nhật trạng thái và tính toán số giờ làm
    //     $chamCong->capNhatTrangThai()->save();

    //     return redirect()->route('cham-cong.index')
    //                     ->with('success', 'Thêm bản ghi chấm công thành công!');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show($id)
    // {
    //     $chamCong = ChamCong::with(['nguoiDung', 'nguoiPheDuyet'])->findOrFail($id);
    //     $chamCong->load(['nguoiDung.hoSo', 'nguoiDung.phongBan', 'nguoiPheDuyet.hoSo']);
    //     // dd($chamCong->nguoiDung);
    //     return view('admin.cham-cong.quan_ly_cham_cong.show', compact('chamCong'));
    // }
    public function show($id)
    {
        $chamCong = ChamCong::with(['nguoiDung', 'nguoiPheDuyet'])->findOrFail($id);
        $chamCong->load(['nguoiDung.hoSo', 'nguoiDung.phongBan', 'nguoiPheDuyet.hoSo']);

        $user = auth()->user();

        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Trưởng phòng chỉ được xem nhân viên trong cùng phòng ban, không được xem chính mình hoặc trưởng phòng khác
            $target = $chamCong->nguoiDung;

            if (
                $target->phong_ban_id !== $user->phong_ban_id || // khác phòng
                $target->id === $user->id ||                     // chính họ
                $target->coVaiTro('department')                  // người cũng là trưởng phòng
            ) {
                abort(403, 'Bạn không có quyền xem bản ghi này.');
            }
        } else {
            abort(403, 'Bạn không có quyền xem bản ghi này.');
        }

        return view('admin.cham-cong.quan_ly_cham_cong.show', compact('chamCong'));
    }


    // /**
    //  * Show the form for editing the specified resource.
    //  */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $chamCong = ChamCong::with(['nguoiDung', 'nguoiPheDuyet'])->findOrFail($id);
        // dd($chamCong->gio_vao);
        // Lấy danh sách nhân viên với thông tin hồ sơ và phòng ban
        // $nhanVien = NguoiDung::with(['hoSo', 'phongBan'])
        //     ->whereHas('hoSo')
        //     ->orderBy('id')
        //     ->get();

        $user = auth()->user();
        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Trưởng phòng chỉ được xem nhân viên trong cùng phòng ban, không được xem chính mình hoặc trưởng phòng khác
            $target = $chamCong->nguoiDung;

            if (
                $target->phong_ban_id !== $user->phong_ban_id || // khác phòng
                $target->id === $user->id ||                     // chính họ
                $target->coVaiTro('department')                  // người cũng là trưởng phòng
            ) {
                abort(403, 'Bạn không có quyền xem bản ghi này.');
            }
        } else {
            abort(403, 'Bạn không có quyền sửa bản ghi này.');
        }
        // Danh sách trạng thái chấm công
        $trangThaiList = [
            'binh_thuong' => 'Bình thường',
            'di_muon' => 'Đi muộn',
            've_som' => 'Về sớm',
            'vang_mat' => 'Vắng mặt',
            'nghi_phep' => 'Nghỉ phép'
        ];

        return view('admin.cham-cong.quan_ly_cham_cong.edit', compact('chamCong', 'trangThaiList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $chamCong = ChamCong::BanChamCongTheoId($id);
        // dd($request->all());
        $user = auth()->user();
        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Department chỉ xem được nếu cùng phòng ban và không phải chính họ
            if ($chamCong->nguoiDung->phong_ban_id !== $user->phong_ban_id || $chamCong->nguoiDung->id == $user->id) {
                abort(403, 'Bạn không có quyền sửa bản ghi này.');
            }
        } else {
            abort(403, 'Bạn không có quyền sửa bản ghi này.');
        }
        $validated = $request->validate([
            'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
            'ngay_cham_cong' => 'required|date',
            'gio_vao' => 'required|date_format:H:i',
            'gio_ra' => 'nullable|date_format:H:i',
            'phut_di_muon' => 'nullable|integer|min:0|max:600',
            'phut_ve_som' => 'nullable|integer|min:0|max:600',
            'so_gio_lam' => 'nullable|numeric|min:0|max:24',
            'so_cong' => 'nullable|numeric|min:0|max:1',
            'trang_thai' => 'required|in:binh_thuong,di_muon,ve_som,vang_mat,nghi_phep',
            'trang_thai_duyet' => 'nullable|in:0,1,2,3',
            'ghi_chu' => 'nullable|string|max:1000',
            'ghi_chu_duyet' => 'nullable|string|max:500',

        ], [
            'nguoi_dung_id.required' => 'Vui lòng chọn nhân viên',
            'nguoi_dung_id.exists' => 'Nhân viên không tồn tại',
            'ngay_cham_cong.required' => 'Vui lòng chọn ngày chấm công',
            'ngay_cham_cong.date' => 'Ngày chấm công không hợp lệ',
            'gio_vao.required' => 'Vui lòng nhập giờ vào',
            'gio_vao.date_format' => 'Giờ vào không đúng định dạng (HH:MM)',
            'gio_ra.date_format' => 'Giờ ra không đúng định dạng (HH:MM)',
            'phut_di_muon.integer' => 'Phút đi muộn phải là số nguyên',
            'phut_ve_som.integer' => 'Phút về sớm phải là số nguyên',
            'phut_di_muon.min' => 'Phút đi muộn phải lớn hình 0',
            'phut_ve_som.min' => 'Phút về sớm phải lớn hình 0',
            'phut_di_muon.max' => 'Phút đi muộn phải nho hình 600',
            'phut_ve_som.max' => 'Phút về sớm phải nho hình 600',
            'so_gio_lam.numeric' => 'Số giờ làm phải lớn hình 0',
            'so_gio_lam.min' => 'Số giờ làm phải lớn hình 0',
            'so_gio_lam.max' => 'Số giờ làm phải nho hình 24',
            'so_cong.numeric' => 'Số công phải lớn hình 0',
            'so_cong.min' => 'Số công phải lớn hình 0',
            'so_cong.max' => 'Số công phải nho hình 1',
            'trang_thai.required' => 'Vui lòng chọn trạng thái',
            'trang_thai.in' => 'Trạng thái không hợp lệ',
            'trang_thai_duyet.in' => 'Trạng thái phê duyệt không hợp lệ',
            'ghi_chu.max' => 'Ghi chú không được vượt quá 1000 ký tự',
            'ghi_chu_duyet.max' => 'Ghi chú phê duyệt không được vượt quá 500 ký tự',
        ]);

        try {
            // Kiểm tra trùng lặp (trừ bản ghi hiện tại)
            $existingRecord = ChamCong::where('nguoi_dung_id', $validated['nguoi_dung_id'])
                ->where('ngay_cham_cong', $validated['ngay_cham_cong'])
                ->where('id', '!=', $chamCong->id)
                ->first();
            // dd($existingRecord);

            if ($existingRecord) {
                return back()->withErrors([
                    'ngay_cham_cong' => 'Nhân viên này đã có bản ghi chấm công cho ngày ' . Carbon::parse($validated['ngay_cham_cong'])->format('d/m/Y')
                ])->withInput();
            }

            // Kiểm tra logic giờ vào và giờ ra
            if ($validated['gio_ra']) {
                $gioVao = Carbon::createFromFormat('H:i', $validated['gio_vao']);
                $gioRa = Carbon::createFromFormat('H:i', $validated['gio_ra']);

                if ($gioRa->lessThanOrEqualTo($gioVao)) {
                    return back()->withErrors([
                        'gio_ra' => 'Giờ ra phải sau giờ vào'
                    ])->withInput();
                }
            }
            $formatNgayChamCong = Carbon::parse($validated['ngay_cham_cong'])->format('Y-m-d');
            // dd($formatNgayChamCong);
            // Chuẩn bị dữ liệu cập nhật
            $dataUpdate = [
                'nguoi_dung_id' => $validated['nguoi_dung_id'],
                'ngay_cham_cong' => $formatNgayChamCong,
                'gio_vao' => $validated['gio_vao'],
                'trang_thai' => $validated['trang_thai'],
                'ghi_chu' => $validated['ghi_chu'],
                'phut_di_muon' => $validated['phut_di_muon'],
                'phut_ve_som' => $validated['phut_ve_som'],
                'so_gio_lam' => $validated['so_gio_lam'],
                'so_cong' => $validated['so_cong'],

            ];

            // Xử lý giờ ra (có thể null)
            if ($validated['gio_ra']) {
                $dataUpdate['gio_ra'] = $validated['gio_ra'];
            }

            // Xử lý trạng thái phê duyệt
            if (isset($validated['trang_thai_duyet'])) {
                $dataUpdate['trang_thai_duyet'] = (int) $validated['trang_thai_duyet'];
                $dataUpdate['ghi_chu_duyet'] = $validated['ghi_chu_duyet'];
            }
            // dd($validated);

            DB::beginTransaction();

            // Cập nhật bản ghi
            $chamCong->update($dataUpdate);
            // dd($chamCong);
            // Tính toán lại các thông số (số giờ làm, số công, phút đi muộn/về sớm)
            // $chamCong = $this->tinhSoCong($chamCong);
            // $chamCong->capNhatTrangThai($validated['trang_thai']);
            // $chamCong->tinhSoGioLam();
            // $chamCong->tinhSoCong();
            $chamCong->save();
            DB::commit();

            return redirect()->route('admin.chamcong.show', $chamCong->id)
                ->with('success', 'Cập nhật bản ghi chấm công thành công!');

        } catch (\Exception $e) {
            \Log::error('Lỗi cập nhật chấm công: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Có lỗi xảy ra khi cập nhật. Vui lòng thử lại!'
            ])->withInput();
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    public function destroy($id)
    {
        $chamCong = ChamCong::findOrFail($id);
        $user = auth()->user();
        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Trưởng phòng chỉ được xem nhân viên trong cùng phòng ban, không được xem chính mình hoặc trưởng phòng khác
            $target = $chamCong->nguoiDung;

            if (
                $target->phong_ban_id !== $user->phong_ban_id || // khác phòng
                $target->id === $user->id ||                     // chính họ
                $target->coVaiTro('department')                  // người cũng là trưởng phòng
            ) {
                abort(403, 'Bạn không có quyền xóa bản ghi này.');
            }
        } else {
            abort(403, 'Bạn không có quyền xóa bản ghi này.');
        }
        $chamCong->delete();

        return redirect()->route('admin.chamcong.index')
            ->with('success', 'Xóa bản ghi chấm công thành công!');
    }

    // /**
    //  * Báo cáo chấm công theo tháng
    //  */
    // public function baoCaoThang(Request $request)
    // {
    //     $thang = $request->get('thang', now()->month);
    //     $nam = $request->get('nam', now()->year);
    //     $nguoiDungId = $request->get('nguoi_dung_id');

    //     $query = ChamCong::with(['nguoiDung.hoSo', 'nguoiDung.phongBan'])
    //                      ->whereMonth('ngay_cham_cong', $thang)
    //                      ->whereYear('ngay_cham_cong', $nam);

    //     if ($nguoiDungId) {
    //         $query->where('nguoi_dung_id', $nguoiDungId);
    //     }

    //     $chamCong = $query->orderBy('nguoi_dung_id')
    //                       ->orderBy('ngay_cham_cong')
    //                       ->get();

    //     // Tính toán thống kê
    //     $thongKe = $chamCong->groupBy('nguoi_dung_id')->map(function($items) {
    //         return [
    //             'nguoi_dung' => $items->first()->nguoiDung,
    //             'tong_ngay_lam' => $items->count(),
    //             'tong_gio_lam' => $items->sum('so_gio_lam'),
    //             'tong_cong' => $items->sum('so_cong'),
    //             'so_lan_di_muon' => $items->where('trang_thai', 'di_muon')->count(),
    //             'so_lan_ve_som' => $items->where('trang_thai', 've_som')->count(),
    //             'tong_phut_di_muon' => $items->sum('phut_di_muon'),
    //             'tong_phut_ve_som' => $items->sum('phut_ve_som'),
    //         ];
    //     });

    //     $nguoiDung = NguoiDung::with('hoSo')->orderBy('id')->get();

    //     return view('cham-cong.bao-cao-thang', compact(
    //         'chamCong',
    //         'thongKe',
    //         'thang',
    //         'nam',
    //         'nguoiDung'
    //     ));
    // }

    // /**
    //  * Export báo cáo chấm công
    //  */
    public function exportBaoCao(Request $request)
    {
        // Logic export file Excel/PDF
        // Có thể sử dụng Laravel Excel package

        $thang = $request->get('thang', now()->month);
        $nam = $request->get('nam', now()->year);

        $chamCong = ChamCong::layBangChamCongThang(null, $thang, $nam);

        // Return file download
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    // /**
    //  * Phê duyệt chấm công
    //  */
    public function pheDuyet(Request $request, $id)
    {
        $chamCong = ChamCong::BanChamCongTheoId($id);
        $user = auth()->user();
        if ($user->coVaiTro('Admin') || $user->coVaiTro('HR')) {
            // Admin, HR xem được hết
        } else if ($user->coVaiTro('department')) {
            // Trưởng phòng chỉ được xem nhân viên trong cùng phòng ban, không được xem chính mình hoặc trưởng phòng khác
            $target = $chamCong->nguoiDung;

            if (
                $target->phong_ban_id !== $user->phong_ban_id || // khác phòng
                $target->id === $user->id ||                     // chính họ
                $target->coVaiTro('department')                  // người cũng là trưởng phòng
            ) {
                abort(403, 'Bạn không có quyền xem bản ghi này.');
            }
        } else {
            abort(403, 'Bạn không có quyền phê duyệt bản ghi này.');
        }
        $trangThai = $chamCong->trang_thai;
        $validated = $request->validate([
            'trang_thai_duyet' => 'required|numeric',
            'ghi_chu_phe_duyet' => 'nullable|string'
        ]);

        $trangThaiDuyet = (int) $validated['trang_thai_duyet'];

        // Nếu không có giờ ra thì đặt mặc định là 17:30
        if (empty($chamCong->gio_ra)) {
            $chamCong->gio_ra = '17:30';
        }

        DB::beginTransaction();
        try {
            $chamCong->update([
                'trang_thai_duyet' => $trangThaiDuyet,
                'nguoi_phe_duyet_id' => auth()->id(),
                'thoi_gian_phe_duyet' => now(),
                'ghi_chu_duyet' => $validated['ghi_chu_phe_duyet'] ?? $chamCong->ghi_chu,
                'gio_ra' => $chamCong->gio_ra // Cập nhật giờ ra (có thể là mặc định)
            ]);

            // Tính toán lại số giờ làm và số công
            $chamCong->capNhatTrangThai($trangThai);
            // $chamCong->tinhSoCong();
            $chamCong->save();

            DB::commit();

            $message = $trangThaiDuyet == 1
                ? 'Phê duyệt chấm công thành công!'
                : 'Từ chối chấm công thành công!';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi phê duyệt chấm công: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Có lỗi xảy ra khi phê duyệt. Vui lòng thử lại!'
            ])->withInput();
        }
    }

    // /**
    //  * Lấy thống kê dashboard
    //  */
    // public function thongKeDashboard()
    // {
    //     $homNay = now()->format('Y-m-d');
    //     $thangHienTai = now();

    //     $thongKe = [
    //         'hom_nay' => [
    //             'tong_nhan_vien_cham_cong' => ChamCong::where('ngay_cham_cong', $homNay)->distinct('nguoi_dung_id')->count(),
    //             'di_muon' => ChamCong::where('ngay_cham_cong', $homNay)->where('trang_thai', 'di_muon')->count(),
    //             've_som' => ChamCong::where('ngay_cham_cong', $homNay)->where('trang_thai', 've_som')->count(),
    //             'vang_mat' => ChamCong::where('ngay_cham_cong', $homNay)->where('trang_thai', 'vang_mat')->count(),
    //         ],
    //         'thang_hien_tai' => [
    //             'tong_cong' => ChamCong::thangHienTai()->sum('so_cong'),
    //             'tong_gio_lam' => ChamCong::thangHienTai()->sum('so_gio_lam'),
    //             'cho_phe_duyet' => ChamCong::thangHienTai()->where('trang_thai_duyet', 'cho_duyet')->count(),
    //         ]
    //     ];

    //     return view('dashboard.cham-cong', compact('thongKe'));
    // }
}
