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
        'so_hop_dong',
        'loai_hop_dong',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'luong_co_ban',
        'duong_dan_file',
        'dieu_khoan',
        'trang_thai',
        'nguoi_ky_id',
        'thoi_gian_ky',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'luong_co_ban' => 'decimal:2',
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
}
