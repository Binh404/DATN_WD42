<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuongNhanVien extends Model
{
    use HasFactory;

    protected $table = 'luong_nhan_vien';

    protected $fillable = [
        'bang_luong_id',
        'nguoi_dung_id',
        'luong_co_ban',
        'tong_phu_cap',
        'tong_khau_tru',
        'tong_luong',
        'luong_thuc_nhan',
        'so_ngay_cong',
        'gio_tang_ca',
        'cong_tang_ca',
        'ghi_chu',
    ];

    protected $casts = [
        'luong_co_ban' => 'decimal:2',
        'tong_phu_cap' => 'decimal:2',
        'tong_khau_tru' => 'decimal:2',
        'tong_luong' => 'decimal:2',
        'luong_thuc_nhan' => 'decimal:2',
        'so_ngay_cong' => 'decimal:1',
        'gio_tang_ca' => 'decimal:1',
        'cong_tang_ca' => 'decimal:1',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bangLuong()
    {
        return $this->belongsTo(BangLuong::class, 'bang_luong_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function phuCapLuong()
    {
        return $this->hasMany(PhuCapLuong::class, 'luong_nhan_vien_id');
    }

    public function khauTruLuong()
    {
        return $this->hasMany(KhauTruLuong::class, 'luong_nhan_vien_id');
    }

}