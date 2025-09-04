<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\DangKyTangCa;
use App\Models\NguoiDung;
use App\Notifications\TaoYeuCauTangCa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DangKyTangCaController extends Controller
{
     public function index(Request $request)
    {
        // dd($request->all());
        $query = DangKyTangCa::with(['nguoiDuyet'])
                    ->byEmployee(Auth::id())
                    ->orderBy('ngay_tang_ca', 'desc');
        // dd($request->all());
        // Filter by status
        if ($request->filled('trang_thai')) {
            $query->byTrangThai($request->trang_thai);
        }
        if($request->filled('ngay_tang_ca')){
            $query->byNgayTangCa($request->ngay_tang_ca);
        }
        // Filter by month
        if ($request->filled('thang') ) {
            $query->byThang( $request->thang);
        }
        if ($request->filled('nam')) {
            $query->byNam($request->nam);
        }

        $dangKyTangCa = $query->paginate(15);

        // dd($dangKyTangCa->loai_tang_ca_text->first());
        // Statistics
        $stats = [
            'total' => DangKyTangCa::byEmployee(Auth::id())->count(),
            'pending' => DangKyTangCa::byEmployee(Auth::id())->pending()->count(),
            'approved' => DangKyTangCa::byEmployee(Auth::id())->approved()->count(),
            'rejected' => DangKyTangCa::byEmployee(Auth::id())->byTrangThai('tu_choi')->count(),
        ];
        // dd($stats);

        return view('employe.cham-cong.leaveTest', compact('dangKyTangCa', 'stats'));
    }
    /**
     * Store a newly created overtime registration
     */
    public function store(Request $request) {
    // Validate request data
    // \Log::info('All request data:', $request->all());
    // \Log::info('Request has gio_ket_thuc:', $request->has('gio_ket_thuc'));
    // \Log::info('gio_ket_thuc value:', $request->input('gio_ket_thuc'));
    $validator = Validator::make($request->all(), [
        'ngay_tang_ca' => 'required|date|after_or_equal:today',
        'gio_bat_dau' => 'required|date_format:H:i',
        'gio_ket_thuc' => 'required|date_format:H:i',
        'loai_tang_ca' => 'required|in:ngay_thuong,ngay_nghi,le_tet',
        'ly_do_tang_ca' => 'required|string|max:1000',
        'so_gio_tang_ca' => 'required|numeric|min:0.1|max:12'
    ], [
        'ngay_tang_ca.required' => 'Vui lòng chọn ngày tăng ca',
        'ngay_tang_ca.after_or_equal' => 'Ngày tăng ca không được trong quá khứ',
        'gio_bat_dau.required' => 'Vui lòng nhập giờ bắt đầu',
        'gio_bat_dau.date_format' => 'Định dạng giờ bắt đầu không đúng',
        'gio_ket_thuc.required' => 'Vui lòng nhập giờ kết thúc',
        'gio_ket_thuc.date_format' => 'Định dạng giờ kết thúc không đúng',
        'loai_tang_ca.required' => 'Vui lòng chọn loại tăng ca',
        'loai_tang_ca.in' => 'Loại tăng ca không hợp lệ',
        'ly_do_tang_ca.required' => 'Vui lòng nhập lý do tăng ca',
        'ly_do_tang_ca.max' => 'Lý do tăng ca không được vượt quá 1000 ký tự',
        'so_gio_tang_ca.required' => 'Số giờ tăng ca là bắt buộc',
        'so_gio_tang_ca.min' => 'Số giờ tăng ca phải lớn hơn 0',
        'so_gio_tang_ca.max' => 'Số giờ tăng ca không được vượt quá 12 giờ'
    ]);

    // Custom validation for weekday overtime
    $validator->after(function ($validator) use ($request) {
        if ($request->loai_tang_ca === 'ngay_thuong' && $request->gio_bat_dau) {
            $startTime = Carbon::createFromFormat('H:i', $request->gio_bat_dau);
            $limitTime = Carbon::createFromFormat('H:i', '18:45');

            if ($startTime->lt($limitTime)) {
                $validator->errors()->add('gio_bat_dau', 'Ngày thường chỉ được tăng ca từ 18:45 trở đi');
            }
        }

        // Validate time logic
        if ($request->gio_bat_dau && $request->gio_ket_thuc) {
            $startTime = Carbon::createFromFormat('H:i', $request->gio_bat_dau);
            $endTime = Carbon::createFromFormat('H:i', $request->gio_ket_thuc);

            // Handle overnight work
            if ($endTime->lte($startTime)) {
                $endTime->addDay();
            }

            $hoursDiff = $endTime->diffInHours($startTime, true);

            if ($hoursDiff <= 0) {
                $validator->errors()->add('gio_ket_thuc', 'Giờ kết thúc phải sau giờ bắt đầu');
            }

            if (abs($hoursDiff - $request->so_gio_tang_ca) > 0.1) {
                $validator->errors()->add('so_gio_tang_ca', 'Số giờ tăng ca không khớp với thời gian đã chọn');
            }
        }
    });

    if ($validator->fails()) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Check if already registered for this date
    $existingRegistration = DangKyTangCa::byEmployee(Auth::id())
        ->where('ngay_tang_ca', $request->ngay_tang_ca)
        ->whereIn('trang_thai', ['cho_duyet', 'da_duyet'])
        ->first();

    if ($existingRegistration) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'errors' => ['ngay_tang_ca' => ['Bạn đã đăng ký tăng ca cho ngày này']]
            ], 422);
        }

        return redirect()->back()
            ->withErrors(['ngay_tang_ca' => 'Bạn đã đăng ký tăng ca cho ngày này'])
            ->withInput();
    }
    $gioKetThuc = $request->input('gio_ket_thuc');
    DB::beginTransaction();
    try {
        $overtimeRequest = DangKyTangCa::create([
            'nguoi_dung_id' => Auth::id(),
            'ngay_tang_ca' => $request->ngay_tang_ca,
            'gio_bat_dau' => $request->gio_bat_dau,
            'gio_ket_thuc' => $gioKetThuc,
            'so_gio_tang_ca' => $request->so_gio_tang_ca,
            'loai_tang_ca' => $request->loai_tang_ca,
            'ly_do_tang_ca' => trim($request->ly_do_tang_ca),
            // 'trang_thai' => 'cho_duyet',
            'created_at' => now()
        ]);

        DB::commit();
        $user = Auth::user();
        $nguoiNhan = NguoiDung::where(function ($query) use ($user) {
                $query->where('phong_ban_id', $user->phong_ban_id)
                    ->whereHas('vaiTros', function ($q) {
                        $q->where('name', 'department');
                    });
            })
            ->orWhereHas('vaiTros', function ($q) {
                $q->whereIn('name', ['hr', 'admin']);
            })
            ->get();

        foreach ($nguoiNhan as $nhanVien) {
            $nhanVien->notify(new TaoYeuCauTangCa($overtimeRequest,$nhanVien));
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký tăng ca thành công',
                'data' => $overtimeRequest
            ]);
        }

        return redirect()->back()->with('success', 'Đăng ký tăng ca thành công');

    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Error creating overtime request: ' . $e->getMessage());

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng ký tăng ca'
            ], 500);
        }

        return redirect()->back()
            ->withErrors(['error' => 'Có lỗi xảy ra khi đăng ký tăng ca'])
            ->withInput();
    }
}
}
