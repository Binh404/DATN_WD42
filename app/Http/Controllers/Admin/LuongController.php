<?php
namespace App\Http\Controllers\Admin;
use App\Models\Luong;
use App\Models\ChamCong;
use App\Models\BangLuong;
use App\Models\NguoiDung;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\PDF;
use App\Mail\GuiPhieuLuong;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LuongNhanVien;
use App\Models\thucHienTangCa;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LuongCoBanExport;
use App\Helpers\RemoveNameHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\LuongNhanVienExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\ThucHienTangCaAdminController;

//    public function tongLuong(Request $request)
// {
//     // Ưu tiên lấy từ request, nếu không có thì mặc định tháng/năm hiện tại
//     $thang = $request->thang ?? now()->month;
//     $nam = $request->nam ?? now()->year;

//     $query = DB::table('nguoi_dung')
//         ->join('cham_cong', 'nguoi_dung.id', '=', 'cham_cong.nguoi_dung_id')
//         ->join('ho_so_nguoi_dung', 'nguoi_dung.id', '=', 'ho_so_nguoi_dung.nguoi_dung_id')
//         ->leftJoin('chuc_vu', 'nguoi_dung.chuc_vu_id', '=', 'chuc_vu.id')
//         ->whereMonth('cham_cong.ngay_cham_cong', $thang)
//         ->whereYear('cham_cong.ngay_cham_cong', $nam);

//     $luongTheoNguoi = $query
//         ->select(
//             'nguoi_dung.id',
//             DB::raw("CONCAT(ho_so_nguoi_dung.ho, ' ', ho_so_nguoi_dung.ten) as ho_ten"),
//             DB::raw('SUM(cham_cong.so_gio_lam) as tong_gio_lam'),
//             DB::raw('SUM(cham_cong.so_cong) as tong_cong'),
//             DB::raw('COALESCE(chuc_vu.luong_toi_thieu, 10400000) / 173 as don_gia_gio'),
//             DB::raw('SUM(cham_cong.so_gio_lam) * (COALESCE(chuc_vu.luong_toi_thieu, 10400000) / 173) as tong_luong')
//         )
//         ->groupBy('nguoi_dung.id', 'ho_so_nguoi_dung.ho', 'ho_so_nguoi_dung.ten', 'chuc_vu.luong_toi_thieu')
//         ->get();

//     return view('admin.luong.index', compact('luongTheoNguoi', 'thang', 'nam'));
// }


//     public function phieuLuongIndex(Request $request)
//     {
//         $thang = $request->thang ?? date('m');
//         $nam = $request->nam ?? date('Y');

//         $nhanVien = NguoiDung::whereHas('hoSo')->get();

//         $luongTheoNguoi = $nhanVien->map(function ($nv) use ($thang, $nam) {
//             $tongGioLam = ChamCong::where('nguoi_dung_id', $nv->id)
//                 ->whereMonth('ngay_cham_cong', $thang)
//                 ->whereYear('ngay_cham_cong', $nam)
//                 ->sum('so_gio_lam');

//             $chucVu = DB::table('chuc_vu')->where('id', $nv->chuc_vu_id)->first();
//             $donGiaGio = isset($chucVu->luong_toi_thieu) ? $chucVu->luong_toi_thieu / 173 : 60000;
//             $tongLuong = $tongGioLam * $donGiaGio;

//             return [
//                 'id' => $nv->id,
//                 'ho_ten' => optional($nv->hoSo)->ho . ' ' . optional($nv->hoSo)->ten,
//                 'tong_gio_lam' => $tongGioLam,
//                 'tong_luong' => $tongLuong,
//             ];
//         });

//         return view('admin.luong.phieuluong', compact('luongTheoNguoi', 'thang', 'nam'));
//     }

//     public function xemPhieuLuong($user_id, $thang, $nam)
//     {
//         $nhanVien = DB::table('ho_so_nguoi_dung')
//             ->join('nguoi_dung', 'nguoi_dung.id', '=', 'ho_so_nguoi_dung.nguoi_dung_id')
//             ->leftJoin('phong_ban', 'phong_ban.id', '=', 'nguoi_dung.phong_ban_id')
//             ->leftJoin('chuc_vu', 'chuc_vu.id', '=', 'nguoi_dung.chuc_vu_id')
//             ->where('nguoi_dung.id', $user_id)
//             ->select(
//                 'ho_so_nguoi_dung.*',
//                 'nguoi_dung.email',
//                 'phong_ban.ten_phong_ban',
//                 'chuc_vu.ten as chuc_vu',
//                 'chuc_vu.luong_toi_thieu'
//             )
//             ->first();

//         $tongGioLam = DB::table('cham_cong')
//             ->where('nguoi_dung_id', $user_id)
//             ->whereMonth('ngay_cham_cong', $thang)
//             ->whereYear('ngay_cham_cong', $nam)
//             ->sum('so_gio_lam');

//         $luongTheoGio = isset($nhanVien->luong_toi_thieu) && $nhanVien->luong_toi_thieu > 0
//             ? $nhanVien->luong_toi_thieu / 173
//             : 60000;

//         $tongLuong = $tongGioLam * $luongTheoGio;

//         $soCong = round($tongGioLam / 8);
//         $nghiCoLuong = 1;
//         $nghiKhongLuong = 0;

//         $pathToImage = public_path('assets/images/dvlogo.png');
//         $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
//         $data = file_get_contents($pathToImage);
//         $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//         return view('admin.luong.chitietphieuluong', compact(
//             'nhanVien',
//             'thang',
//             'nam',
//             'tongGioLam',
//             'tongLuong',
//             'nghiCoLuong',
//             'nghiKhongLuong',
//             'soCong',
//             'base64'
//         ));
//     }







class LuongController extends Controller
{
  public function luongPdf(Request $request, $user_id, $thang, $nam)
{

   $luong = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
        ->where('nguoi_dung_id', $user_id)
        ->where('luong_thang', $thang)
        ->where('luong_nam', $nam)
        ->latest('created_at') // lấy bản ghi mới nhất
        ->first();

    if (!$luong) {
        abort(404, 'Không tìm thấy dữ liệu lương.');
    }

     $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;
    // $ngay = $request->ngay ?? now()->day;
    $soCong = $luong->so_ngay_cong;
    $gioTangCa = $luong->gio_tang_ca;
    $tongLuong = $luong->tong_luong;
    $luongThucNhan = $luong->luong_thuc_nhan;
    $luongCoBan = $luong->luong_co_ban;
    $congTangCa = $luong->cong_tang_ca ?? 0; // Công tăng ca nếu có, mặc định là 0 nếu không có
// dd($congOT); // test từng nhân viên

    // Tên nhân viên, phòng ban, chức vụ
    $nhanVien = $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten ?? '';

    $phongBan = $luong->nguoiDung->phongBan->ten_phong_ban ?? '-';
    $chucVu = $luong->nguoiDung->chucVu->ten ?? '-';

     // Tính công tăng ca
    // $congTangCa = DB::table('thuc_hien_tang_ca')
    //     ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
    //     ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
    //     ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
    //     ->whereYear('thuc_hien_tang_ca.created_at', $nam)
    //     ->sum('thuc_hien_tang_ca.so_cong_tang_ca');


    // Xử lý logo base64
    $pathToImage = public_path('assets/images/dvlogo.png');
    $base64 = null;
    if (file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }


    $data = compact(
        'luong',
        'nhanVien',
        'phongBan',
        'chucVu',
        'thang',
        'nam',
        'soCong',
        'gioTangCa',
        'tongLuong',
        'luongThucNhan',
        'luongCoBan',
        'congTangCa',
        // 'congTangCa',
        'base64'
    );

    $pdf = PDF::loadView('admin.luong.bangluong.pdf', $data);

    return $pdf->download("phieu_luong_NV{$user_id}_{$thang}_{$nam}.pdf");
}



 public function index(Request $request)
{
    $thang = $request->thang; // bỏ default để có thể chọn tất cả
    $nam = $request->nam;     // bỏ default
    $ngay = $request->ngay ?? now()->day;

    $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'bangLuong', 'nguoiDung.chucVu')
        ->when($thang, function ($query) use ($thang) {
            $query->where('luong_thang', $thang);
        })
        ->when($nam, function ($query) use ($nam) {
            $query->where('luong_nam', $nam);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends(request()->query());

    $dsLuong = BangLuong::with('luongNhanVien')->get();

    //  // Lọc ra những nhân viên chưa được tính lương trong tháng/năm này
    //     $nhanViensChuaTinhLuong = $luongs->filter(function ($nhanVien) use ($thang, $nam) {
    //         // Kiểm tra xem nhân viên này đã có lương trong tháng/năm này chưa
    //         $daCoLuong = LuongNhanVien::where('nguoi_dung_id', $nhanVien->id)
    //             ->where('luong_thang', $thang)
    //             ->where('luong_nam', $nam)
    //             ->exists();

    //         return !$daCoLuong;
    //     });

    return view('admin.luong.bangluong.index', compact('luongs', 'thang', 'nam', 'ngay', 'dsLuong'));
}

  public function chiTietPhieuLuong(Request $request, $id)
{
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;
    $ngay = $request->ngay ?? now()->day;

    $luong = LuongNhanVien::with('nguoiDung.hoSo', 'bangLuong', 'nguoiDung.chucVu')
        ->where('id', $id)
        // ->where('luong_thang', $thang)
        // ->where('luong_nam', $nam)
        ->first(); // Dùng first thay vì find vì bạn có thêm điều kiện where

    if (!$luong) {
        abort(404, 'Không tìm thấy phiếu lương');
    }

    // base64 logo
    $pathToImage = public_path('assets/images/dvlogo.png');
    $base64 = null;
    if (file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    // Tính công tăng ca
    // $congTangCa = DB::table('thuc_hien_tang_ca')
    //     ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
    //     ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
    //     ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
    //     ->whereYear('thuc_hien_tang_ca.created_at', $nam)
    //     ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

    return view('admin.luong.bangluong.chitietphieuluong', compact(
        'luong',
        'thang',
        'nam',
        'ngay',
        'base64',
        // 'congTangCa'
    ));
}




  public function create(Request $request)
{
    // Mặc định lấy tháng trước nếu không có tham số
    if ($request->has('thang') && $request->has('nam')) {
        $thang = $request->thang;
        $nam = $request->nam;

        // Kiểm tra xem có được phép tính lương tháng này không
        if (!$this->coDuocPhepTinhLuong($thang, $nam)) {
            $thangNamHienTai = $this->getThangNamHienTai();

            // Tự động chuyển hướng về tháng trước
            $thangTruoc = $thangNamHienTai['thang'] == 1 ? 12 : $thangNamHienTai['thang'] - 1;
            $namTruoc = $thangNamHienTai['thang'] == 1 ? $thangNamHienTai['nam'] - 1 : $thangNamHienTai['nam'];

            return redirect()->route('luong.create', ['thang' => $thangTruoc, 'nam' => $namTruoc])
                ->with('info', "Bạn đã được chuyển hướng về tháng {$thangTruoc}/{$namTruoc} vì không thể tính lương tháng {$thang}/{$nam} (tháng hiện tại).");
        }
    } else {
        // Lấy tháng trước
        $thangHienTai = now()->month;
        $namHienTai = now()->year;

        if ($thangHienTai == 1) {
            $thang = 12;
            $nam = $namHienTai - 1;
        } else {
            $thang = $thangHienTai - 1;
            $nam = $namHienTai;
        }
    }

    // Lấy thông tin tháng năm hiện tại
    $thangNamHienTai = $this->getThangNamHienTai();

    // Kiểm tra xem có được phép tính lương tháng này không
    if (!$this->coDuocPhepTinhLuong($thang, $nam)) {
        // Thay vì redirect, hiển thị cảnh báo và cho phép xem trang
        $canTinhLuong = false;
        $warningMessage = 'Chỉ được phép tính lương cho tháng trước. Tháng hiện tại: ' . $thangNamHienTai['thang'] . '/' . $thangNamHienTai['nam'] . ' chưa kết thúc.';
    } else {
        $canTinhLuong = true;
        $warningMessage = null;
    }

    try {
        $nhanViens = NguoiDung::where('da_hoan_thanh_ho_so', 1)
            ->with('hoSo')
            ->get();

        // Lọc ra những nhân viên chưa được tính lương trong tháng/năm này
        $nhanViensChuaTinhLuong = $nhanViens->filter(function ($nhanVien) use ($thang, $nam) {
            // Kiểm tra xem nhân viên này đã có lương trong tháng/năm này chưa
            $daCoLuong = LuongNhanVien::where('nguoi_dung_id', $nhanVien->id)
                ->where('luong_thang', $thang)
                ->where('luong_nam', $nam)
                ->exists();

            return !$daCoLuong;
        });

        // Nếu không còn nhân viên nào để tính lương
        if ($nhanViensChuaTinhLuong->isEmpty()) {
            $canTinhLuong = false;
            $warningMessage = 'Tất cả nhân viên đã được tính lương cho tháng ' . $thang . '/' . $nam;
        }

        // Tạo mã bảng lương ngẫu nhiên
        $maBangLuong = 'DVT' . mt_rand(1000000, 9999999);

        // Lấy số công của từng nhân viên trong tháng/năm được chọn
        $bangChamCong = DB::table('cham_cong')
            ->select('nguoi_dung_id', DB::raw('SUM(so_cong) as tong_so_cong'))
            ->whereMonth('ngay_cham_cong', $thang)
            ->whereYear('ngay_cham_cong', $nam)
            ->where('trang_thai_duyet', 1)
            ->groupBy('nguoi_dung_id')
            ->pluck('tong_so_cong', 'nguoi_dung_id'); // dạng [id => công]

       $congTangCa = [];

    foreach ($nhanViensChuaTinhLuong as $nhanVien) {
        $soCongTangCa = DB::table('thuc_hien_tang_ca')
            ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
            ->where('dang_ky_tang_ca.nguoi_dung_id', $nhanVien->id)
            ->whereMonth('dang_ky_tang_ca.ngay_tang_ca', $thang)
            ->whereYear('dang_ky_tang_ca.ngay_tang_ca', $nam)
            ->where('thuc_hien_tang_ca.trang_thai', 'hoan_thanh')
            ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

        $congTangCa[$nhanVien->id] = $soCongTangCa;
    }
    // dd($congTangCa);
        return view('admin.luong.tinhluong.tinh_luong', compact(
            'nhanViensChuaTinhLuong',
            'maBangLuong',
            'bangChamCong',
            'congTangCa',
            'thang',
            'nam',
            'thangNamHienTai',
            'canTinhLuong',
            'warningMessage'
        ));
    } catch (\Exception $e) {
        // Log lỗi và chuyển hướng với thông báo lỗi
        Log::error('Lỗi khi tạo trang tính lương: ' . $e->getMessage());
        return redirect()->route('luong.index')->with('error', 'Có lỗi xảy ra khi tải trang tính lương: ' . $e->getMessage());
    }
}



// public function store(Request $request)
// {
//     DB::beginTransaction();

//     try {
//         // Tạo mã bảng lương
//         $maBangLuong = $request->ma_bang_luong;

//         // Tạo bảng lương
//         $bangLuong = BangLuong::create([
//             'ma_bang_luong' => $maBangLuong,
//             'nam' => Carbon::parse($request->ngay_tinh_luong)->year,
//             'thang' => Carbon::parse($request->ngay_tinh_luong)->month,
//             'trang_thai' => 'dang_xu_ly',
//             'nguoi_xu_ly_id' => auth()->id(),
//             'thoi_gian_xu_ly' => Carbon::now(),
//         ]);

//         // Tạo bản ghi lương nhân viên
//         LuongNhanVien::create([
//             'bang_luong_id' => $bangLuong->id,
//             'nguoi_dung_id' => $request->nguoi_dung_id,
//             'luong_co_ban' => $request->luong_co_ban ?? 0,
//             'tong_phu_cap' => $request->phu_cap ?? 0,
//             'tong_khau_tru' => $request->tong_khau_tru ?? 0,
//             'tong_luong' => $request->tong_luong ?? 0,
//             'luong_thuc_nhan' => $request->luong_thuc_nhan ?? 0,
//             'so_ngay_cong' => $request->so_ngay_cong ?? 0,
//             'gio_tang_ca' => $request->gio_tang_ca ?? 0,
//             'ngay_nghi_phep' => $request->ngay_nghi_phep ?? 0,
//             'ngay_nghi_khong_phep' => $request->ngay_nghi_khong_phep ?? 0,
//             'ngay_le' => $request->ngay_le ?? 0,
//             'ghi_chu' => $request->mo_ta ?? null,
//         ]);

//         DB::commit();

//         return redirect()->back()->with('success', 'Tính lương cho nhân viên thành công!');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return back()->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
//     }
// }
public function tinhLuongVaLuu(Request $request)
{
    // Validation cơ bản
    $request->validate([
        'nguoi_dung_id' => 'required|exists:nguoi_dung,id',
        'so_ngay_cong' => 'nullable|numeric|min:0',
        'so_cong_tang_ca' => 'nullable|numeric|min:0',
        'ngay_tinh_luong' => 'required|date',
        'ma_bang_luong' => 'required|string',
    ], [
        'nguoi_dung_id.required' => 'Vui lòng chọn nhân viên',
        'nguoi_dung_id.exists' => 'Nhân viên không tồn tại',
        'so_ngay_cong.numeric' => 'Số ngày công phải là số',
        'so_ngay_cong.min' => 'Số ngày công không được âm',
        'so_cong_tang_ca.numeric' => 'Số công tăng ca phải là số',
        'so_cong_tang_ca.min' => 'Số công tăng ca không được âm',
        'ngay_tinh_luong.required' => 'Vui lòng chọn ngày tính lương',
        'ngay_tinh_luong.date' => 'Ngày tính lương không hợp lệ',
        'ma_bang_luong.required' => 'Mã bảng lương không được để trống',
    ]);

    // Lấy tháng/năm lương từ request (tháng trước tháng hiện tại)
    $thang = $request->thang ?? (now()->month == 1 ? 12 : now()->month - 1);
    $nam = $request->nam ?? (now()->month == 1 ? now()->year - 1 : now()->year);

    // Kiểm tra xem có được phép tính lương tháng này không
    if (!$this->coDuocPhepTinhLuong($thang, $nam)) {
        $thangNamHienTai = $this->getThangNamHienTai();
        return redirect()->route('luong.create', ['thang' => $thang, 'nam' => $nam])->with('error', 'Chỉ được phép tính lương cho tháng trước. Tháng hiện tại: ' . $thangNamHienTai['thang'] . '/' . $thangNamHienTai['nam'] . ' chưa kết thúc. Bạn phải đợi sang tháng mới để tính lương tháng này.');
    }

    // Kiểm tra xem nhân viên này đã được tính lương trong tháng/năm này chưa
    $daCoLuong = LuongNhanVien::where('nguoi_dung_id', $request->nguoi_dung_id)
        ->where('luong_thang', $thang)
        ->where('luong_nam', $nam)
        ->exists();

    if ($daCoLuong) {
        return redirect()->route('luong.create', ['thang' => $thang, 'nam' => $nam])->with('error', 'Nhân viên này đã được tính lương cho tháng ' . $thang . '/' . $nam);
    }

    try {
        // Bắt đầu transaction
        DB::beginTransaction();

        // Tạo mã bảng lương
        $maBangLuong = $request->ma_bang_luong;

        // Tạo bảng lương
        $bangLuong = BangLuong::create([
            'ma_bang_luong' => $maBangLuong,
            'nam' => Carbon::parse($request->ngay_tinh_luong)->year,
            'thang' => Carbon::parse($request->ngay_tinh_luong)->month,
            'trang_thai' => 'dang_xu_ly',
            'nguoi_xu_ly_id' => auth()->id(),
            'thoi_gian_xu_ly' => Carbon::now(),
        ]);

        $nguoiDung = NguoiDung::with('chucVu', 'hopDongLaoDongMoiNhat')->find($request->nguoi_dung_id);

        if (!$nguoiDung || !$nguoiDung->chucVu) {
            return redirect()->route('luong.index')->with('error', 'Không tìm thấy thông tin người dùng hoặc chức vụ.');
        }

        // Lấy thông tin lương cơ bản từ bảng luong
        $luongCoBanRecord = Luong::where('nguoi_dung_id', $request->nguoi_dung_id)->first();

        if (!$luongCoBanRecord) {
            return redirect()->route('luong.index')->with('error', 'Không tìm thấy lương cơ bản cho nhân viên này.');
        }

        // Lấy lương cơ bản và phụ cấp
        $luongCoBan = $luongCoBanRecord->luong_co_ban;
        $phuCap = $luongCoBanRecord->phu_cap;
        $tongLuongCoBan = $luongCoBan + $phuCap;
        // dd($tongLuongCoBan);
        // ======= 1. SỐ NGÀY CÔNG =======
        if ($request->filled('so_ngay_cong')) {
            $soNgayCong = (float) $request->so_ngay_cong;
        } else {
            // Tính từ bảng chấm công
            $soNgayCong = DB::table('cham_cong')
                ->where('nguoi_dung_id', $nguoiDung->id)
                ->whereMonth('ngay', $thang)
                ->whereYear('ngay', $nam)
                ->where('trang_thai', 'di_lam') // chỉ tính ngày đi làm
                ->count();
        }

        // ======= 2. SỐ CÔNG TĂNG CA =======
        if ($request->filled('so_cong_tang_ca')) {
            $tongCongTangCa = (float) $request->so_cong_tang_ca;
        } else {
            $tongCongTangCa = DB::table('thuc_hien_tang_ca')
                ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
                ->where('dang_ky_tang_ca.nguoi_dung_id', $nguoiDung->id)
                ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
                ->whereYear('thuc_hien_tang_ca.created_at', $nam)
                ->sum('thuc_hien_tang_ca.so_cong_tang_ca');
        }

        // ======= 3. TÍNH TOÁN LƯƠNG =======
        // Tính lương theo ngày (26 ngày công/tháng)
        $luongNgay = $tongLuongCoBan / 26; // = 615.000

        // Lương cơ bản theo số ngày công thực tế
        $tongLuong = $luongNgay * $soNgayCong; // = 615.000

        // Lương tăng ca (tính theo công, 1 công = 8 giờ)
        $luongTangCa = $tongCongTangCa * $luongNgay;

        // ======= 4. TÍNH THUẾ THU NHẬP CÁ NHÂN =======
        $tongLuongTruocThue = $tongLuong + $luongTangCa;

        // Thu nhập chịu thuế = tổng lương - giảm trừ bản thân (11 triệu)
        $giamTruBanThan = 11000000; //
        $thuNhapChiuThue = max(0, $tongLuongTruocThue - $giamTruBanThan);

        // Tính thuế theo function đã tạo
        $thongTinThue = $this->tinhThueThueNhapCaNhan($thuNhapChiuThue);
            // dd($thongTinThue);

        $thuePhaiNop = $thongTinThue['thue_phai_nop'];

        // Lương thực nhận sau thuế
        $luongThucNhan = $tongLuongTruocThue - $thuePhaiNop;
        // dd($thuePhaiNop);



        // ======= 5. LƯU DỮ LIỆU =======
        $luongNhanVien = LuongNhanVien::create([
            'bang_luong_id' => $bangLuong->id,
            'luong_thang' => $thang,        // Tháng lương (7)
            'luong_nam' => $nam,            // Năm lương (2025)
            'nguoi_dung_id' => $nguoiDung->id,
            'luong_co_ban' => $luongCoBan,
            'tong_luong' => round($tongLuong, 0),
            'luong_thuc_nhan' => round($luongThucNhan, 0),
            'thue_thu_nhap_ca_nhan' => round($thuePhaiNop, 0),
            'so_ngay_cong' => $soNgayCong,
            'gio_tang_ca' => $tongCongTangCa * 8,
            'cong_tang_ca' => $tongCongTangCa,
            'tong_phu_cap' => $phuCap,
            'ngay_nghi_phep' => 0,
            'ngay_nghi_khong_phep' => 0,
            'ngay_le' => 0,
            'ghi_chu' => $request->mo_ta ?? null,
            // created_at, updated_at để mặc định (ngày hiện tại)
        ]);



        // Commit transaction
        DB::commit();

        return redirect()->route('luong.index')->with('success', "Đã tính và lưu lương cho nhân viên {$nguoiDung->hoSo->ho} {$nguoiDung->hoSo->ten} tháng {$thang}/{$nam}");
    } catch (\Exception $e) {
        // Rollback transaction nếu có lỗi
        DB::rollBack();

        // Log lỗi và chuyển hướng với thông báo lỗi
        Log::error('Lỗi khi tính lương: ' . $e->getMessage());

        return redirect()->route('luong.create', ['thang' => $thang, 'nam' => $nam])
            ->with('error', 'Có lỗi xảy ra khi tính lương: ' . $e->getMessage());
    }
}

/**
 * Hiển thị danh sách nhân viên đã được tính lương trong tháng/năm
 */
public function danhSachDaTinhLuong(Request $request)
{
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;

    $nhanViensDaTinhLuong = LuongNhanVien::with(['nguoiDung.hoSo', 'nguoiDung.chucVu', 'bangLuong'])
        ->where('luong_thang', $thang)
        ->where('luong_nam', $nam)
        ->get()
        ->map(function ($luong) {
            return [
                'id' => $luong->id,
                'ma_nhan_vien' => $luong->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A',
                'ho_ten' => ($luong->nguoiDung->hoSo->ho ?? '') . ' ' . ($luong->nguoiDung->hoSo->ten ?? ''),
                'chuc_vu' => $luong->nguoiDung->chucVu->ten ?? 'N/A',
                'luong_co_ban' => number_format($luong->luong_co_ban, 0, ',', '.'),
                'tong_luong' => number_format($luong->tong_luong, 0, ',', '.'),
                'luong_thuc_nhan' => number_format($luong->luong_thuc_nhan, 0, ',', '.'),
                'so_ngay_cong' => $luong->so_ngay_cong,
                'cong_tang_ca' => $luong->cong_tang_ca,
                'ngay_tinh' => $luong->created_at->format('d/m/Y H:i'),
                'trang_thai' => $luong->bangLuong->trang_thai_label,
                'luong_thang' => $luong->luong_thang,
                'luong_nam' => $luong->luong_nam
            ];
        });

    return view('admin.luong.tinhluong.danh_sach_da_tinh_luong', compact('nhanViensDaTinhLuong', 'thang', 'nam'));
}
    public function chiTiet($id)
    {
        $luong = LuongNhanVien::with(['nguoiDung', 'bangLuong'])->findOrFail($id);

        return view('admin.luong.bangluong.chitietphieuluong', compact('luong'));
    }
 public function luongExcel()
    {
        return Excel::download(new LuongNhanVienExport, 'luong_nhan_vien.xlsx');
    }
 public function luongcbExcel()
    {
        return Excel::download(new LuongCoBanExport, 'luong_co_ban.xlsx');
    }

    // Export danh sách trúng tuyển
    public function destroy(){
        // Xử lý xóa phiếu lương
        $id = request()->id;
        $luong = LuongNhanVien::findOrFail($id);

        // Kiểm tra xem phiếu lương có tồn tại không
        if (!$luong) {
            return redirect()->back()->with('error', 'Phiếu lương không tồn tại.');
        }

        // Lưu thông tin tháng/năm lương để hiển thị thông báo
        $thang = $luong->luong_thang;
        $nam = $luong->luong_nam;

        // Xóa phiếu lương
        $luong->delete();

        return redirect()->back()->with('success', "Đã xoá phiếu lương tháng {$thang}/{$nam} thành công.");
    }
//    public function guiTatCaMailLuong(Request $request)
// {
//     $thang = $request->thang;
//     $nam = $request->nam;

//     $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
//         ->whereMonth('created_at', $thang)
//         ->whereYear('created_at', $nam)
//         ->get();

//     foreach ($luongs as $luong) {
//         $createdAt = Carbon::parse($luong->created_at);
//         Http::withOptions(['verify' => false])->post('https://quocbinh.app.n8n.cloud/webhook-test/send-email', [
//             'id' => $luong->id,
//             'ten_nhan_vien' => $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten,
//             'email' => $luong->nguoiDung->email,
//             'chuc_vu' => $luong->nguoiDung->chucVu->ten,
//             'thang' => $createdAt->month,
//             'nam' => $createdAt->year,
//             'link_pdf' => route('luong.pdf', [
//                 'user_id' => $luong->nguoiDung->id,
//                 'thang' => $createdAt->month,
//                 'nam' => $createdAt->year
//             ]),
//         ]);
//     }

//     return back()->with('success', 'Đã gửi tất cả phiếu lương thành công.');
// }




public function guiTatCaMailLuong(Request $request)
{
    $thang = $request->thang;
    $nam = $request->nam;

    // Nếu không chọn tháng/năm, mặc định lấy theo đợt lương mới nhất
    if (empty($thang) || empty($nam)) {
        $lastLuong = LuongNhanVien::orderByDesc('created_at')->first();
        if ($lastLuong) {
            $thang = $lastLuong->luong_thang;
            $nam = $lastLuong->luong_nam;
        }
    }

    $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu', 'nguoiDung.phongBan')
        ->when($thang, function ($q) use ($thang) {
            $q->where('luong_thang', $thang);
        })
        ->when($nam, function ($q) use ($nam) {
            $q->where('luong_nam', $nam);
        })
        ->get();

    if ($luongs->isEmpty()) {
        return back()->with('error', 'Không tìm thấy phiếu lương để gửi cho tháng/năm đã chọn.');
    }

    // Xử lý logo base64
    $pathToImage = public_path('assets/images/dvlogo.png');
    $base64 = null;
    if (file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    foreach ($luongs as $luong) {
        $tenNhanVienGoc = ($luong->nguoiDung->hoSo->ho ?? '') . ' ' . ($luong->nguoiDung->hoSo->ten ?? '');
        $tenKhongDau = RemoveNameHelper::removeVietnameseTones($tenNhanVienGoc);
        $tenSlug = Str::slug($tenKhongDau);

        $fileName = "{$tenSlug}_luong_{$thang}_{$nam}.pdf";

        $soCong = $luong->so_ngay_cong;
        $gioTangCa = $luong->gio_tang_ca;
        $tongLuong = $luong->tong_luong;
        $luongThucNhan = $luong->luong_thuc_nhan;
        $luongCoBan = $luong->luong_co_ban;

        $nhanVien = $tenNhanVienGoc;
        $phongBan = $luong->nguoiDung->phongBan->ten_phong_ban ?? '-';
        $chucVu = $luong->nguoiDung->chucVu->ten ?? '-';

        // Sửa lỗi: dùng đúng người của vòng lặp hiện tại để tính công tăng ca
        $congTangCa = DB::table('thuc_hien_tang_ca')
            ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
            ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
            ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
            ->whereYear('thuc_hien_tang_ca.created_at', $nam)
            ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

        $tenNhanVien = $tenNhanVienGoc;
        $data = compact(
            'luong',
            'tenNhanVien',
            'thang',
            'nam',
            'nhanVien',
            'phongBan',
            'chucVu',
            'soCong',
            'gioTangCa',
            'tongLuong',
            'luongThucNhan',
            'luongCoBan',
            'congTangCa',
            'base64'
        );

        try {
            // Xuất PDF tạm
            $pdf = Pdf::loadView('admin.luong.bangluong.pdf', $data);
            $pdfPath = storage_path("app/public/luong/{$fileName}");
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0775, true);
            }

            file_put_contents($pdfPath, $pdf->output());

            // Gửi email
            Mail::to($luong->nguoiDung->email)->send(
                new GuiPhieuLuong($tenNhanVien, $thang, $nam, $pdfPath)
            );
        } catch (\Throwable $e) {
            Log::error('Lỗi gửi phiếu lương', [
                'luong_id' => $luong->id,
                'user_id' => $luong->nguoi_dung_id,
                'message' => $e->getMessage(),
            ]);
            continue; // Không dừng cả batch
        }
    }

    return back()->with('success', 'Đã gửi tất cả phiếu lương qua email thành công!');
}

public function guiMailLuongDaChon(Request $request)
{
    $selectedIds = $request->input('selected_ids', []);

    if (empty($selectedIds) || !is_array($selectedIds)) {
        return back()->with('error', 'Vui lòng chọn ít nhất một phiếu lương.');
    }

    $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu', 'nguoiDung.phongBan')
        ->whereIn('id', $selectedIds)
        ->get();

    if ($luongs->isEmpty()) {
        return back()->with('error', 'Không tìm thấy phiếu lương tương ứng với lựa chọn.');
    }

    // Xử lý logo base64
    $pathToImage = public_path('assets/images/dvlogo.png');
    $base64 = null;
    if (file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    $successCount = 0;
    $failCount = 0;

    foreach ($luongs as $luong) {
        $thang = $luong->luong_thang;
        $nam = $luong->luong_nam;

        $tenNhanVienGoc = ($luong->nguoiDung->hoSo->ho ?? '') . ' ' . ($luong->nguoiDung->hoSo->ten ?? '');
        $tenKhongDau = RemoveNameHelper::removeVietnameseTones($tenNhanVienGoc);
        $tenSlug = Str::slug($tenKhongDau);

        $fileName = "{$tenSlug}_luong_{$thang}_{$nam}.pdf";

        $soCong = $luong->so_ngay_cong;
        $gioTangCa = $luong->gio_tang_ca;
        $tongLuong = $luong->tong_luong;
        $luongThucNhan = $luong->luong_thuc_nhan;
        $luongCoBan = $luong->luong_co_ban;

        $nhanVien = $tenNhanVienGoc;
        $phongBan = $luong->nguoiDung->phongBan->ten_phong_ban ?? '-';
        $chucVu = $luong->nguoiDung->chucVu->ten ?? '-';

        $congTangCa = DB::table('thuc_hien_tang_ca')
            ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
            ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
            ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
            ->whereYear('thuc_hien_tang_ca.created_at', $nam)
            ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

        $tenNhanVien = $tenNhanVienGoc;
        $data = compact(
            'luong',
            'tenNhanVien',
            'thang',
            'nam',
            'nhanVien',
            'phongBan',
            'chucVu',
            'soCong',
            'gioTangCa',
            'tongLuong',
            'luongThucNhan',
            'luongCoBan',
            'congTangCa',
            'base64'
        );

        try {
            $pdf = Pdf::loadView('admin.luong.bangluong.pdf', $data);
            $pdfPath = storage_path("app/public/luong/{$fileName}");
            if (!file_exists(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0775, true);
            }
            file_put_contents($pdfPath, $pdf->output());

            Mail::to($luong->nguoiDung->email)->send(
                new GuiPhieuLuong($tenNhanVien, $thang, $nam, $pdfPath)
            );
            $successCount++;
        } catch (\Throwable $e) {
            $failCount++;
            Log::error('Lỗi gửi phiếu lương (chọn): ' . $e->getMessage(), [
                'luong_id' => $luong->id,
                'user_id' => $luong->nguoi_dung_id,
            ]);
            continue;
        }
    }

    if ($failCount > 0 && $successCount === 0) {
        return back()->with('error', 'Gửi thất bại. Vui lòng kiểm tra cấu hình email hoặc dữ liệu.');
    }

    if ($failCount > 0) {
        return back()->with('success', "Đã gửi {$successCount} phiếu. {$failCount} phiếu bị lỗi (xem log). ");
    }

    return back()->with('success', "Đã gửi {$successCount} phiếu lương qua email thành công!");
}
function removeVietnameseTones($str) {
    $str = preg_replace([
        "/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/",
        "/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/",
        "/(ì|í|ị|ỉ|ĩ)/",
        "/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/",
        "/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/",
        "/(ỳ|ý|ỵ|ỷ|ỹ)/",
        "/(đ)/",
        "/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/",
        "/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/",
        "/(Ì|Í|Ị|Ỉ|Ĩ)/",
        "/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/",
        "/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/",
        "/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/",
        "/(Đ)/"
    ], [
        "a","e","i","o","u","y","d",
        "A","E","I","O","U","Y","D"
    ], $str);
    return $str;
}

/**
 * Tính thuế thu nhập cá nhân theo bảng thuế suất lũy tiến từng phần
 *
 * @param float $thuNhapChiuThue Thu nhập chịu thuế (sau khi trừ các khoản giảm trừ)
 * @return array ['thue_phai_nop' => số tiền thuế, 'thue_suat_ap_dung' => thuế suất cao nhất được áp dụng]
 */
private function tinhThueThueNhapCaNhan($thuNhapChiuThue)
{
    // Bảng thuế suất lũy tiến từng phần (triệu đồng/tháng)
    $bacThue = [
        ['min' => 0, 'max' => 5, 'rate' => 0.05],        // Đến 5 triệu: 5%
        ['min' => 5, 'max' => 10, 'rate' => 0.10],       // Trên 5 đến 10 triệu: 10%
        ['min' => 10, 'max' => 18, 'rate' => 0.15],      // Trên 10 đến 18 triệu: 15%
        ['min' => 18, 'max' => 32, 'rate' => 0.20],      // Trên 18 đến 32 triệu: 20%
        ['min' => 32, 'max' => 52, 'rate' => 0.25],      // Trên 32 đến 52 triệu: 25%
        ['min' => 52, 'max' => 80, 'rate' => 0.30],      // Trên 52 đến 80 triệu: 30%
        ['min' => 80, 'max' => PHP_INT_MAX, 'rate' => 0.35] // Trên 80 triệu: 35%
    ];

    // Chuyển đổi từ VND sang triệu đồng để tính toán
    $thuNhapTrieuDong = $thuNhapChiuThue / 1000000;

    $tongThue = 0;
    $thueSuatApDung = 0;

    foreach ($bacThue as $bac) {
        if ($thuNhapTrieuDong <= $bac['min']) {
            break;
        }

        $thuNhapTrongBac = min($thuNhapTrieuDong, $bac['max']) - $bac['min'];
        $thueTrongBac = $thuNhapTrongBac * $bac['rate'];
        $tongThue += $thueTrongBac;
        $thueSuatApDung = $bac['rate'];

        if ($thuNhapTrieuDong <= $bac['max']) {
            break;
        }
    }

    // Chuyển đổi về VND
    $thuePhaiNop = $tongThue * 1000000;

    return [
        'thue_phai_nop' => round($thuePhaiNop, 0),
        'thue_suat_ap_dung' => $thueSuatApDung * 100 // chuyển về %
    ];
}

/**
 * Kiểm tra xem có được phép tính lương cho tháng/năm này không
 */
private function coDuocPhepTinhLuong($thang, $nam)
{
    $thangHienTai = now()->month;
    $namHienTai = now()->year;

    // Chỉ cho phép tính lương tháng trước khi đã sang tháng mới
    // Ví dụ: đang ở tháng 8 thì chỉ được tính lương tháng 7 trở xuống
    if ($nam < $namHienTai) {
        return true; // Năm trước luôn được phép
    }

    if ($nam == $namHienTai) {
        // Cùng năm, chỉ cho phép tính lương tháng trước
        return $thang < $thangHienTai;
    }

    return false; // Năm tương lai không được phép
}

/**
 * Lấy thông tin tháng/năm hiện tại
 */
private function getThangNamHienTai()
{
    return [
        'thang' => now()->month,
        'nam' => now()->year
    ];
}

/**
 * Kiểm tra trạng thái tính lương của tháng hiện tại
 */

// này ch fix
public function trangThaiTinhLuongHienTai()
{
    $thangNamHienTai = $this->getThangNamHienTai();
    $thang = $thangNamHienTai['thang'];
    $nam = $thangNamHienTai['nam'];

    // Đếm tổng số nhân viên
    $tongNhanVien = NguoiDung::where('da_hoan_thanh_ho_so', 1)->count();

    // Đếm số nhân viên đã được tính lương
    $daTinhLuong = LuongNhanVien::where('luong_thang', $thang)
        ->where('luong_nam', $nam)
        ->count();

    // Đếm số nhân viên chưa được tính lương
    $chuaTinhLuong = $tongNhanVien - $daTinhLuong;

    $trangThai = [
        'thang' => $thang,
        'nam' => $nam,
        'tong_nhan_vien' => $tongNhanVien,
        'da_tinh_luong' => $daTinhLuong,
        'chua_tinh_luong' => $chuaTinhLuong,
        'ti_le_hoan_thanh' => $tongNhanVien > 0 ? round(($daTinhLuong / $tongNhanVien) * 100, 1) : 0
    ];

    return view('admin.luong.tinhluong.trang_thai_tinh_luong', compact('trangThai'));
}

/**
 * Method test để kiểm tra controller
 */
// public function test()
// {
//     $thangHienTai = now()->month;
//     $namHienTai = now()->year;

//     $thangTruoc = $thangHienTai == 1 ? 12 : $thangHienTai - 1;
//     $namTruoc = $thangHienTai == 1 ? $namHienTai - 1 : $namHienTai;

//     $data = [
//         'thang_hien_tai' => $thangHienTai,
//         'nam_hien_tai' => $namHienTai,
//         'thang_truoc' => $thangTruoc,
//         'nam_truoc' => $namTruoc,
//         'co_duoc_phep_tinh_luong_hien_tai' => $this->coDuocPhepTinhLuong($thangHienTai, $namHienTai),
//         'co_duoc_phep_tinh_luong_thang_truoc' => $this->coDuocPhepTinhLuong($thangTruoc, $namTruoc),
//         'message' => 'Controller đang hoạt động bình thường'
//     ];

//     return response()->json($data);
// }

/**
 * Kiểm tra các bản ghi lương vi phạm quy tắc thời gian
 */
public function kiemTraViPhamQuyTac()
{
    $thangHienTai = now()->month;
    $namHienTai = now()->year;

    // Tìm các bản ghi lương được tạo trong tháng hiện tại
    $luongViPham = LuongNhanVien::where('luong_thang', $thangHienTai)
        ->where('luong_nam', $namHienTai)
        ->with(['nguoiDung.hoSo', 'bangLuong'])
        ->get()
        ->map(function ($luong) {
            return [
                'id' => $luong->id,
                'ma_nhan_vien' => $luong->nguoiDung->hoSo->ma_nhan_vien ?? 'N/A',
                'ho_ten' => ($luong->nguoiDung->hoSo->ho ?? '') . ' ' . ($luong->nguoiDung->hoSo->ten ?? ''),
                'luong_thang' => $luong->luong_thang,
                'luong_nam' => $luong->luong_nam,
                'ngay_tao' => $luong->created_at->format('d/m/Y H:i'),
                'trang_thai' => $luong->bangLuong->trang_thai_label ?? 'N/A'
            ];
        });

    $data = [
        'thang_hien_tai' => $thangHienTai,
        'nam_hien_tai' => $namHienTai,
        'so_luong_vi_pham' => $luongViPham->count(),
        'danh_sach_vi_pham' => $luongViPham,
        'message' => 'Kiểm tra hoàn tất'
    ];

    return response()->json($data);
}

//     public function guiTatCaMailLuong(Request $request)
// {
//     $thang = $request->thang;
//     $nam = $request->nam;

//     $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
//         ->whereMonth('created_at', $thang)
//         ->whereYear('created_at', $nam)
//         ->get();
//     //  $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
//     //     ->where('nguoi_dung_id', $user_id)
//     //     ->latest('created_at') // lấy bản ghi mới nhất
//     //     ->first();

//     if (!$luongs) {
//         abort(404, 'Không tìm thấy dữ liệu lương.');
//     }

//     foreach ($luongs as $luong) {
//         // $nhanVien = $luong->nguoiDung;
//         // $tenNhanVien = $nhanVien->hoSo->ho . ' ' . $nhanVien->hoSo->ten;

//     $soCong = $luong->so_ngay_cong;
//     $gioTangCa = $luong->gio_tang_ca;
//     $tongLuong = $luong->tong_luong;
//     $luongThucNhan = $luong->luong_thuc_nhan;
//     $luongCoBan = $luong->luong_co_ban;

//     // Tên nhân viên, phòng ban, chức vụ
//     $nhanVien = $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten ?? '';

//     $phongBan = $luong->nguoiDung->phongBan->ten_phong_ban ?? '-';
//     $chucVu = $luong->nguoiDung->chucVu->ten ?? '-';

//      $congTangCa = DB::table('thuc_hien_tang_ca')
//         ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
//         ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
//         ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
//         ->whereYear('thuc_hien_tang_ca.created_at', $nam)
//         ->sum('thuc_hien_tang_ca.so_cong_tang_ca');


//     // Xử lý logo base64
//     $pathToImage = public_path('assets/images/dvlogo.png');
//     $base64 = null;
//     if (file_exists($pathToImage)) {
//         $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
//         $data = file_get_contents($pathToImage);
//         $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//     }


//         // ✅ Tạo nội dung PDF
//          $data = compact(
//         'luong',
//         'nhanVien',
//         'phongBan',
//         'chucVu',
//         'thang',
//         'nam',
//         'soCong',
//         'gioTangCa',
//         'tongLuong',
//         'luongThucNhan',
//         'luongCoBan',
//         'congTangCa',
//         'base64'
//     );

//     $pdf = PDF::loadView('admin.luong.bangluong.pdf', $data);

//         // ✅ Tạo tên file duy nhất
//         $fileName = Str::slug($nhanVien) . "_luong_{$thang}_{$nam}.pdf";
//         $filePath = "luong/{$fileName}";

//         // ✅ Lưu file vào storage/app/public/luong/
//         Storage::disk('public')->put($filePath, $pdf->output());

//         // ✅ Tạo link công khai
//         $linkPDF = asset('storage/' . $filePath);
//         $createdAt = Carbon::parse($luong->created_at);
//         // ✅ Gửi sang webhook n8n
//         Http::withOptions(['verify' => false])->post('https://quocbinh.app.n8n.cloud/webhook-test/send-email', [

//             'id' => $luong->id,
//             'ten_nhan_vien' => $nhanVien,
//             'email' => $luong->nguoiDung->email,
//             'chuc_vu' => $chucVu,
//             'thang' => $createdAt->month,
//             'nam' => $createdAt->year,
//             'link_pdf' => $linkPDF, // ✅ Link thật, không còn là localhost
//         ]);
//     }

//     return back()->with('success', 'Đã gửi tất cả phiếu lương thành công.');
// }


// Lương cho Employee

    public function listEmploy(Request $request){
         $nguoiDungId = Auth::id();
         $query = LuongNhanVien::where('nguoi_dung_id', $nguoiDungId)
            ->orderByDesc('created_at');
             if ($request->thang) {
            $query->whereMonth('created_at', $request->thang);
        }

        if ($request->nam) {
            $query->whereYear('created_at', $request->nam);
        }

        $luongs = $query->get();

        return view('employe.luong.list', compact('luongs'));

    }

    public function listLuong(Request $request){
        $thang = $request->thang ?? now()->month;
        $nam = $request->nam ?? now()->year;

        $query = Luong::with(['nguoiDung.hoSo', 'nguoiDung.chucVu', 'hopDongLaoDong'])
            ->orderBy('created_at', 'desc');

        // Lọc theo tháng/năm nếu có
        if ($request->thang) {
            $query->whereMonth('created_at', $request->thang);
        }

        if ($request->nam) {
            $query->whereYear('created_at', $request->nam);
        }

        $luongs = $query->paginate(6)->appends(request()->query());

        return view('admin.luong.list', compact('luongs', 'thang', 'nam'));
    }

    public function edit($id)
    {
        $luong = Luong::with(['nguoiDung.hoSo', 'nguoiDung.chucVu', 'hopDongLaoDong'])->findOrFail($id);
        return view('admin.luong.edit', compact('luong'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'luong_co_ban' => 'required|numeric|min:0',
            'phu_cap' => 'nullable|numeric|min:0',
        ], [
            'luong_co_ban.required' => 'Lương cơ bản không được để trống.',
            'luong_co_ban.numeric' => 'Lương cơ bản phải là số.',
            'luong_co_ban.min' => 'Lương cơ bản không được âm.',
            'phu_cap.numeric' => 'Phụ cấp phải là số.',
            'phu_cap.min' => 'Phụ cấp không được âm.',
        ]);

        $luong = Luong::findOrFail($id);
        $luong->update([
            'luong_co_ban' => $request->luong_co_ban,
            'phu_cap' => $request->phu_cap ?? 0,
        ]);

        return redirect()->route('luong.list')->with('success', 'Cập nhật lương thành công.');
    }

    public function delete($id)
    {
        $luong = Luong::findOrFail($id);
        $luong->delete();

        return redirect()->route('luong.list')->with('success', 'Xóa lương thành công.');
    }

    /**
     * Thống kê lương
     */
    public function thongKe(Request $request)
    {
        // Lấy tham số từ request
        $tuNgay = $request->tu_ngay ?? now()->startOfMonth()->format('Y-m-d');
        $denNgay = $request->den_ngay ?? now()->endOfMonth()->format('Y-m-d');
        $namHienTai = now()->year;

        // Thống kê tổng quan
        $tongLuongNhanVien = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])->count();
        $tongTienLuong = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])->sum('tong_luong');
        $tongLuongThucNhan = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])->sum('luong_thuc_nhan');
        $tongThue = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])->sum('thue_thu_nhap_ca_nhan');
        $tongPhuCap = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])->sum('tong_phu_cap');

        // Thống kê theo phòng ban
        $thongKeTheoPhongBan = LuongNhanVien::join('nguoi_dung', 'luong_nhan_vien.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->join('phong_ban', 'nguoi_dung.phong_ban_id', '=', 'phong_ban.id')
            ->whereBetween('luong_nhan_vien.created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->selectRaw('phong_ban.ten_phong_ban, COUNT(*) as so_nhan_vien, SUM(tong_luong) as tong_luong, AVG(tong_luong) as luong_trung_binh')
            ->groupBy('phong_ban.id', 'phong_ban.ten_phong_ban')
            ->orderBy('tong_luong', 'desc')
            ->get();

        // Thống kê theo chức vụ
        $thongKeTheoChucVu = LuongNhanVien::join('nguoi_dung', 'luong_nhan_vien.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->join('chuc_vu', 'nguoi_dung.chuc_vu_id', '=', 'chuc_vu.id')
            ->whereBetween('luong_nhan_vien.created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->selectRaw('chuc_vu.ten as ten_chuc_vu, COUNT(*) as so_nhan_vien, SUM(tong_luong) as tong_luong, AVG(tong_luong) as luong_trung_binh')
            ->groupBy('chuc_vu.id', 'chuc_vu.ten')
            ->orderBy('tong_luong', 'desc')
            ->get();

        // Thống kê theo tháng trong năm
        $thongKeTheoThang = LuongNhanVien::whereYear('created_at', $namHienTai)
            ->selectRaw('MONTH(created_at) as thang, COUNT(*) as so_nhan_vien, SUM(tong_luong) as tong_luong, AVG(tong_luong) as luong_trung_binh')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('thang')
            ->get();

        // Thống kê theo năm
        $thongKeTheoNam = LuongNhanVien::selectRaw('YEAR(created_at) as nam, COUNT(*) as so_nhan_vien, SUM(tong_luong) as tong_luong, AVG(tong_luong) as luong_trung_binh')
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('nam', 'desc')
            ->get();

        // Thống kê lương cơ bản theo phòng ban
        $thongKeLuongCoBan = LuongNhanVien::join('nguoi_dung', 'luong_nhan_vien.nguoi_dung_id', '=', 'nguoi_dung.id')
            ->join('phong_ban', 'nguoi_dung.phong_ban_id', '=', 'phong_ban.id')
            ->whereBetween('luong_nhan_vien.created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->selectRaw('phong_ban.ten_phong_ban, AVG(luong_co_ban) as luong_co_ban_trung_binh, MIN(luong_co_ban) as luong_co_ban_thap_nhat, MAX(luong_co_ban) as luong_co_ban_cao_nhat')
            ->groupBy('phong_ban.id', 'phong_ban.ten_phong_ban')
            ->orderBy('luong_co_ban_trung_binh', 'desc')
            ->get();

        // Thống kê tăng ca
        $thongKeTangCa = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->selectRaw('SUM(gio_tang_ca) as tong_gio_tang_ca, AVG(gio_tang_ca) as gio_tang_ca_trung_binh, SUM(cong_tang_ca) as tong_cong_tang_ca')
            ->first();

        // Thống kê thuế
        $thongKeThue = LuongNhanVien::whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->selectRaw('SUM(thue_thu_nhap_ca_nhan) as tong_thue, AVG(thue_thu_nhap_ca_nhan) as thue_trung_binh')
            ->first();

        // Top 10 nhân viên có lương cao nhất
        $topLuongCaoNhat = LuongNhanVien::with(['nguoiDung.hoSo', 'nguoiDung.phongBan'])
            ->whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->orderBy('tong_luong', 'desc')
            ->limit(10)
            ->get();

        // Top 10 nhân viên có lương thấp nhất
        $topLuongThapNhat = LuongNhanVien::with(['nguoiDung.hoSo', 'nguoiDung.phongBan'])
            ->whereBetween('created_at', [$tuNgay, $denNgay . ' 23:59:59'])
            ->orderBy('tong_luong', 'asc')
            ->limit(10)
            ->get();

        return view('admin.luong.thong-ke', compact(
            'tuNgay',
            'denNgay',
            'namHienTai',
            'tongLuongNhanVien',
            'tongTienLuong',
            'tongLuongThucNhan',
            'tongThue',
            'tongPhuCap',
            'thongKeTheoPhongBan',
            'thongKeTheoChucVu',
            'thongKeTheoThang',
            'thongKeTheoNam',
            'thongKeLuongCoBan',
            'thongKeTangCa',
            'thongKeThue',
            'topLuongCaoNhat',
            'topLuongThapNhat'
        ));
    }
}
