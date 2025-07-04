<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\ChamCong;
use App\Models\DangKyTangCa;
use App\Models\thucHienTangCa;
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
        //         echo $chamCong->ngay_cham_cong;
        //     }
        // }
        // dd('adsa');

        // // Thống kê tháng hiện tại
        // $thongKe = $this->layThongKeThang($user->id);
        // dd($thongKe);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'success',
        // ]);

        return view('employe.cham-cong.index', compact(
            'chamCongHomNay',
            'lichChamCong',
            // 'thongKe'
        ));
    }

    public function chamCongVao(Request $request)
    {
        try {
            $user = Auth::user();
            $today = now();
            $currentTime = now();
            // dd($today->format('Y-m-d'));
            $isOvertime = false;
            $overtimeStartTime = now()->setTime(18, 30); // 18:45
            $isWeekend = $today->isWeekend();
            $isHoliday = $this->kiemTraNgayLe($today);
            //kiểm tra xem có đã duyệt đơn tăng ca chưa
            $donTangCa = DangKyTangCa::where('ngay_tang_ca', $today->format('Y-m-d'))
            ->where('nguoi_dung_id', $user->id)
            ->where('trang_thai', 'da_duyet')
            ->first();
            // dd($donTangCa);
            if ($isWeekend || $isHoliday || ($donTangCa && $currentTime->greaterThanOrEqualTo($overtimeStartTime))) {
                $isOvertime = true;
            }
            // dd( $currentTime->greaterThanOrEqualTo($overtimeStartTime));
            if($isOvertime){
                if (!$donTangCa) {
                     return response()->json([
                        'success' => false,
                        'message' => 'Không thể chấm công, nếu không có đơn tăng ca được duyệt!'
                    ]);
                }
                // dd($donTangCa->id);
                $chamCongTangCa = thucHienTangCa::layBanGhiTheoDonTangCa($donTangCa->id);
                // dd($chamCongTangCa->gio_bat_dau_thuc_te);
                if ($chamCongTangCa && $chamCongTangCa->gio_bat_dau_thuc_te) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn đã chấm công vào tăng ca hôm nay rồi!'
                    ]);
                }
                // dd($chamCongTangCa);
                DB::beginTransaction();
                $chamCongTangCa = thucHienTangCa::updateOrCreate(
                    [
                        'dang_ky_tang_ca_id' => $donTangCa->id
                    ],
                    [
                        'gio_bat_dau_thuc_te' => $currentTime,
                        'vi_tri_check_in' => $this->layViTri($request),
                        'ghi_chu' => $this->layLyDo($request),
                        'trang_thai' => 'dang_lam'
                    ]
                    );
                DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Chấm công tăng ca vào thành công!',
                        'data' => [
                            'is_overtime' => true,
                            'gio_bat_dau_thuc_te' => $chamCongTangCa->gio_bat_dau_thuc_te->format('H:i'),
                            'trang_thai' => $chamCongTangCa->trang_thai_text

                        ]
                    ]);
            }else {
                // Kiểm tra đã chấm công chưa
                if (!$isWeekend && !$isHoliday && !$donTangCa && $currentTime->greaterThanOrEqualTo($overtimeStartTime)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể chấm công tăng ca nếu không có đơn tăng ca được duyệt!'
                    ]);
                }
                $chamCong = ChamCong::layBanGhiHomNay($user->id);

                if ($chamCong && $chamCong->gio_vao) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn đã chấm công vào hôm nay rồi!'
                    ]);
                };


                // Kiểm tra có phải ngày lễ/nghỉ không
                // $isNgayLe = $this->kiemTraNgayLe($today);
                // $isWeekend = $today->isWeekend();
                // dd($isNgayLe, $isWeekend);
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
                        'ghi_chu' => $this->layLyDo($request),
                        'dia_chi_ip' => $request->ip(),
                        'trang_thai_duyet' => $request->trang_thai_duyet
                    ]
                );

                // Cập nhật trạng thái nếu đi muộn
                $chamCong->capNhatTrangThai();
                // dd($chamCong);
                // $a = $chamCong->trag_thai_duyet;
                $chamCong->save();

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Chấm công vào thành công!',
                    'data' => [
                        'gio_vao' => $currentTime->format('H:i'),
                        // 'trang_thai' => $chamCong->trang_thai,
                        'trang_thai_text' => $chamCong->trang_thai_text,
                        'trang_thai_duyet' => $chamCong->trang_thai_duyet,
                        'di_muon' => $chamCong->phut_di_muon > 0 ? $chamCong->phut_di_muon : 0
                    ]
                ]);
            }


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
            $today = now();
            $currentTime = now();
            $isOvertime = false;
            $overtimeStartTime = now()->setTime(18, 45); // 18:45
            $isWeekend = $today->isWeekend();
            $isHoliday = $this->kiemTraNgayLe($today);
            //kiểm tra xem có đã duyệt đơn tăng ca chưa
            $donTangCa = DangKyTangCa::where('ngay_tang_ca', $today->format('Y-m-d'))
            ->where('nguoi_dung_id', $user->id)
            ->where('trang_thai', 'da_duyet')
            ->first();
            // dd($donTangCa);
            if ($isWeekend || $isHoliday || ($donTangCa && $currentTime->greaterThanOrEqualTo($overtimeStartTime))) {
                $isOvertime = true;
            }
            if($isOvertime){
                if (!$donTangCa) {
                     return response()->json([
                        'success' => false,
                        'message' => 'Không thể chấm công, nếu không có đơn tăng ca được duyệt!'
                    ]);
                }
                // dd($donTangCa->id);
                $chamCongTangCa = thucHienTangCa::layBanGhiTheoDonTangCa($donTangCa->id);
                // dd($chamCongTangCa->gio_bat_dau_thuc_te);
                if (!$chamCongTangCa && !$chamCongTangCa->gio_bat_dau_thuc_te) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn chưa chấm công vào tăng ca hôm nay rồi!'
                    ]);
                }elseif ($chamCongTangCa && $chamCongTangCa->gio_ket_thuc_thuc_te) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn đã chấm công ra tăng ca hôm nay rồi!'
                    ]);
                }


                // dd($chamCongTangCa);
                DB::beginTransaction();
                $chamCongTangCa ->update([
                    'gio_ket_thuc_thuc_te' => $currentTime,
                    'vi_tri_check_out' => $this->layViTri($request),
                    'so_gio_tang_ca_thuc_te' => $chamCongTangCa->capNhatSoGio(),
                    'trang_thai' => $chamCongTangCa->capNhatTrangThai($donTangCa->so_gio_tang_ca),
                    'so_cong_tang_ca' => $chamCongTangCa->capNhapSoCong($donTangCa->loai_tang_ca, $donTangCa->so_gio_tang_ca),
                ]);
                $chamCongTangCa->save();
                DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Hoàn thành tăng ca thành công!',
                        'data' => [
                            'is_overtime' => true,
                            'gio_ket_thuc_thuc_te' => $chamCongTangCa->gio_ket_thuc_thuc_te->format('H:i'),
                            'so_gio_tang_ca_thuc_te' => round($chamCongTangCa->so_gio_tang_ca_thuc_te, 2),
                            'trang_thai' => $chamCongTangCa->trang_thai_text
                        ]
                    ]);
            }else {
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
                $trangThaiDuyet = ($chamCong->trang_thai_duyet == 0)
                    ? 0  // Chấm công vào chờ duyệt → chấm công ra cũng chờ duyệt
                    : $request->trang_thai_duyet; // Chấm công vào đã duyệt → theo request

                DB::beginTransaction();

                // Cập nhật giờ ra
                $chamCong->update([
                    'gio_ra' => $currentTime,
                    'vi_tri_check_out' => $this->layViTri($request),
                    'trang_thai_duyet' => $trangThaiDuyet
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
                        // 'trang_thai' => $chamCong->trang_thai,
                        'trang_thai_duyet' => $request->trang_thai_duyet,
                        'trang_thai_text' => $chamCong->trang_thai_text
                    ]
                ]);
            }


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
    public function getChamCongByDay(Request $request, $dayId)
    {
        try {
            $dayNgay = Carbon::parse($dayId)->format('Y-m-d');
            // Validate input
            if ( !Carbon::hasFormat($dayNgay, 'Y-m-d')) {
                return response()->json(['error' => 'Ngày không hợp lệ'], 400);
            }
            // dd($dayNgay);
            // Fetch attendance data
            $chamCong = ChamCong::where('id', $dayNgay)
                ->orWhere('ngay_cham_cong', $dayNgay)
                ->where('nguoi_dung_id', auth()->id())
                ->first();
            $kiemTraTrangThaiDuyet = false;

            if ($chamCong !== null) {
                if ($chamCong->trang_thai_duyet == 0) {
                    $kiemTraTrangThaiDuyet = true;
                }
            }
            // Initialize default response data
            $data = [
                'kiem_tra_trang_thai_duyet' => $kiemTraTrangThaiDuyet,
                'kiem_tra' => null,
                'gio_vao' => null,
                'gio_ra' => null,
                'so_gio_lam' => 0,
                'ghi_chu' => null,
                'ngay' => $dayNgay,
                'ghi_chu_duyet' => null,
                'trang_thai_text' => 'Chưa chấm công',
                'trang_thai_duyet' => 0,
            ];
            // dd($chamCong);
            if ($chamCong) {
                // Update data with attendance information
                $data = array_merge($data, [
                    'kiem_tra' => true,
                    'gio_vao' => $chamCong->gio_vao ? Carbon::parse($chamCong->gio_vao)->format('H:i') : null,
                    'gio_ra' => $chamCong->gio_ra ? Carbon::parse($chamCong->gio_ra)->format('H:i') : null,
                    'so_gio_lam' => $chamCong->so_gio_lam ?? 0,
                    'trang_thai_text' => $chamCong->trang_thai_text,
                    'ngay' => Carbon::parse($chamCong->ngay_cham_cong)->format('Y-m-d'),
                    'ghi_chu' => $chamCong->ghi_chu ?? null,
                    'ghi_chu_duyet' => $chamCong->ghi_chu_duyet ?? null,
                    'trang_thai_duyet' => $chamCong->trang_thai_duyet ?? 0,
                ]);

                }
                 // Fetch overtime data if applicable
                $dangKyChamCongTangCa = DangKyTangCa::where('ngay_tang_ca', $dayNgay)
                    ->where('trang_thai', 'da_duyet')
                    ->first();

                if ($dangKyChamCongTangCa) {
                    $chamCongTangCa = ThucHienTangCa::where('dang_ky_tang_ca_id', $dangKyChamCongTangCa->id)->first();

                    if ($chamCongTangCa) {
                        $data = array_merge($data, [
                            'is_overtime' => true,
                            'ngay' => $dayNgay,
                            'gio_bat_dau_thuc_te' => $chamCongTangCa->gio_bat_dau_thuc_te
                                ? Carbon::parse($chamCongTangCa->gio_bat_dau_thuc_te)->format('H:i')
                                : null,
                            'gio_ket_thuc_thuc_te' => $chamCongTangCa->gio_ket_thuc_thuc_te
                                ? Carbon::parse($chamCongTangCa->gio_ket_thuc_thuc_te)->format('H:i')
                                : null,
                            'so_gio_tang_ca_thuc_te' => $chamCongTangCa->so_gio_tang_ca_thuc_te ?? 0,
                            'trang_thai' => $chamCongTangCa->trang_thai_text ?? 'Chưa thực hiện',
                        ]);
                    }
                }


            return response()->json($data);

        } catch (\Exception $e) {
            \Log::error('Error fetching attendance data: ' . $e->getMessage());
            return response()->json([
                'error' => 'Có lỗi xảy ra khi lấy dữ liệu',
                'message' => config('app.debug') ? $e->getMessage() : 'Lỗi hệ thống'
            ], 500);
        }
    }
    public function updateTrangThai(Request $request)
    {
        try {
            $user = Auth::user();
            $chamCong = ChamCong::layBanGhiTheoNgay($user->id, $request->ngay_cham_cong);
            $chamCong->update([
                'ghi_chu' => $request->reason_detail,
                'trang_thai_duyet' => 3,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái thành công',
                'data' => [
                    'ghi_chu' => $chamCong->reason_detail,
                    // 'trang_thai_text' => $chamCong->trang_thai_text
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi lý dụ liệu',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function trangThaiChamCong()
    {
        try {
            $user = Auth::user();
            $today = now();
            $currentTime = now();
            $overtimeStartTime = now()->setTime(18, 30); // 18:30
            $isWeekend = $today->isWeekend();
            $isHoliday = $this->kiemTraNgayLe($today);

            // Kiểm tra đơn tăng ca được duyệt
            $donTangCa = DangKyTangCa::where('ngay_tang_ca', $today->format('Y-m-d'))
                ->where('nguoi_dung_id', $user->id)
                ->where('trang_thai', 'da_duyet')
                ->first();

            // Lấy thông tin chấm công thường
            $chamCongThuong = ChamCong::layBanGhiHomNay($user->id);

            // Lấy thông tin chấm công tăng ca
            $chamCongTangCa = null;
            if ($donTangCa) {
                $chamCongTangCa = thucHienTangCa::layBanGhiTheoDonTangCa($donTangCa->id);
            }

            // Xác định loại chấm công hiện tại
            $isOvertimeTime = $currentTime->greaterThanOrEqualTo($overtimeStartTime);
            $shouldUseOvertime = $isWeekend || $isHoliday || ($donTangCa && $isOvertimeTime);

            $response = [
                'success' => true,
                'is_weekend' => $isWeekend,
                'is_holiday' => $isHoliday,
                'has_approved_overtime' => $donTangCa ? true : false,
                'current_time' => $currentTime->format('H:i'),
                'should_use_overtime' => $shouldUseOvertime,
                'normal_data' => null,
                'overtime_data' => null
            ];

            // Thêm thông tin chấm công thường
            if ($chamCongThuong) {
                $response['normal_data'] = [
                    'gio_vao' => $chamCongThuong->gio_vao ? $chamCongThuong->gio_vao->format('H:i') : null,
                    'gio_ra' => $chamCongThuong->gio_ra ? $chamCongThuong->gio_ra->format('H:i') : null,
                    'so_gio_lam' => $chamCongThuong->so_gio_lam,
                    'ghi_chu' => $chamCongThuong->ghi_chu,
                    // 'trang_thai' => $chamCongThuong->trang_thai,
                    'ghi_chu_duyet' => $chamCongThuong->ghi_chu_duyet,
                    'trang_thai_text' => $chamCongThuong->trang_thai_text,
                    'trang_thai_duyet' => $chamCongThuong->trang_thai_duyet
                ];
            }

            // Thêm thông tin chấm công tăng ca
            if ($chamCongTangCa) {
                $response['overtime_data'] = [
                    'gio_bat_dau_thuc_te' => $chamCongTangCa->gio_bat_dau_thuc_te
                        ? Carbon::parse($chamCongTangCa->gio_bat_dau_thuc_te)->format('H:i')
                        : null,

                    'gio_ket_thuc_thuc_te' => $chamCongTangCa->gio_ket_thuc_thuc_te
                        ? Carbon::parse($chamCongTangCa->gio_ket_thuc_thuc_te)->format('H:i')
                        : null,
                    'so_gio_tang_ca_thuc_te' => $chamCongTangCa->so_gio_tang_ca_thuc_te,
                    'so_cong_tang_ca' => $chamCongTangCa->so_cong_tang_ca,
                    'trang_thai' => $chamCongTangCa->trang_thai_text
                ];
            }

            return response()->json($response);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
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
    private function layLyDo($request)
    {
        $lyDo = $request->input('reason_detail');
        return $lyDo ? $lyDo : null;
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
            'id' => '',
            'ngay' => '',
            'trang_thai' => 'trong',
            'class' => 'day-normal'
        ];
    }

    // Lấy thông tin người dùng hiện tại
    $user = Auth::user();

    // Tạo các ngày trong tháng
    for ($ngay = 1; $ngay <= $soNgayTrongThang; $ngay++) {
        $ngayHienTai = Carbon::create($year, $month, $ngay);

        $chamCong = $chamCongThang->where('ngay_cham_cong', $ngayHienTai->toDate())->first();

        // Kiểm tra đơn tăng ca được duyệt cho ngày hiện tại
        $donTangCa = DangKyTangCa::where('ngay_tang_ca', $ngayHienTai->toDateString())
            ->where('nguoi_dung_id', $user->id)
            ->where('trang_thai', 'da_duyet')
            ->first();

        // Mặc định trạng thái và class
        if ($ngayHienTai->lessThan(now())) {
            $trangThai = 'vang_mat';
            $class = 'day-absent';
        } else {
            $trangThai = 'chua_cham_cong';
            $class = 'day-normal';
        }

        // Kiểm tra nếu là cuối tuần
        if ($ngayHienTai->isWeekend()) {
            $trangThai = 'cuoi_tuan';
            $class = 'day-weekend';

            // Nếu có đơn tăng ca được duyệt
            if ($donTangCa) {
                $chamCongTangCa = thucHienTangCa::layBanGhiTheoDonTangCa($donTangCa->id);
                if ($chamCongTangCa) {
                    $trangThai = 'tang_ca';
                    $class = 'day-overtime';
                }
            }
        } elseif ($chamCong) {
            // Xử lý các trạng thái chấm công thường
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
            'id' => $chamCong ? \Carbon\Carbon::parse($chamCong->ngay_cham_cong)->format('Y-m-d') : ($donTangCa ? \Carbon\Carbon::parse($donTangCa->ngay_tang_ca)->format('Y-m-d') : ''),
            'ngay' => $ngay,
            'trang_thai' => $trangThai,
            'class' => $class,
            'cham_cong' => $chamCong,
            'tang_ca' => $donTangCa ? true : false
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
    /**
     * Kiểm tra ngày lễ
     */
    private function kiemTraNgayLe($ngay)
    {
        // Danh sách ngày lễ (có thể lưu trong database hoặc config)
        $ngayLe = [
            '01-01', // Tết Dương lịch
            '30-04', // 30/4
            '01-05', // 1/5
            '02-09', // Quốc khánh
            // Thêm các ngày lễ khác...
        ];

        $ngayHienTai = $ngay->format('d-m');
        return in_array($ngayHienTai, $ngayLe);
    }
}
