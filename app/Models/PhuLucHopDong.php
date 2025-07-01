<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuLucHopDong extends Model
{
    use HasFactory;

    protected $table = 'phu_luc_hop_dong';

    protected $fillable = [
        'so_phu_luc',
        'ten_phu_luc',
        'ngay_ky',
        'ngay_hieu_luc',
        'trang_thai_ky',
        'hop_dong_id',
        'nguoi_tao_id',
        'chuc_vu_id',
        'loai_hop_dong',
        'ngay_ket_thuc',
        'luong_co_ban',
        'phu_cap',
        'hinh_thuc_lam_viec',
        'dia_diem_lam_viec',
        'tep_dinh_kem',
        'noi_dung_thay_doi',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_ky' => 'date',
        'ngay_hieu_luc' => 'date',
        'ngay_ket_thuc' => 'date',
        'luong_co_ban' => 'decimal:2',
        'phu_cap' => 'decimal:2',
    ];

    public function hopDong()
    {
        return $this->belongsTo(HopDongLaoDong::class, 'hop_dong_id');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chuc_vu_id');
    }

    public function nguoiTao()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tao_id');
    }
}
