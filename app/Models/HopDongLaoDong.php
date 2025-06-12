<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDongLaoDong extends Model
{
     use HasFactory;

    protected $table = 'hop_dong_lao_dong';

    protected $fillable = [
        'nguoi_dung_id',
        'chuc_vu_id',
        'chuc_vu',
        'so_hop_dong',
        'loai_hop_dong',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'luong_co_ban',
        'phu_cap',
        'hinh_thuc_lam_viec',
        'dia_diem_lam_viec',
        'duong_dan_file',
        'dieu_khoan',
        'trang_thai_hop_dong',
        'trang_thai_ky',
        'nguoi_ky_id',
        'thoi_gian_ky',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'luong_co_ban' => 'decimal:2',
        'phu_cap' => 'decimal:2',
        'thoi_gian_ky' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function nguoiKy()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_ky_id');
    }

    public function hoSoNguoiDung()
    {
        return $this->belongsTo(HoSoNguoiDung::class, 'nguoi_dung_id', 'nguoi_dung_id');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chuc_vu_id');
    }
}
