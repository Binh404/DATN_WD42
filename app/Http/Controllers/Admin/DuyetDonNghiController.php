<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonXinNghi;
use App\Models\LichSuDuyetDonNghi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DuyetDonNghiController extends Controller
{
    public function duyet(Request $request, $donId)
    {
        $request->validate([
            'ket_qua' => 'required|in:da_duyet,tu_choi',
            'ghi_chu' => 'nullable|string',
        ]);

        $nguoiDuyet = Auth::user();
        $don = DonXinNghi::findOrFail($donId);

        // Kiểm tra cấp duyệt
        $capDuyet = $this->xacDinhCapDuyet($nguoiDuyet);

        if ($capDuyet === 2) {
            // Kiểm tra đã được duyệt cấp 1 chưa
            $cap1 = LichSuDuyetDonNghi::where('don_xin_nghi_id', $don->id)
                ->where('cap_duyet', 1)
                ->where('ket_qua', 'da_duyet')
                ->first();

            if (!$cap1) {
                return response()->json(['message' => 'Chưa được duyệt bởi trưởng phòng (cấp 1).'], 403);
            }
        }

        // Kiểm tra đã duyệt cấp này chưa
        $daDuyet = LichSuDuyetDonNghi::where('don_xin_nghi_id', $don->id)
            ->where('cap_duyet', $capDuyet)
            ->exists();

        if ($daDuyet) {
            return response()->json(['message' => "Đơn đã được duyệt ở cấp $capDuyet."], 409);
        }

        // Ghi nhận lịch sử duyệt
        LichSuDuyetDonNghi::create([
            'don_xin_nghi_id' => $don->id,
            'cap_duyet' => $capDuyet,
            'nguoi_duyet_id' => $nguoiDuyet->id,
            'ket_qua' => $request->ket_qua,
            'ghi_chu' => $request->ghi_chu,
            'thoi_gian_duyet' => now(),
        ]);

        // Nếu là cấp 2 và đã duyệt → cập nhật trạng thái đơn
        if ($capDuyet === 2 && $request->ket_qua === 'da_duyet') {
            $don->update([
                'trang_thai' => 'da_duyet',
                'nguoi_duyet_id' => $nguoiDuyet->id,
                'thoi_gian_duyet' => now(),
            ]);
        }

        // Nếu từ chối ở bất kỳ cấp nào → huỷ đơn luôn
        if ($request->ket_qua === 'tu_choi') {
            $don->update([
                'trang_thai' => 'tu_choi',
                'nguoi_duyet_id' => $nguoiDuyet->id,
                'thoi_gian_duyet' => now(),
                'ly_do_tu_choi' => $request->ghi_chu,
            ]);
        }

        return response()->json(['message' => "Duyệt đơn thành công ở cấp $capDuyet."]);
    }

    // Hàm xác định cấp duyệt dựa vào vai trò hoặc chức vụ
    private function xacDinhCapDuyet($nguoiDuyet)
    {
        // Giả sử bạn có vai trò hoặc chức vụ trong bảng người dùng
        // Ví dụ: 1 - nhân viên, 2 - trưởng phòng, 3 - HR
        if ($nguoiDuyet->vai_tro_id == 2) return 1; // Trưởng phòng
        if ($nguoiDuyet->vai_tro_id == 3) return 2; // HR
        return 0; // Không hợp lệ
    }
}
