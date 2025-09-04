<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\DangKyTangCa;
use App\Models\ThucHienTangCa;
use Illuminate\Support\Facades\Schema;

class TangCaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra ràng buộc khóa ngoại
    Schema::disableForeignKeyConstraints();

    // Xóa dữ liệu cũ để seed mới
    DB::table('thuc_hien_tang_ca')->truncate();
    DB::table('dang_ky_tang_ca')->truncate();

    // Bật lại kiểm tra ràng buộc
    Schema::enableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();
        // Giả sử có 5 nhân viên sẽ được seed
        $nguoiDungIds = [1, 2, 3, 4, 5];

        // Tạo 20 bản ghi đăng ký tăng ca
        foreach (range(1, 20) as $i) {
            $nguoiDungId = $nguoiDungIds[array_rand($nguoiDungIds)];

            // Random ngày trong tháng hiện tại
           $ngayTangCa = Carbon::create(2025, 8, 1)->addDays(rand(0, 30));

            // Xác định loại tăng ca
            $loaiTangCa = $this->xacDinhLoaiTangCa($ngayTangCa);

            // Thời gian bắt đầu và kết thúc tăng ca
            if ($loaiTangCa === 'ngay_thuong') {
                $gioBatDau = '18:30';
                $gioKetThuc = Carbon::createFromFormat('H:i', $gioBatDau)->addHours(rand(2, 4))->format('H:i');
            } else {
                // Ngày nghỉ hoặc lễ: tăng ca từ 08:00 sáng
                $gioBatDau = '08:00';
                $gioKetThuc = Carbon::createFromFormat('H:i', $gioBatDau)->addHours(rand(4, 6))->format('H:i');
            }

            // Tạo bản ghi đăng ký tăng ca
            $dangKy = DangKyTangCa::create([
                'nguoi_dung_id'   => $nguoiDungId,
                'ngay_tang_ca'    => $ngayTangCa,
                'gio_bat_dau'     => $gioBatDau,
                'gio_ket_thuc'    => $gioKetThuc,
                'so_gio_tang_ca'  => Carbon::createFromFormat('H:i', $gioBatDau)
                                        ->diffInMinutes(Carbon::createFromFormat('H:i', $gioKetThuc)) / 60,
                'loai_tang_ca'    => $loaiTangCa,
                'ly_do_tang_ca'   => 'Hoàn thành dự án quan trọng',
                'trang_thai'      => 'da_duyet',
                'nguoi_duyet_id'  => 1,
                'thoi_gian_duyet' => Carbon::now(),
            ]);

            // Tạo bản ghi thực hiện tăng ca tương ứng
            $gioBatDauThucTe = $gioBatDau;
            $gioKetThucThucTe = Carbon::createFromFormat('H:i', $gioBatDauThucTe)
                                      ->addHours(rand(2, 5))->format('H:i');

            ThucHienTangCa::create([
                'dang_ky_tang_ca_id'    => $dangKy->id,
                'gio_bat_dau_thuc_te'   => $gioBatDauThucTe,
                'gio_ket_thuc_thuc_te'  => $gioKetThucThucTe,
                'so_gio_tang_ca_thuc_te'=> Carbon::createFromFormat('H:i', $gioBatDauThucTe)
                                                ->diffInMinutes(Carbon::createFromFormat('H:i', $gioKetThucThucTe)) / 60,
                'cong_viec_da_thuc_hien'=> 'Hoàn thành module API backend',
                'so_cong_tang_ca'       => $this->tinhSoCongTangCa($loaiTangCa, $gioBatDauThucTe, $gioKetThucThucTe),
                'trang_thai'            => 'hoan_thanh',
                'vi_tri_check_in'       => 'Văn phòng Hà Nội',
                'vi_tri_check_out'      => 'Văn phòng Hà Nội',
                'ghi_chu'              => 'Hoàn thành tốt công việc',
            ]);
        }
    }

    /**
     * Xác định loại tăng ca theo ngày.
     */
    private function xacDinhLoaiTangCa($ngay)
    {
        if ($ngay->isWeekend()) {
            return 'ngay_nghi';
        }

        // Giả định ngày 2/9 hoặc 30/4 là ngày lễ
        $leTet = ['2025-09-02', '2025-04-30'];
        if (in_array($ngay->format('Y-m-d'), $leTet)) {
            return 'le_tet';
        }

        return 'ngay_thuong';
    }

    /**
     * Tính số công tăng ca theo loại tăng ca.
     */
    private function tinhSoCongTangCa($loaiTangCa, $gioBatDau, $gioKetThuc)
    {
        $gioBatDau = Carbon::createFromFormat('H:i', $gioBatDau);
        $gioKetThuc = Carbon::createFromFormat('H:i', $gioKetThuc);
        $soGio = $gioBatDau->diffInMinutes($gioKetThuc) / 60;

        return match ($loaiTangCa) {
            'ngay_thuong' => ($soGio * 1.5) / 8,
            'ngay_nghi'   => ($soGio * 2) / 8,
            'le_tet'      => ($soGio * 3) / 8,
            default       => $soGio / 8,
        };
    }
}
