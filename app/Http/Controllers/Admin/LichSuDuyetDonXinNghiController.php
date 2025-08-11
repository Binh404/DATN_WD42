<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChamCong;
use App\Models\DonXinNghi;
use App\Models\LichSuDuyetDonNghi;
use App\Models\NguoiDung;
use App\Models\SoDuNghiPhepNhanVien;
use App\Models\VaiTro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LichSuDuyetDonXinNghiController extends Controller
{
    public function duyetDonXinNghi($id)
    {
        $user = auth()->user();
        $vaiTro = VaiTro::find($user->vai_tro_id);

        if (!$vaiTro || !in_array($vaiTro->ten, ['department', 'hr', 'admin'])) {
            return redirect()->back()->with('error', 'Bạn không có quyền duyệt đơn.');
        }

        $donXinNghi = DonXinNghi::findOrFail($id);
        $ngayBatDau = $donXinNghi->ngay_bat_dau;
        $ngayKetThuc = $donXinNghi->ngay_ket_thuc;
        // dd($ngayBatDau, $ngayKetThuc);
        // Gán cấp duyệt theo vai trò
        $capDuyet = $vaiTro->ten == 'department' ? 1 : ($vaiTro->ten == 'hr' ? 2 : 3);

        // Kiểm tra đã duyệt cấp này chưa
        $daDuyet = LichSuDuyetDonNghi::where('don_xin_nghi_id', $id)
            ->where('cap_duyet', $capDuyet)
            ->exists();

        if ($daDuyet) {
            return redirect()->back()->with('error', 'Đơn này đã được duyệt ở cấp của bạn.');
        }

        // Ghi lịch sử duyệt
        LichSuDuyetDonNghi::create([
            'don_xin_nghi_id' => $id,
            'cap_duyet' => $capDuyet,
            'nguoi_duyet_id' => $user->id,
            'ket_qua' => 'da_duyet',
            'ghi_chu' => '',
            'thoi_gian_duyet' => now(),
        ]);

        // Cập nhật đơn xin nghỉ theo cấp duyệt
        if ($capDuyet == 1) {
            // Trưởng phòng duyệt xong → đẩy lên HR
            $donXinNghi->cap_duyet_hien_tai = 2;
        } elseif ($capDuyet == 2 || $capDuyet == 3) {
            // HR hoặc Admin duyệt xong → duyệt hoàn tất
            $donXinNghi->trang_thai = 'da_duyet';

            // cập nhật lại số dư nghỉ phép cho nhân viên
            SoDuNghiPhepNhanVien::where('nguoi_dung_id', $donXinNghi->nguoi_dung_id)
                ->where('loai_nghi_phep_id', $donXinNghi->loai_nghi_phep_id)
                ->update([
                    'so_ngay_cho_duyet' => DB::raw('so_ngay_cho_duyet - ' . $donXinNghi->so_ngay_nghi),
                    'so_ngay_da_dung'   => DB::raw('so_ngay_da_dung + ' . $donXinNghi->so_ngay_nghi),
                ]);

            for ($ngay = $ngayBatDau->copy(); $ngay->lte($ngayKetThuc); $ngay->addDay()) {
                ChamCong::create([
                    'ngay_cham_cong' => $ngay->format('Y-m-d'),
                    'nguoi_dung_id' => $donXinNghi->nguoi_dung_id,
                    'gio_vao' => '08:30',
                    'gio_ra' => '17:30',
                    'so_gio_lam' => 8,
                    'so_cong' => 1,
                    'trang_thai' => 'nghi_phep',
                    'trang_thai_duyet' => 1
                ]);
            }
        }

        $donXinNghi->save();

        // tạo thông báo
        $nguoiNhanThongBaoId = $donXinNghi->nguoi_dung_id;
        $nguoiNhanThongBao = NguoiDung::findOrFail($nguoiNhanThongBaoId);

        if ($nguoiNhanThongBao) {
            $nguoiNhanThongBao->notify(new \App\Notifications\DuyetDonXinNghi($donXinNghi));
        }

        return redirect()->route('department.donxinnghi.danhsach')->with('success', 'Duyệt đơn thành công.');
    }


    public function tuChoi(Request $request)
    {
        $request->validate([
            'don_xin_nghi_id' => 'required|exists:don_xin_nghi,id',
            'ghi_chu' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        $vaiTro = VaiTro::find($user->vai_tro_id);
        $capDuyet = $vaiTro->ten == 'department' ? 1 : ($vaiTro->ten == 'hr' ? 2 : 3);

        $donXinNghi = DonXinNghi::findOrFail($request->don_xin_nghi_id);

        // Tránh từ chối trùng cấp
        if (LichSuDuyetDonNghi::where('don_xin_nghi_id', $donXinNghi->id)->where('cap_duyet', $capDuyet)->exists()) {
            return back()->with('error', 'Bạn đã xử lý đơn này rồi.');
        }

        // Ghi lịch sử
        LichSuDuyetDonNghi::create([
            'don_xin_nghi_id' => $donXinNghi->id,
            'cap_duyet' => $capDuyet,
            'nguoi_duyet_id' => $user->id,
            'ket_qua' => 'tu_choi',
            'ghi_chu' => $request->ghi_chu,
            'thoi_gian_duyet' => now(),
        ]);

        // cập nhật trang thái đơn xin nghỉ
        DonXinNghi::where('id', $donXinNghi->id)->update([
            'trang_thai' => 'tu_choi',
        ]);

        // cập nhật số dư nghỉ phép
        SoDuNghiPhepNhanVien::where('nguoi_dung_id', $donXinNghi->nguoi_dung_id)
            ->where('loai_nghi_phep_id', $donXinNghi->loai_nghi_phep_id)
            ->update([
                'so_ngay_cho_duyet' => DB::raw('so_ngay_cho_duyet - ' . $donXinNghi->so_ngay_nghi),
                'so_ngay_con_lai'   => DB::raw('so_ngay_con_lai + ' . $donXinNghi->so_ngay_nghi),
            ]);

        // tạo thông báo
        $nguoiNhanThongBaoId = $donXinNghi->nguoi_dung_id;
        $nguoiNhanThongBao = NguoiDung::findOrFail($nguoiNhanThongBaoId);

        if ($nguoiNhanThongBao) {
            $nguoiNhanThongBao->notify(new \App\Notifications\TuChoiDonXinNghi($donXinNghi));
        }

        return redirect()->route('department.donxinnghi.danhsach')->with('success', 'Từ chối đơn thành công.');
    }
}
