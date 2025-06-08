<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\LuongNhanVien;
use Illuminate\Http\Request;

class BangLuongController extends Controller
{
    public function index(){
        $id ="1";

      $bangLuongNhanVien = LuongNhanVien::with(['bangLuong' => function ($query) {
            $query->select('id', 'thang', 'nam', 'trang_thai');
        }])
        ->where('nguoi_dung_id', $id)
        ->orderByDesc('id')
        ->get(['id', 'luong_co_ban', 'tong_phu_cap', 'tong_khau_tru', 'luong_thuc_nhan', 'bang_luong_id']);

        // dd($bangLuongNhanVien->trang_thai_label['class']);
        return view('employe.salary.index' , compact('bangLuongNhanVien'));
    }
    public function show($id){
        $bangLuongChiTiet = LuongNhanVien::with([
        'nguoiDung.hoSo:id,nguoi_dung_id,ma_nhan_vien,ho,ten',
        'nguoiDung.phongBan:id,ten_phong_ban',
        'nguoiDung.chucVu:id,ten',
        'bangLuong:id,thang,nam,trang_thai',
        'phuCapLuong',
        'khauTruLuong',
        'nguoiDung.chamCong',
    ])->findOrFail($id);
    // $idPhuCap = $bangLuongChiTiet->phuCapLuong->id;
    // dd($bangLuongChiTiet->nguoiDung->chamCong->where('')->first());
    // Tối ưu việc tạo danh sách phụ cấp
    $danhSachPhuCap = $bangLuongChiTiet->phuCapLuong->map(function ($phuCapLuong) {
        return [
            'ten_phu_cap' => $phuCapLuong->phuCap?->ten ?? 'Không rõ',
            'so_tien' => $phuCapLuong->so_tien,
        ];
    })->toArray();
      // Tối ưu việc tạo danh sách khấu trừ
    $danhSachKhauTru = $bangLuongChiTiet->khauTruLuong->map(function ($khauTruLuong) {
        return [
            'ten_khau_tru' => $khauTruLuong->loai_khau_tru_label ?? 'Không rõ',
            'so_tien' => $khauTruLuong->so_tien,
        ];
    })->toArray();
    // Lấy tháng và năm từ bảng lương
    $thang = $bangLuongChiTiet->bangLuong->thang;
    $nam = $bangLuongChiTiet->bangLuong->nam;
    $nguoiDungId = $bangLuongChiTiet->nguoi_dung_id;
    // Tính toán thông tin chấm công trong tháng
    $thongTinChamCong = $this->layThongTinChamCong($nguoiDungId, $thang, $nam);
    // Tính toán thông tin nghỉ phép trong tháng
    $thongTinNghiPhep = $this->layThongTinNghiPhep($nguoiDungId, $thang, $nam);

    // dd($thongTinNghiPhep);
    $phuCapLuong = $bangLuongChiTiet->phuCapLuong->where('phu_cap_id', 1)->first();
    $nguoiDung = $bangLuongChiTiet->nguoiDung;
    $hoSo = $nguoiDung->hoSo;
    $phongBan = $nguoiDung->phongBan;
    $chucVu = $nguoiDung->chucVu;
    $bangLuong = $bangLuongChiTiet->bangLuong;
    // dd($bangLuongChiTiet->phuCapLuong);
        return view('employe.salary.show', compact(
            'bangLuongChiTiet',
            'nguoiDung',
            'hoSo',
            'phongBan',
            'chucVu',
            'bangLuong',
            'danhSachPhuCap',
            'danhSachKhauTru',
            'thongTinChamCong',
            'thongTinNghiPhep'
        ));
    }
    /**
 * Lấy thông tin chấm công trong tháng
 */
private function layThongTinChamCong($nguoiDungId, $thang, $nam)
{
    // Tạo ngày đầu và cuối tháng
    $ngayDau = \Carbon\Carbon::createFromDate($nam, $thang, 1)->startOfMonth();
    $ngayCuoi = \Carbon\Carbon::createFromDate($nam, $thang, 1)->endOfMonth();

    // Lấy dữ liệu chấm công trong tháng
    $chamCongData = \App\Models\ChamCong::where('nguoi_dung_id', $nguoiDungId)
        ->whereBetween('ngay_cham_cong', [$ngayDau, $ngayCuoi])
        ->get();

    // Tính toán các thông số
    $soNgayChamCong = $chamCongData->where('trang_thai', 'binh_thuong')->count();
    $soGioLamThem = $chamCongData->sum('gio_tang_ca');
    $soLanDiMuon = $chamCongData->where('phut_di_muon', '>', 0)->count();
    $soLanVeSom = $chamCongData->where('phut_ve_som', '>', 0)->count();

    return [
        'so_ngay_cham_cong' => $soNgayChamCong,
        'so_gio_lam_them' => round($soGioLamThem, 1),
        'so_lan_di_muon' => $soLanDiMuon,
        'so_lan_ve_som' => $soLanVeSom,
        'tong_phut_di_muon' => $chamCongData->sum('phut_di_muon'),
        'tong_phut_ve_som' => $chamCongData->sum('phut_ve_som'),
    ];
}
/**
 * Lấy thông tin nghỉ phép trong tháng
 */
private function layThongTinNghiPhep($nguoiDungId, $thang, $nam)
{
    // Tạo ngày đầu và cuối tháng
    $ngayDau = \Carbon\Carbon::createFromDate($nam, $thang, 1)->startOfMonth();
    $ngayCuoi = \Carbon\Carbon::createFromDate($nam, $thang, 1)->endOfMonth();

    // Lấy các đơn xin nghỉ đã được duyệt trong tháng
    $donXinNghiTrongThang = \App\Models\DonXinNghi::where('nguoi_dung_id', $nguoiDungId)
        ->where('trang_thai', 'da_duyet') // Giả sử trạng thái đã duyệt
        ->with('loaiNghiPhep')
        ->where(function($query) use ($ngayDau, $ngayCuoi) {
            $query->whereBetween('ngay_bat_dau', [$ngayDau, $ngayCuoi])
                  ->orWhereBetween('ngay_ket_thuc', [$ngayDau, $ngayCuoi])
                  ->orWhere(function($subQuery) use ($ngayDau, $ngayCuoi) {
                      $subQuery->where('ngay_bat_dau', '<=', $ngayDau)
                               ->where('ngay_ket_thuc', '>=', $ngayCuoi);
                  });
        })
        ->get();
        // dd($donXinNghiTrongThang);
    // Tính số ngày nghỉ thực tế trong tháng cho mỗi đơn
    $tongNgayNghiCoLuong = 0;
    $tongNgayNghiKhongLuong = 0;

    foreach ($donXinNghiTrongThang as $don) {
        // Tính số ngày nghỉ thực tế trong tháng
        // $ngayBatDauTrongThang = max($don->ngay_bat_dau, $ngayDau);
        // $ngayKetThucTrongThang = min($don->ngay_ket_thuc, $ngayCuoi);

        // $soNgayNghiTrongThang = $ngayBatDauTrongThang->diffInDays($ngayKetThucTrongThang) + 1;
        $soNgayNghiTrongThang = $don->so_ngay_nghi;
        // dd($don);
        // Phân loại theo có lương hay không
        if ($don->loaiNghiPhep && $don->loaiNghiPhep->co_luong) {
            $tongNgayNghiCoLuong += $soNgayNghiTrongThang;
        } else {
            $tongNgayNghiKhongLuong += $soNgayNghiTrongThang;
        }
    }

    return [
        'so_ngay_nghi_phep' => $tongNgayNghiCoLuong,
        'so_ngay_nghi_khong_luong' => $tongNgayNghiKhongLuong,
    ];
}

}
