<?php

namespace App\Http\Controllers;

use App\Models\DonXinNghi;
use App\Models\HoSoNguoiDung;
use App\Models\NguoiDung;
use App\Models\PhongBan;
use App\Models\UngVien;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        // dd($user);
        if (!$user->da_hoan_thanh_ho_so) {

            $hoSo = HoSoNguoiDung::with('nguoiDung')->where('nguoi_dung_id', $user->id)->first();
            // dd($hoSo);
            return view('employe.complete-profile', compact('hoSo'));
        }
        // dd($user->vai_tro);
        $tenVaiTro = optional($user->vaiTro)->ten;
        if (!in_array($tenVaiTro, ['admin', 'hr'])) {
            return redirect()->route('personal.department.dashboard' );
        }
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();

        // 1. Tổng số người dùng đang hoạt động
        $tongNguoiDung = NguoiDung::where('trang_thai', 1)->count();

        // 2. Nhân viên mới trong tháng
        $nhanVienMoi = NguoiDung::where('trang_thai', 1)
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereHas('hopDongLaoDongMoiNhat', function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('ngay_bat_dau', [$startOfMonth, $endOfMonth]);
                })
                ->orWhereDoesntHave('hopDongLaoDongMoiNhat', function ($q) {
                    $q->whereNotNull('ngay_bat_dau');
                })
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })->count();
        $nhanVienMoiThangTruoc  = NguoiDung::where('trang_thai', 1)
            ->where(function ($query) use ($startOfLastMonth, $endOfLastMonth) {
                $query->whereHas('hopDongLaoDongMoiNhat', function ($q) use ($startOfLastMonth, $endOfLastMonth) {
                    $q->whereBetween('ngay_bat_dau', [$startOfLastMonth, $endOfLastMonth]);
                })
                ->orWhereDoesntHave('hopDongLaoDongMoiNhat', function ($q) {
                    $q->whereNotNull('ngay_bat_dau');
                })
                ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth]);
            })
            ->count();
        $tyLeNhanVienMoiThayDoi = round((($nhanVienMoi - $nhanVienMoiThangTruoc) / max($nhanVienMoiThangTruoc, 1)) * 100, 1);
        // 3. Nhân viên chấm công hôm nay
        $nhanVienChamCongHomNay = NguoiDung::whereHas('chamCong', function ($query) use ($today) {
            $query->whereDate('ngay_cham_cong', $today)
                    ->where('trang_thai', '!=', 'nghi_phep');
        })->count();
        $nhanVienChamCongHomQua = NguoiDung::whereHas('chamCong', function ($query) use ($yesterday) {
            $query->whereDate('ngay_cham_cong', $yesterday)
                ->where('trang_thai', '!=', 'nghi_phep');
        })->count();
        $tyLeChamCongThayDoi = round((($nhanVienChamCongHomNay - $nhanVienChamCongHomQua) / max($nhanVienChamCongHomQua, 1)) * 100, 1);

        // 4. Nhân viên nghỉ phép hôm nay
        $nhanVienNghiPhepHomNay = NguoiDung::whereHas('chamCong', function ($query) use ($today) {
            $query->whereDate('ngay_cham_cong', $today)
                ->where('trang_thai', 'nghi_phep');
        })->count();
        // Nghỉ phép hôm qua
        $nhanVienNghiPhepHomQua = NguoiDung::whereHas('chamCong', function ($query) use ($yesterday) {
            $query->whereDate('ngay_cham_cong', $yesterday)
                ->where('trang_thai', 'nghi_phep');
        })->count();
        $tyLeNghiPhepThayDoi = round((($nhanVienNghiPhepHomNay - $nhanVienNghiPhepHomQua) / max($nhanVienNghiPhepHomQua, 1)) * 100, 1);

        // 5. Tổng số ứng viên mới nộp
        // Ứng viên mới nộp tháng này
        $tongUngVien = UngVien::where('trang_thai', 'moi_nop')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Tháng trước
        $ungVienThangTruoc = UngVien::where('trang_thai', 'moi_nop')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();
        $tyLeUngVienThayDoi = round((($tongUngVien - $ungVienThangTruoc) / max($ungVienThangTruoc, 1)) * 100, 1);
        // 6. Truyền dữ liệu sang view
        $counts = [];
        $months = ['Tháng 1' => '1', 'Tháng 2' => '2', 'Tháng 3' => '3', 'Tháng 4' => '4', 'Tháng 5' => '5', 'Tháng 6' => '6', 'Tháng 7' => '7', 'Tháng 8' => '8', 'Tháng 9' => '9', 'Tháng 10' => '10', 'Tháng 11' => '11', 'Tháng 12' => '12'];
        $nguoiDung = NguoiDung::all();
        $currentYear = Carbon::now()->year;

        foreach ($months as $monthName => $monthNumber) {
            // Tính số ngày làm việc trong tháng (loại trừ thủ 7, chủ nhật)
            $daysInMonth = Carbon::create($currentYear, $monthNumber, 1)->daysInMonth;
            $workingDays = 0;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $monthNumber, $day);
                // Kiểm tra nếu không phải thứ 7 (6) hoặc chủ nhật (0)
                if ($date->dayOfWeek !== 0 && $date->dayOfWeek !== 6) {
                    $workingDays++;
                }
            }

            foreach ($nguoiDung as $user) {
                // Đếm số ngày chấm công trong tháng
                $attendanceDays = $user->chamCong()
                    ->whereYear('ngay_cham_cong', $currentYear)
                    ->whereMonth('ngay_cham_cong', $monthNumber)
                    ->count();

                // Tính tỷ lệ chấm công (%)
                $attendanceRate = $workingDays > 0 ? ($attendanceDays / $workingDays) * 100 : 0;
                $counts[$monthName][$user->id] = round($attendanceRate, 2);
            }
        }
        // dd($counts);
        $averageAttendanceRate = [];
        foreach ($counts as $month => $userRates) {
            // Tính tỷ lệ chấm công trung bình của tất cả nhân viên trong tháng
            $average = count($userRates) > 0 ? round(array_sum($userRates) / count($userRates), 2) : 0;
            $averageAttendanceRate[] = $average;
        }
        // dd($averageAttendanceRate);
        $dataAverageAttendanceRate = $averageAttendanceRate;
        // dd($dataAverageAttendanceRate);
        $Designations = PhongBan::all();
        $chartEmployee = [];
        $DesignationName = [];
        foreach ($Designations as $Designation) {
            $chartEmp = NguoiDung::where('phong_ban_id', $Designation->id)->count();
            if ($chartEmp > 0) {
                $chartEmployee[] = $chartEmp;
                $DesignationName[] = $Designation->ten_phong_ban;
            }
        }
        $DesignationName = json_encode($DesignationName);
        $designationSeries = json_encode($chartEmployee);
        // dd($designationSeries);
        $employees = NguoiDung::whereHas('hoSo') // Chỉ lấy người dùng có hồ sơ
            ->with(['hoSo' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Order trong quan hệ (không ảnh hưởng sort chính)
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return optional($user->hoSo)->created_at; // Sắp xếp theo ngày tạo hồ sơ
            })
            ->take(5); // Lấy 5 người đầu tiên

        $gioiTinhCounts = NguoiDung::where('trang_thai', 1)
            ->whereHas('hoSo')
            ->with('hoSo')
            ->get()
            ->groupBy(function ($nguoiDung) {
                return $nguoiDung->hoSo->gioi_tinh ?? 'Không xác định';
            })
            ->map(function ($group) {
                return $group->count();
            });
            $total = $gioiTinhCounts->sum();

            $gioiTinhPercentages = $gioiTinhCounts->map(function ($count) use ($total) {
                return $total > 0 ? round(($count / $total) * 100, 2) : 0;
            });
            $dataGender = $gioiTinhPercentages->values();
            $mapLabelsGender = [
                'nam' => 'Nam',
                'nu' => 'Nữ',
                'khac' => 'Khác',
            ];
            $labelsGender = $gioiTinhCounts->keys()->map(function ($key) use ($mapLabelsGender) {
                return $mapLabelsGender[$key] ?? $key ; // In hoa chữ cái đầu
            })->values();
            // $labelsGender = json_encode($labelsGender);
            // $dataGender = json_encode($dataGender);
            // dd($dataGender);
            // lấy thông kê nghỉ loại nghỉ theo tháng
          $stats = [];
        for ($month = 1; $month <= 12; $month++) {
            for ($week = 1; $week <= 5; $week++) {
                $stats[$month][$week] = ['sick' => 0, 'casual' => 0];
            }
        }

        // Xử lý nghỉ ốm (id = 2)
        $nghiPhepOm = DonXinNghi::where('trang_thai', 'da_duyet')
            ->where('loai_nghi_phep_id', 2)
            ->whereYear('ngay_bat_dau', $currentYear)
            ->get()
            ->groupBy(function ($don) {
                $date = Carbon::parse($don->ngay_bat_dau);
                $month = $date->month;
                $weekOfMonth = intval(ceil($date->day / 7));
                return $month . '-' . $weekOfMonth;
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Xử lý các loại nghỉ còn lại
        $nghiPhepConLai = DonXinNghi::where('trang_thai', 'da_duyet')
            ->where('loai_nghi_phep_id', '!=', 2)
            ->whereYear('ngay_bat_dau', $currentYear)
            ->get()
            ->groupBy(function ($don) {
                $date = Carbon::parse($don->ngay_bat_dau);
                $month = $date->month;
                $weekOfMonth = intval(ceil($date->day / 7));
                return $month . '-' . $weekOfMonth;
            })
            ->map(function ($group) {
                return $group->count();
            });

        // Gộp dữ liệu vào mảng $stats
        foreach ($nghiPhepOm as $key => $count) {
            list($month, $week) = explode('-', $key);
            $stats[intval($month)][intval($week)]['sick'] = $count;
        }

        foreach ($nghiPhepConLai as $key => $count) {
            list($month, $week) = explode('-', $key);
            $stats[intval($month)][intval($week)]['casual'] = $count;
        }

        // Chuẩn bị dữ liệu cho biểu đồ JS
        $sickLeaveData = [];
        $casualLeaveData = [];

        for ($month = 1; $month <= 12; $month++) {
            $sickWeeks = [];
            $casualWeeks = [];
            for ($week = 1; $week <= 5; $week++) {
                $sickWeeks[] = $stats[$month][$week]['sick'] ?? 0;
                $casualWeeks[] = $stats[$month][$week]['casual'] ?? 0;
            }
            $sickLeaveData[] = $sickWeeks;
            $casualLeaveData[] = $casualWeeks;
        }

            // dd($casualLeaveByDay, $sickLeaveByDay);

        return view('admin.dashboard.index', compact(
            'tongNguoiDung',
            'nhanVienMoi',
            'nhanVienChamCongHomNay',
            'nhanVienNghiPhepHomNay',
            'tongUngVien',
            'tyLeNhanVienMoiThayDoi',
            'tyLeChamCongThayDoi',
            'tyLeNghiPhepThayDoi',
            'tyLeUngVienThayDoi',
            'months', 'dataAverageAttendanceRate',
            'DesignationName', 'designationSeries',
            'employees',
            'labelsGender',
            'dataGender',
            'sickLeaveData',
            'casualLeaveData',

        ));
    }
    public function personalStats($nguoiDungId = null)
{
    // Nếu không truyền ID, lấy ID của user đang đăng nhập
    // if (!$nguoiDungId) {
    //     $user = auth()->user();
    //     $nguoiDungId = $user->id;
    //     // if (empty($user->da_hoan_thanh_ho_so)) {

    //     //     $hoSo = HoSoNguoiDung::with('nguoiDung')->where('nguoi_dung_id', $nguoiDungId)->first();
    //     //     // dd($hoSo);
    //     //     return view('employe.complete-profile', compact('hoSo'));
    //     // }
    // }else{

    // }
   $user = auth()->user();
   $tenVaiTro = optional($user->vaiTro)->ten;
    // dd($tenVaiTro);
    // Kiểm tra vai trò là 'employee' hoặc 'department'
    if (in_array($tenVaiTro, ['employee', 'department'])) {
        // Nếu không truyền ID thì gán ID người đang đăng nhập
        // dd($nguoiDungId);
        if (!$nguoiDungId) {
            $nguoiDungId = $user->id;
        }

        // Nếu có truyền ID mà khác với ID đang đăng nhập → chặn
        if ($nguoiDungId != $user->id) {
            abort(403, 'Bạn không có quyền truy cập hồ sơ của người khác.');
        }
    }else{
        abort(403, 'Bạn không có quyền truy cập hồ sơ.');
    }


    $nguoiDung = NguoiDung::with(['hoSo', 'hopDongLaoDongMoiNhat', 'phongBan'])->find($nguoiDungId);

    if (!$nguoiDung) {
        return redirect()->back()->with('error', 'Không tìm thấy nhân viên');
    }
    // dd(optional($nguoiDung->hopDongLaoDongMoiNhat)->ngay_bat_dau);
    $today = Carbon::today();
    $yesterday = Carbon::yesterday();
    $startOfMonth = $today->copy()->startOfMonth();
    $endOfMonth = $today->copy()->endOfMonth();
    $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
    $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();
    $startOfYear = $today->copy()->startOfYear();
    $endOfYear = $today->copy()->endOfYear();

    // 1. Thông tin cơ bản
    $thongTinCoBan = [
        'ho_ten' => $nguoiDung->hoSo->ho . ' ' . $nguoiDung->hoSo->ten,
        'email' => $nguoiDung->email,
        'phong_ban' => $nguoiDung->phongBan->ten_phong_ban ?? 'Chưa xác định',
        'ngay_bat_dau_lam_viec' => $nguoiDung->hopDongLaoDongMoiNhat->ngay_bat_dau ?? $nguoiDung->created_at,
        'so_ngay_lam_viec' => $nguoiDung->hopDongLaoDongMoiNhat
            ? Carbon::parse($nguoiDung->hopDongLaoDongMoiNhat->ngay_bat_dau)->diffInDays($today) + 1
            : Carbon::parse($nguoiDung->created_at)->diffInDays($today) + 1
    ];

    // 2. Thống kê chấm công tháng này
    $chamCongThangNay = $nguoiDung->chamCong()
        ->whereBetween('ngay_cham_cong', [$startOfMonth, $endOfMonth])
        ->get();

    $soNgayChamCongThangNay = $chamCongThangNay->count();
    $soNgayDiTreThangNay = $chamCongThangNay->where('trang_thai', 'di_muon')->count();
    $soNgayVeSlmThangNay = $chamCongThangNay->where('trang_thai', 've_som')->count();
    $soNgayNghiPhepThangNay = $chamCongThangNay->where('trang_thai', 'nghi_phep')->count();
    $soNgayDungGioThangNay = $chamCongThangNay->where('trang_thai', 'binh_thuong')->count();

    // Tính số ngày làm việc trong tháng (loại trừ thứ 7, chủ nhật)
    $soNgayLamViecTrongThang = 0;
    $daysInMonth = $today->daysInMonth;
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = Carbon::create($today->year, $today->month, $day);
        if ($date->dayOfWeek !== 0 && $date->dayOfWeek !== 6) {
            $soNgayLamViecTrongThang++;
        }
    }

    $tyLeChamCongThangNay = $soNgayLamViecTrongThang > 0
        ? round(($soNgayChamCongThangNay / $soNgayLamViecTrongThang) * 100, 1)
        : 0;

    // 3. Thống kê chấm công tháng trước
    $chamCongThangTruoc = $nguoiDung->chamCong()
        ->whereBetween('ngay_cham_cong', [$startOfLastMonth, $endOfLastMonth])
        ->get();

    $soNgayChamCongThangTruoc = $chamCongThangTruoc->count();
    $tyLeChamCongThayDoi = $soNgayChamCongThangTruoc > 0
        ? round((($soNgayChamCongThangNay - $soNgayChamCongThangTruoc) / $soNgayChamCongThangTruoc) * 100, 1)
        : 0;

    // 4. Thống kê chấm công năm nay
    $chamCongNamNay = $nguoiDung->chamCong()
        ->whereBetween('ngay_cham_cong', [$startOfYear, $endOfYear])
        ->get();

    $soNgayChamCongNamNay = $chamCongNamNay->count();
    $soNgayDiTreNamNay = $chamCongNamNay->where('trang_thai', 'di_muon')->count();
    $soNgayVeSomNamNay = $chamCongNamNay->where('trang_thai', 've_som')->count();
    $soNgayNghiPhepNamNay = $chamCongNamNay->where('trang_thai', 'nghi_phep')->count();

    // 5. Thống kê theo tháng trong năm (để vẽ biểu đồ)
    $thongKeTheoThang = [];
    $months = ['Tháng 1' => 1, 'Tháng 2' => 2, 'Tháng 3' => 3, 'Tháng 4' => 4,
               'Tháng 5' => 5, 'Tháng 6' => 6, 'Tháng 7' => 7, 'Tháng 8' => 8,
               'Tháng 9' => 9, 'Tháng 10' => 10, 'Tháng 11' => 11, 'Tháng 12' => 12];

    foreach ($months as $monthName => $monthNumber) {
        $chamCongThang = $nguoiDung->chamCong()
            ->whereYear('ngay_cham_cong', $today->year)
            ->whereMonth('ngay_cham_cong', $monthNumber)
            ->get();

        // Tính số ngày làm việc trong tháng
        $daysInMonth = Carbon::create($today->year, $monthNumber, 1)->daysInMonth;
        $workingDays = 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($today->year, $monthNumber, $day);
            if ($date->dayOfWeek !== 0 && $date->dayOfWeek !== 6) {
                $workingDays++;
            }
        }

        $thongKeTheoThang[$monthName] = [
            'tong_cham_cong' => $chamCongThang->count(),
            'dung_gio' => $chamCongThang->where('trang_thai', 'dung_gio')->count(),
            'di_tre' => $chamCongThang->where('trang_thai', 'di_muon')->count(),
            've_som' => $chamCongThang->where('trang_thai', 've_som')->count(),
            'nghi_phep' => $chamCongThang->where('trang_thai', 'nghi_phep')->count(),
            'ty_le_cham_cong' => $workingDays > 0 ? round(($chamCongThang->count() / $workingDays) * 100, 1) : 0
        ];
    }
    // dd($thongKeTheoThang);
    // 6. Tính tổng giờ làm việc (nếu có lưu giờ vào/ra)
    $tongGioLamViecThangNay = 0;
    $tongGioLamViecNamNay = 0;

    foreach ($chamCongThangNay as $chamCong) {
        $tongGioLamViecThangNay += $chamCong->so_gio_lam;

    }

    foreach ($chamCongNamNay as $chamCong) {

                $tongGioLamViecNamNay += $chamCong->so_gio_lam;

    }
    // 7. Lịch sử chấm công gần đây (7 ngày)
    $lichSuChamCongGanDay = $nguoiDung->chamCong()
        ->whereBetween('ngay_cham_cong', [$today->copy()->subDays(6), $today])
        ->orderBy('ngay_cham_cong', 'desc')
        ->get();

    // 8. Ranking so với đồng nghiệp cùng phòng ban
    $dongNghiepCungPhongBan = NguoiDung::where('phong_ban_id', $nguoiDung->phong_ban_id)
        ->where('id', '!=', $nguoiDung->id)
        ->where('trang_thai', 1)
        ->has('hoSo') // <- Chỉ lấy những người có hồ sơ
        ->get();
    // dd($dongNghiepCungPhongBan);
    $rankingData = [];
    foreach ($dongNghiepCungPhongBan as $dongNghiep) {
        $chamCongDongNghiep = $dongNghiep->chamCong()
            ->whereBetween('ngay_cham_cong', [$startOfMonth, $endOfMonth])
            ->count();

        $tyLeDongNghiep = $soNgayLamViecTrongThang > 0
            ? round(($chamCongDongNghiep / $soNgayLamViecTrongThang) * 100, 1)
            : 0;
            // dump($dongNghiep->hoSo->ho);
            $hoSo = optional($dongNghiep->hoSo);
            // dump(isset($hoSo->ho));
        if(isset($hoSo->ho) && isset($hoSo->ten)) {
            $rankingData[] = [
            'ten' => $hoSo->ho . ' ' . $hoSo->ten,
            'ty_le_cham_cong' => $tyLeDongNghiep
            ];
        }

    }
    // dd($rankingData);

    // Thêm bản thân vào ranking
    $rankingData[] = [
        'ten' => $nguoiDung->hoSo->ho . ' ' . $nguoiDung->hoSo->ten,
        'ty_le_cham_cong' => $tyLeChamCongThangNay,
        'is_current_user' => true
    ];

    // Sắp xếp theo tỷ lệ chấm công
    usort($rankingData, function($a, $b) {
        return $b['ty_le_cham_cong'] <=> $a['ty_le_cham_cong'];
    });

    // Tìm vị trí của user hiện tại
    $viTriRanking = 0;
    foreach ($rankingData as $index => $item) {
        if (isset($item['is_current_user'])) {
            $viTriRanking = $index + 1;
            break;
        }
    }
    // dd($lichSuChamCongGanDay);
    return view('admin.dashboard.personal-stats', compact(
        'nguoiDung',
        'thongTinCoBan',
        'soNgayChamCongThangNay',
        'soNgayDiTreThangNay',
        'soNgayVeSlmThangNay',
        'soNgayNghiPhepThangNay',
        'soNgayDungGioThangNay',
        'tyLeChamCongThangNay',
        'tyLeChamCongThayDoi',
        'soNgayChamCongNamNay',
        'soNgayDiTreNamNay',
        'soNgayVeSomNamNay',
        'soNgayNghiPhepNamNay',
        'tongGioLamViecThangNay',
        'tongGioLamViecNamNay',
        'thongKeTheoThang',
        'lichSuChamCongGanDay',
        'rankingData',
        'viTriRanking',
        'soNgayLamViecTrongThang'
    ));
}



}
