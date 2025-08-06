<?php

namespace App\Console\Commands;

use App\Models\HoSoNguoiDung;
use App\Models\LoaiNghiPhep;
use App\Models\NguoiDung;
use App\Models\SoDuNghiPhepNhanVien;
use Illuminate\Console\Command;

class CapNhatSoDuNghiPhepMoi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'capnhat:nghiphep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $namHienTai = date('Y');
        $namTruoc = $namHienTai - 1;

        $nguoiDungs = NguoiDung::all();
        $loaiNghiPheps = LoaiNghiPhep::where('trang_thai', 1)->get();

        foreach ($nguoiDungs as $nguoiDung) {
            foreach ($loaiNghiPheps as $loai) {
                // Nếu chưa có số dư nghỉ phép của năm hiện tại
                $daCo = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $nguoiDung->id)
                    ->where('loai_nghi_phep_id', $loai->id)
                    ->where('nam', $namHienTai)
                    ->exists();



                if (!$daCo) {
                    $gioiTinh = HoSoNguoiDung::where('nguoi_dung_id', $nguoiDung->id)->value('gioi_tinh');
                    if (strcasecmp($loai->ten, 'Nghỉ thai sản') == 0 && $gioiTinh != 'nu') {
                        continue;
                    }

                    if ($loai->cho_phep_chuyen_nam == 1) {
                        $soNgayChuyenToiDa = $loai->toi_da_ngay_chuyen ?? 0;
                        $soDuNamCu = SoDuNghiPhepNhanVien::where('nguoi_dung_id', $nguoiDung->id)
                            ->where('loai_nghi_phep_id', $loai->id)
                            ->where('nam', $namTruoc)
                            ->value('so_ngay_con_lai') ?? 0;
                        $soNgayDuocChuyen = min($soDuNamCu, $soNgayChuyenToiDa);

                        SoDuNghiPhepNhanVien::create([
                            'nguoi_dung_id' => $nguoiDung->id,
                            'loai_nghi_phep_id' => $loai->id,
                            'nam' => now()->year,
                            'so_ngay_duoc_cap' => $loai->so_ngay_nam + $soNgayDuocChuyen,
                            'so_ngay_da_dung' => 0,
                            'so_ngay_cho_duyet' => 0,
                            'so_ngay_con_lai' => $loai->so_ngay_nam + $soNgayDuocChuyen,
                            'so_ngay_chuyen_tu_nam_truoc' => $soNgayDuocChuyen,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    } elseif (strcasecmp($loai->ten, 'Nghỉ thai sản') == 0 && $gioiTinh == 'nu') {
                        SoDuNghiPhepNhanVien::create([
                            'nguoi_dung_id' => $nguoiDung->id,
                            'loai_nghi_phep_id' => $loai->id,
                            'nam' => now()->year,
                            'so_ngay_duoc_cap' => $loai->so_ngay_nam,
                            'so_ngay_da_dung' => 0,
                            'so_ngay_cho_duyet' => 0,
                            'so_ngay_con_lai' => $loai->so_ngay_nam,
                            'so_ngay_chuyen_tu_nam_truoc' => 0,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    } else {
                        SoDuNghiPhepNhanVien::create([
                            'nguoi_dung_id' => $nguoiDung->id,
                            'loai_nghi_phep_id' => $loai->id,
                            'nam' => now()->year,
                            'so_ngay_duoc_cap' => $loai->so_ngay_nam,
                            'so_ngay_da_dung' => 0,
                            'so_ngay_cho_duyet' => 0,
                            'so_ngay_con_lai' => $loai->so_ngay_nam,
                            'so_ngay_chuyen_tu_nam_truoc' => 0,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }

        $this->info("Cập nhật số dư nghỉ phép năm $namHienTai thành công.");
    }
}
