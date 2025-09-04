<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuCap extends Model
{
    use HasFactory;

    protected $table = 'phu_cap';

    protected $fillable = [
        'ten',
        'ma',
        'mo_ta',
        'loai_phu_cap',
        'so_tien_mac_dinh',
        'cach_tinh',
        'chiu_thue',
        'dieu_kien_ap_dung',
        'trang_thai',
    ];

    protected $casts = [
        'so_tien_mac_dinh' => 'decimal:2',
        'chiu_thue' => 'boolean',
        'dieu_kien_ap_dung' => 'json',
        'trang_thai' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function phuCapNhanVien()
    {
        return $this->hasMany(PhuCapNhanVien::class, 'phu_cap_id');
    }

    public function phuCapLuong()
    {
        return $this->hasMany(PhuCapLuong::class, 'phu_cap_id');
    }
}
