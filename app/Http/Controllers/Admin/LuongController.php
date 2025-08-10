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
  public function luongPdf($user_id, $thang, $nam)
{

   $luong = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
        ->where('nguoi_dung_id', $user_id)
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
    $congOT = $luong->cong_tang_ca ?? 0; // Công tăng ca nếu có, mặc định là 0 nếu không có
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
        'congOT',
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
            $query->whereMonth('created_at', $thang);
        })
        ->when($nam, function ($query) use ($nam) {
            $query->whereYear('created_at', $nam);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->appends(request()->query());

    $dsLuong = BangLuong::with('luongNhanVien')->get();

    return view('admin.luong.bangluong.index', compact('luongs', 'thang', 'nam', 'ngay', 'dsLuong'));
}

  public function chiTietPhieuLuong(Request $request, $id)
{
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;
    $ngay = $request->ngay ?? now()->day;

    $luong = LuongNhanVien::with('nguoiDung.hoSo', 'bangLuong', 'nguoiDung.chucVu')
        ->where('id', $id)
        ->whereMonth('created_at', $thang)
        ->whereYear('created_at', $nam)
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
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;

    $nhanViens = NguoiDung::where('da_hoan_thanh_ho_so', 1)
        ->with('hoSo')
        ->get();

    // Tạo mã bảng lương ngẫu nhiên
    $maBangLuong = 'DVT' . mt_rand(1000000, 9999999);

    // Lấy số công của từng nhân viên trong tháng/năm hiện tại
    $bangChamCong = DB::table('cham_cong')
        ->select('nguoi_dung_id', DB::raw('SUM(so_cong) as tong_so_cong'))
        ->whereMonth('ngay_cham_cong', $thang)
        ->whereYear('ngay_cham_cong', $nam)
        ->groupBy('nguoi_dung_id')
        ->pluck('tong_so_cong', 'nguoi_dung_id'); // dạng [id => công]


   $congTangCa = [];

foreach ($nhanViens as $nhanVien) {
    $soCongTangCa = DB::table('thuc_hien_tang_ca')
        ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
        ->where('dang_ky_tang_ca.nguoi_dung_id', $nhanVien->id)
        ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
        ->whereYear('thuc_hien_tang_ca.created_at', $nam)
        ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

    $congTangCa[$nhanVien->id] = $soCongTangCa;
}


    // dd($congTangCa); // test từng nhân viên




    return view('admin.luong.tinhluong.tinh_luong', compact(
        'nhanViens',
        'maBangLuong',
        'bangChamCong',
        'congTangCa',
        'thang',
        'nam'
    ));
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
    // Tạo mã bảng lương
    $maBangLuong = $request->ma_bang_luong;
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;

    // Tạo bảng lương
    $bangLuong = BangLuong::create([
        'ma_bang_luong' => $maBangLuong,
        'nam' => Carbon::parse($request->ngay_tinh_luong)->year,
        'thang' => Carbon::parse($request->ngay_tinh_luong)->month,
        // 'ngay_tra_luong' => now()->endOfMonth()->format('Y-m-d'),
        'trang_thai' => 'dang_xu_ly',
        'nguoi_xu_ly_id' => auth()->id(),
        'thoi_gian_xu_ly' => Carbon::now(),
    ]);

    $nguoiDung = NguoiDung::with('chucVu', 'hopDongLaoDongMoiNhat')->find($request->nguoi_dung_id);

    if (!$nguoiDung || !$nguoiDung->chucVu) {
        return back()->with('error', 'Không tìm thấy thông tin người dùng hoặc chức vụ.');
    }

    // Lấy thông tin lương cơ bản từ bảng luong
    $luongCoBanRecord = Luong::where('nguoi_dung_id', $request->nguoi_dung_id)->first();

    if (!$luongCoBanRecord) {
        return back()->with('error', 'Không tìm thấy lương cơ bản cho nhân viên này.');
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
    LuongNhanVien::create([
        'bang_luong_id' => $bangLuong->id,
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
        'ghi_chu' => null,
    ]);

    return redirect()->back()->with('success', 'Đã tính và lưu lương cho nhân viên');
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

        // Xóa phiếu lương
        $luong->delete();

        return redirect()->back()->with('success', 'Đã xoá phiếu lương thành công.');
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

    $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'nguoiDung.chucVu')
        ->whereMonth('created_at', $thang)
        ->whereYear('created_at', $nam)
        ->get();

    // Tên nhân viên, phòng ban, chức vụ




    // Xử lý logo base64
    $pathToImage = public_path('assets/images/dvlogo.png');
    $base64 = null;
    if (file_exists($pathToImage)) {
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }




    foreach ($luongs as $luong) {

    $tenNhanVienGoc = $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten;
    $tenKhongDau = RemoveNameHelper::removeVietnameseTones($tenNhanVienGoc);
    $tenSlug = Str::slug($tenKhongDau); // le-quoc-binh


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
        ->where('dang_ky_tang_ca.nguoi_dung_id', $luongs->first()->nguoiDung->id)
        ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
        ->whereYear('thuc_hien_tang_ca.created_at', $nam)
        ->sum('thuc_hien_tang_ca.so_cong_tang_ca');


        $tenNhanVien = $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten ?? '';
        $data = compact('luong', 'tenNhanVien', 'thang', 'nam','nhanVien',
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
        'base64');

        // Xuất PDF tạm
        $pdf = Pdf::loadView('admin.luong.bangluong.pdf', $data);
        $fileName = "{$tenSlug}_luong_{$thang}_{$nam}.pdf";
        $pdfPath = storage_path("app/public/luong/{$fileName}");
        // Kiểm tra và tạo thư mục nếu chưa có
        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0775, true);
        }

        // Ghi file
        file_put_contents($pdfPath, $pdf->output());

        // Gửi email
        Mail::to($luong->nguoiDung->email)->send(
            new GuiPhieuLuong($tenNhanVien, $thang, $nam, $pdfPath)
        );
    }

    return back()->with('success', 'Đã gửi tất cả phiếu lương qua email thành công!');
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

        $luongs = $query->paginate(10)->appends(request()->query());

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
}