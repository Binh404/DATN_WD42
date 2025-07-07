<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChamCong;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class LuongController extends Controller
{
   public function tongLuong(Request $request)
{
    // Ưu tiên lấy từ request, nếu không có thì mặc định tháng/năm hiện tại
    $thang = $request->thang ?? now()->month;
    $nam = $request->nam ?? now()->year;

    $query = DB::table('nguoi_dung')
        ->join('cham_cong', 'nguoi_dung.id', '=', 'cham_cong.nguoi_dung_id')
        ->join('ho_so_nguoi_dung', 'nguoi_dung.id', '=', 'ho_so_nguoi_dung.nguoi_dung_id')
        ->leftJoin('chuc_vu', 'nguoi_dung.chuc_vu_id', '=', 'chuc_vu.id')
        ->whereMonth('cham_cong.ngay_cham_cong', $thang)
        ->whereYear('cham_cong.ngay_cham_cong', $nam);

    $luongTheoNguoi = $query
        ->select(
            'nguoi_dung.id',
            DB::raw("CONCAT(ho_so_nguoi_dung.ho, ' ', ho_so_nguoi_dung.ten) as ho_ten"),
            DB::raw('SUM(cham_cong.so_gio_lam) as tong_gio_lam'),
            DB::raw('SUM(cham_cong.so_cong) as tong_cong'),
            DB::raw('COALESCE(chuc_vu.luong_toi_thieu, 10400000) / 173 as don_gia_gio'),
            DB::raw('SUM(cham_cong.so_gio_lam) * (COALESCE(chuc_vu.luong_toi_thieu, 10400000) / 173) as tong_luong')
        )
        ->groupBy('nguoi_dung.id', 'ho_so_nguoi_dung.ho', 'ho_so_nguoi_dung.ten', 'chuc_vu.luong_toi_thieu')
        ->get();

    return view('admin.luong.index', compact('luongTheoNguoi', 'thang', 'nam'));
}


    public function phieuLuongIndex(Request $request)
    {
        $thang = $request->thang ?? date('m');
        $nam = $request->nam ?? date('Y');

        $nhanVien = NguoiDung::whereHas('hoSo')->get();

        $luongTheoNguoi = $nhanVien->map(function ($nv) use ($thang, $nam) {
            $tongGioLam = ChamCong::where('nguoi_dung_id', $nv->id)
                ->whereMonth('ngay_cham_cong', $thang)
                ->whereYear('ngay_cham_cong', $nam)
                ->sum('so_gio_lam');

            $chucVu = DB::table('chuc_vu')->where('id', $nv->chuc_vu_id)->first();
            $donGiaGio = isset($chucVu->luong_toi_thieu) ? $chucVu->luong_toi_thieu / 173 : 60000;
            $tongLuong = $tongGioLam * $donGiaGio;

            return [
                'id' => $nv->id,
                'ho_ten' => optional($nv->hoSo)->ho . ' ' . optional($nv->hoSo)->ten,
                'tong_gio_lam' => $tongGioLam,
                'tong_luong' => $tongLuong,
            ];
        });

        return view('admin.luong.phieuluong', compact('luongTheoNguoi', 'thang', 'nam'));
    }

    public function xemPhieuLuong($user_id, $thang, $nam)
    {
        $nhanVien = DB::table('ho_so_nguoi_dung')
            ->join('nguoi_dung', 'nguoi_dung.id', '=', 'ho_so_nguoi_dung.nguoi_dung_id')
            ->leftJoin('phong_ban', 'phong_ban.id', '=', 'nguoi_dung.phong_ban_id')
            ->leftJoin('chuc_vu', 'chuc_vu.id', '=', 'nguoi_dung.chuc_vu_id')
            ->where('nguoi_dung.id', $user_id)
            ->select(
                'ho_so_nguoi_dung.*',
                'nguoi_dung.email',
                'phong_ban.ten_phong_ban',
                'chuc_vu.ten as chuc_vu',
                'chuc_vu.luong_toi_thieu'
            )
            ->first();

        $tongGioLam = DB::table('cham_cong')
            ->where('nguoi_dung_id', $user_id)
            ->whereMonth('ngay_cham_cong', $thang)
            ->whereYear('ngay_cham_cong', $nam)
            ->sum('so_gio_lam');

        $luongTheoGio = isset($nhanVien->luong_toi_thieu) && $nhanVien->luong_toi_thieu > 0
            ? $nhanVien->luong_toi_thieu / 173
            : 60000;

        $tongLuong = $tongGioLam * $luongTheoGio;

        $soCong = round($tongGioLam / 8);
        $nghiCoLuong = 1;
        $nghiKhongLuong = 0;

        $pathToImage = public_path('assets/images/dvlogo.png');
        $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
        $data = file_get_contents($pathToImage);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return view('admin.luong.chitietphieuluong', compact(
            'nhanVien',
            'thang',
            'nam',
            'tongGioLam',
            'tongLuong',
            'nghiCoLuong',
            'nghiKhongLuong',
            'soCong',
            'base64'
        ));
    }

   public function exportPDF($user_id, $thang, $nam)
{
    $nhanVien = DB::table('ho_so_nguoi_dung')
        ->join('nguoi_dung', 'nguoi_dung.id', '=', 'ho_so_nguoi_dung.nguoi_dung_id')
        ->leftJoin('phong_ban', 'phong_ban.id', '=', 'nguoi_dung.phong_ban_id')
        ->leftJoin('chuc_vu', 'chuc_vu.id', '=', 'nguoi_dung.chuc_vu_id')
        ->where('nguoi_dung.id', $user_id)
        ->select('ho_so_nguoi_dung.*', 'nguoi_dung.email', 'phong_ban.ten_phong_ban', 'chuc_vu.luong_toi_thieu')
        ->first();

    if (!$nhanVien) {
        abort(404, 'Không tìm thấy nhân viên.');
    }

    $tongGioLam = DB::table('cham_cong')
        ->where('nguoi_dung_id', $user_id)
        ->whereMonth('ngay_cham_cong', $thang)
        ->whereYear('ngay_cham_cong', $nam)
        ->sum('so_gio_lam');

    $luongCoBan = $nhanVien->luong_toi_thieu ?? 0;
    $luongTheoGio = $luongCoBan > 0 ? $luongCoBan / 173 : 60000;

    $tongLuong = $tongGioLam * $luongTheoGio;
    $soCong = round($tongGioLam / 8, 2);

    $pathToImage = public_path('assets/images/dvlogo.png');
    $type = pathinfo($pathToImage, PATHINFO_EXTENSION);
    $data = file_get_contents($pathToImage);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $data = compact(
        'nhanVien',
        'thang',
        'nam',
        'tongGioLam',
        'soCong',
        'tongLuong',
        'base64'


    );

    $pdf = PDF::loadView('admin.luong.pdf', $data);

    return $pdf->download("phieu_luong_NV{$user_id}_{$thang}_{$nam}.pdf");
}

}