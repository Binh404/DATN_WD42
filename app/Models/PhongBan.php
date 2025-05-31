<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    use HasFactory;

    protected $table = 'phong_ban';

    protected $fillable = [
        'ten_phong_ban',
        'ma_phong_ban',
        'mo_ta',
        'truong_phong_id',
        'chi_nhanh_id',
        'phong_ban_cha_id',
        'ngan_sach',
        'trang_thai',
    ];

    // protected $casts = [
    //     'ngan_sach' => 'decimal:2',
    //     'trang_thai' => 'boolean',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];

    public function chiNhanh()
    {
        return $this->belongsTo(ChiNhanh::class, 'chi_nhanh_id');
    }

    public function truongPhong()
    {
        return $this->belongsTo(NguoiDung::class, 'truong_phong_id');
    }

    public function phongBanCha()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_cha_id');
    }

    public function phongBanCon()
    {
        return $this->hasMany(PhongBan::class, 'phong_ban_cha_id');
    }

    public function nhanVien()
    {
        return $this->hasMany(NguoiDung::class, 'phong_ban_id');
    }

    public function chucVu()
    {
        return $this->hasMany(ChucVu::class, 'phong_ban_id');
    }
}
