<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\ChamCong;
use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamCongController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->format('Y-m-d');

        // Lấy bản ghi chấm công hôm nay
        $chamCongHomNay = ChamCong::layBanGhiHomNay($user->id);

        // Lấy bảng chấm công tháng hiện tại
        $chamCongThang = ChamCong::layBangChamCongThang($user->id);
        // dd($chamCongThang->toArray());

        // // Tạo lịch chấm công
        $lichChamCong = $this->taoLichChamCong($chamCongThang);
        // dd($lichChamCong);
        // foreach ($lichChamCong as $ngay) {
        //     $chamCong = $ngay['cham_cong'] ?? null;

        //     if ($chamCong instanceof \App\Models\ChamCong) {
        //         echo $chamCong->gio_vao;  // ví dụ: in giờ vào
        //         echo $chamCong->gio_ra;   // hoặc các cột khác trong bảng
        //     }
        // }
        // dd('adsa');

        // // Thống kê tháng hiện tại
        $thongKe = $this->layThongKeThang($user->id);
        // dd($thongKe);

        return view('employe.cham-cong.index', compact(
            'chamCongHomNay',
            'lichChamCong',
            'thongKe'
        ));
    }
     public function chamCongVao(Request $request)
    {
        try {
            $user = Auth::user();
            $today = now();
            $currentTime = now();

            // Kiểm tra đã chấm công chưa
            $chamCong = ChamCong::layBanGhiHomNay($user->id);

            if ($chamCong && $chamCong->gio_vao) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã chấm công vào hôm nay rồi!'
                ]);
            }
            if ($today->isWeekend()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hôm nay là cuối tuần!'
                ]);
            }
            // dd($chamCong);
            DB::beginTransaction();

            // Tạo hoặc cập nhật bản ghi chấm công
            $chamCong = ChamCong::updateOrCreate(
                [
                    'nguoi_dung_id' => $user->id,
                    'ngay_cham_cong' => $today->format('Y-m-d'),
                ],
                [
                    'gio_vao' => $currentTime,
                    'vi_tri_check_in' => $this->layViTri($request),
                    'dia_chi_ip' => $request->ip(),
                ]
            );

            // Cập nhật trạng thái nếu đi muộn
            $chamCong->capNhatTrangThai();
            // dd($chamCong);
            $chamCong->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chấm công vào thành công!',
                'data' => [
                    'gio_vao' => $currentTime->format('H:i'),
                    'trang_thai' => $chamCong->trang_thai,
                    'trang_thai_text' => $chamCong->trang_thai_text,
                    'di_muon' => $chamCong->phut_di_muon > 0 ? $chamCong->phut_di_muon : 0
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
     public function chamCongRa(Request $request)
    {
        try {
            $user = Auth::user();
            $today = now()->format('Y-m-d');
            $currentTime = now();

            // Kiểm tra đã chấm công vào chưa
            $chamCong = ChamCong::layBanGhiHomNay($user->id);

            if (!$chamCong || !$chamCong->gio_vao) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn chưa chấm công vào hôm nay!'
                ]);
            }

            if ($chamCong->gio_ra) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã chấm công ra hôm nay rồi!'
                ]);
            }

            DB::beginTransaction();

            // Cập nhật giờ ra
            $chamCong->update([
                'gio_ra' => $currentTime,
                'vi_tri_check_out' => $this->layViTri($request),
            ]);

            // Cập nhật trạng thái và tính toán
            $chamCong->capNhatTrangThai();
            $chamCong->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Chấm công ra thành công! Hẹn gặp lại vào ngày mai.',
                'data' => [
                    'gio_ra' => $currentTime->format('H:i'),
                    'so_gio_lam' => $chamCong->so_gio_lam,
                    'so_cong' => $chamCong->so_cong,
                    'trang_thai' => $chamCong->trang_thai,
                    'trang_thai_text' => $chamCong->trang_thai_text
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
    public function lichSuChamCong(Request $request)
    {
        $user = Auth::user();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $chamCongThang = ChamCong::layBangChamCongThang($user->id, $month, $year);
        $lichChamCong = $this->taoLichChamCong($chamCongThang, $month, $year);
        $thongKe = $this->layThongKeThang($user->id, $month, $year);

        return response()->json([
            'success' => true,
            'data' => [
                'lich_cham_cong' => $lichChamCong,
                'thong_ke' => $thongKe
            ]
        ]);
    }
     public function trangThaiChamCong()
    {
        $user = Auth::user();
        $chamCong = ChamCong::layBanGhiHomNay($user->id);

        $trangThai = 'chua_cham_cong';

        if ($chamCong) {
            if ($chamCong->gio_vao && $chamCong->gio_ra) {
                $trangThai = 'da_hoan_thanh';
            } elseif ($chamCong->gio_vao) {
                $trangThai = 'da_cham_cong_vao';
            }
        }

        return response()->json([
            'success' => true,
            'trang_thai' => $trangThai,
            'data' => $chamCong ? [
                'gio_vao' => $chamCong->gio_vao_format,
                'gio_ra' => $chamCong->gio_ra_format,
                'so_gio_lam' => $chamCong->so_gio_lam ?? 0,
                'trang_thai_text' => $chamCong->trang_thai_text
            ] : null
        ]);
    }
    private function layViTri($request)
    {
        $lat = $request->input('latitude');
        $lng = $request->input('longitude');

        if ($lat && $lng) {
            return "Lat: {$lat}, Lng: {$lng}";
        }

        return null;
    }
    private function taoLichChamCong($chamCongThang, $month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;
        $soNgayTrongThang = Carbon::create($year, $month)->daysInMonth;
        $ngayDauThang = Carbon::create($year, $month, 1);

        $lich = [];

        // Tạo các ô trống cho những ngày trước ngày đầu tháng
        $thuTrongTuan = $ngayDauThang->dayOfWeek; // 0 = Chủ nhật, 1 = Thứ 2, ...
        $thuTrongTuan = $thuTrongTuan == 0 ? 7 : $thuTrongTuan; // Chuyển Chủ nhật thành 7

        for ($i = 1; $i < $thuTrongTuan; $i++) {
            $lich[] = [
                'ngay' => '',
                'trang_thai' => 'trong',
                'class' => 'day-normal'
            ];
        }

        // Tạo các ngày trong tháng
        for ($ngay = 1; $ngay <= $soNgayTrongThang; $ngay++) {
            $ngayHienTai = Carbon::create($year, $month, $ngay);
            $chamCong = $chamCongThang->where('ngay_cham_cong', $ngayHienTai->toDate())->first();
            // dd( $ngayHienTai);
            if($ngayHienTai->lessThan(now())){
                $trangThai = 'vang_mat';
                $class = 'day-absent';
            }else{
                $trangThai = 'chua_cham_cong';
                $class = 'day-normal';
            }
            // if($chamCong){

            // }


            if ($ngayHienTai->isWeekend()) {
                $trangThai = 'cuoi_tuan';
                $class = 'day-weekend';
            } elseif ($chamCong) {
                switch ($chamCong->trang_thai) {
                    case 'binh_thuong':
                        $trangThai = 'binh_thuong';
                        $class = 'day-present';
                        break;
                    case 'di_muon':
                        $trangThai = 'di_muon';
                        $class = 'day-late';
                        break;
                    case 've_som':
                        $trangThai = 've_som';
                        $class = 'day-early';
                        break;
                    case 'nghi_phep':
                        $trangThai = 'nghi_phep';
                        $class = 'day-leave';
                        break;
                    case 'vang_mat':
                        $trangThai = 'vang_mat';
                        $class = 'day-absent';
                        break;
                }
            }

            $lich[] = [
                'ngay' => $ngay,
                'trang_thai' => $trangThai,
                'class' => $class,
                'cham_cong' => $chamCong
            ];
        }

        return $lich;
    }
    private function layThongKeThang($userId, $month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $chamCongThang = ChamCong::where('nguoi_dung_id', $userId)
                                ->whereYear('ngay_cham_cong', $year)
                                ->whereMonth('ngay_cham_cong', $month)
                                ->get();

        return [
            'tong_ngay_lam' => $chamCongThang->count(),
            'tong_gio_lam' => $chamCongThang->sum('so_gio_lam'),
            'tong_cong' => $chamCongThang->sum('so_cong'),
            'so_lan_di_muon' => $chamCongThang->where('trang_thai', 'di_muon')->count(),
            'so_lan_ve_som' => $chamCongThang->where('trang_thai', 've_som')->count(),
            'so_ngay_vang' => $chamCongThang->where('trang_thai', 'vang_mat')->count(),
            'so_ngay_nghi_phep' => $chamCongThang->where('trang_thai', 'nghi_phep')->count(),
        ];
    }
}
