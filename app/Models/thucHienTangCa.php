<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class thucHienTangCa extends Model
{
    protected $table = 'thuc_hien_tang_ca';

    protected $fillable = [
        'dang_ky_tang_ca_id',
        'gio_bat_dau_thuc_te',
        'gio_ket_thuc_thuc_te',
        'so_gio_tang_ca_thuc_te',
        'cong_viec_da_thuc_hien',
        'so_cong_tang_ca',
        'trang_thai',
        'vi_tri_check_in',
        'vi_tri_check_out',
        'ghi_chu',
    ];

    public function dangKyTangCa()
    {
        return $this->belongsTo(DangKyTangCa::class, 'dang_ky_tang_ca_id');
    }
    public static function layBanGhiTheoDonTangCa($donTangCaId)
    {
        return self::where('dang_ky_tang_ca_id', $donTangCaId)
        ->first();
    }
    public function capNhatSoGio(){
        $gioBatDauThucTe = Carbon::parse($this->gio_bat_dau_thuc_te);
        $gioKetThucThucTe = Carbon::parse($this->gio_ket_thuc_thuc_te);

        if ($gioKetThucThucTe->lessThan($gioBatDauThucTe)) {
            $gioKetThucThucTe->addDay(); // Assume end time is on the next day
        }

        $phut = $gioBatDauThucTe->diffInMinutes($gioKetThucThucTe);
        $soGio = $phut / 60;

        $this->so_gio_tang_ca_thuc_te = $soGio;
        return $soGio;
    }


    public function capNhatTrangThai($soGioTangCa){
        if ($soGioTangCa <= $this->so_gio_tang_ca_thuc_te) {
            $this->trang_thai = 'hoan_thanh';
        }else{
            $this->trang_thai = 'khong_hoan_thanh';
        }
        return $this->trang_thai;

    }
    public function capNhapSoCong($loaiTangCa, $soGioTangCa){
        if($this->trang_thai == 'khong_hoan_thanh'){
            $soGioTangCa = $this->so_gio_tang_ca_thuc_te;
        }
        if ($loaiTangCa == 'ngay_thuong') {
            // 1.5x lương → chia cho 8 để ra số công
        $this->so_cong_tang_ca = ($soGioTangCa * 1.5) / 8;
        } elseif ($loaiTangCa == 'ngay_nghi') {
            // 2x lương → chia cho 8 để ra số công
            $this->so_cong_tang_ca = ($soGioTangCa * 2) / 8;
        } else {
            // Mặc định là ngày lễ: 3x lương → chia cho 8
            $this->so_cong_tang_ca = ($soGioTangCa * 3) / 8;
        }

        return $this->so_cong_tang_ca;
    }
    public function getTrangThaiTextAttribute()
    {
        return match ($this->trang_thai) {
            'chua_lam' => 'Chưa làm',
            'dang_lam' => 'Đang làm',
            'hoan_thanh' => 'Hoàn thành',
            'khong_hoan_thanh' => 'Không hoàn thành',
            // 'nghi_phep' => 'Nghỉ phép',
            default => 'Không xác định'
        };
    }

}
