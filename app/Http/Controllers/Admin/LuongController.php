<?php
namespace App\Http\Controllers\Admin;

use App\Models\ChamCong;

// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\PDF;
use App\Models\BangLuong;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use App\Models\LuongNhanVien;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\thucHienTangCa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\LuongNhanVienExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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

    // Tên nhân viên, phòng ban, chức vụ
    $nhanVien = $luong->nguoiDung->hoSo->ho . ' ' . $luong->nguoiDung->hoSo->ten ?? '';

    $phongBan = $luong->nguoiDung->phongBan->ten_phong_ban ?? '-';
    $chucVu = $luong->nguoiDung->chucVu->ten ?? '-';

     $congTangCa = DB::table('thuc_hien_tang_ca')
        ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
        ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
        ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
        ->whereYear('thuc_hien_tang_ca.created_at', $nam)
        ->sum('thuc_hien_tang_ca.so_cong_tang_ca');


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
        'base64'
    );

    $pdf = PDF::loadView('admin.luong.bangluong.pdf', $data);

    return $pdf->download("phieu_luong_NV{$user_id}_{$thang}_{$nam}.pdf");
}



  public function index(Request $request)
{
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;
    $ngay = $request->ngay ?? now()->day;

    $luongs = LuongNhanVien::with('nguoiDung.hoSo', 'bangLuong', 'nguoiDung.chucVu')
    ->whereMonth('created_at', $thang)
    ->whereYear('created_at', $nam)
    ->orderBy('created_at', 'desc')
    ->paginate(10)
    ->appends(request()->query());

    return view('admin.luong.bangluong.index', compact('luongs', 'thang', 'nam', 'ngay'));
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
    $congTangCa = DB::table('thuc_hien_tang_ca')
        ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
        ->where('dang_ky_tang_ca.nguoi_dung_id', $luong->nguoi_dung_id)
        ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
        ->whereYear('thuc_hien_tang_ca.created_at', $nam)
        ->sum('thuc_hien_tang_ca.so_cong_tang_ca');

    return view('admin.luong.bangluong.chitietphieuluong', compact(
        'luong',
        'thang',
        'nam',
        'ngay',
        'base64',
        'congTangCa'
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

    // Tạo bảng lương
    $bangLuong = BangLuong::create([
        'ma_bang_luong' => $maBangLuong,
        'nam' => Carbon::parse($request->ngay_tinh_luong)->year,
        'thang' => Carbon::parse($request->ngay_tinh_luong)->month,
        'ngay_tra_luong' => now()->endOfMonth()->format('Y-m-d'),
        'trang_thai' => 'dang_xu_ly',
        'nguoi_xu_ly_id' => auth()->id(),
        'thoi_gian_xu_ly' => Carbon::now(),
    ]);

    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;

    $nguoiDung = NguoiDung::with('chucVu')->find($request->nguoi_dung_id);

    if (!$nguoiDung || !$nguoiDung->chucVu) {
        return back()->with('error', 'Không tìm thấy thông tin người dùng hoặc chức vụ.');
    }

    $chucVu = $nguoiDung->chucVu;
    $luongCoBan = $chucVu->luong_co_ban;
    $heSoLuong = $chucVu->he_so_luong ?? 1;

    // ======= 1. SỐ NGÀY CÔNG =======
    if ($request->filled('so_ngay_cong')) {
                // dd('CHẠY VÀO IF: Dùng số công tăng ca từ form gửi lên', $request->so_ngay_cong);

        $soNgayCong = (float) $request->so_ngay_cong;
    } else {
                    // dd('CHẠY VÀO ELSE: Dùng số công tăng ca từ DB');

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
        // dd('CHẠY VÀO IF: Dùng số công tăng ca từ form gửi lên', $request->so_cong_tang_ca);

        $tongCongTangCa = (float) $request->so_cong_tang_ca;

    } else {
//  dd('CHẠY VÀO ELSE: Dùng số công tăng ca từ DB');
        $tongCongTangCa = DB::table('thuc_hien_tang_ca')
            ->join('dang_ky_tang_ca', 'thuc_hien_tang_ca.dang_ky_tang_ca_id', '=', 'dang_ky_tang_ca.id')
            ->where('dang_ky_tang_ca.nguoi_dung_id', $nguoiDung->id)
            ->whereMonth('thuc_hien_tang_ca.created_at', $thang)
            ->whereYear('thuc_hien_tang_ca.created_at', $nam)
            ->sum('thuc_hien_tang_ca.so_cong_tang_ca');
    }

    // ======= 3. TÍNH TOÁN LƯƠNG =======
    //ví dụ soNgayCong = 8, tongCongTangCa = 2, luongCoBan = 21tr, heSoLuong = 1
    $luongNgay = ($luongCoBan * $heSoLuong) / 26; // 21tr / 8 = 2.625.000

    $donGiaGio = $luongCoBan / 173; // = 121.387,28323699

    $luongTangCa = $tongCongTangCa * 8 * $donGiaGio; // = 1.942.196,5317919

    $tongLuong = $luongNgay * $soNgayCong; // = 21000000.0
    $luongThucNhan = $tongLuong + $luongTangCa; // 21tr + 1.942.196,53

    // ======= 4. LƯU DỮ LIỆU =======
    LuongNhanVien::create([
        'bang_luong_id' => $bangLuong->id,
        'nguoi_dung_id' => $nguoiDung->id,
        'luong_co_ban' => $luongCoBan,
        'tong_luong' => round($tongLuong, 0),
        'luong_thuc_nhan' => round($luongThucNhan, 0),
        'so_ngay_cong' => $soNgayCong,
        'gio_tang_ca' => $tongCongTangCa * 8,
        'cong_tang_ca' => $tongCongTangCa,
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


}
