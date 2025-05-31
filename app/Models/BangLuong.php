<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangLuong extends Model
{
    use HasFactory;

    protected $table = 'bang_luong';

    protected $fillable = [
        'ma_bang_luong',
        'loai_bang_luong',
        'nam',
        'thang',
        'ngay_tra_luong',
        'trang_thai',
        'nguoi_xu_ly_id',
        'thoi_gian_xu_ly',
        'nguoi_phe_duyet_id',
        'thoi_gian_phe_duyet',
    ];

    protected $casts = [
        'nam' => 'integer',
        'thang' => 'integer',
        'ngay_tra_luong' => 'date',
        'thoi_gian_xu_ly' => 'datetime',
        'thoi_gian_phe_duyet' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function luongNhanVien()
    {
        return $this->hasMany(LuongNhanVien::class, 'bang_luong_id');
    }

    public function nguoiXuLy()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_xu_ly_id');
    }

    public function nguoiPheDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_phe_duyet_id');
    }

}
