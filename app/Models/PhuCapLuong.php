<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuCapLuong extends Model
{
    use HasFactory;

    protected $table = 'phu_cap_luong';

    protected $fillable = [
        'luong_nhan_vien_id',
        'phu_cap_id',
        'so_tien',
        'ghi_chu',
    ];

    protected $casts = [
        'so_tien' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function luongNhanVien()
    {
        return $this->belongsTo(LuongNhanVien::class, 'luong_nhan_vien_id');
    }

    public function phuCap()
    {
        return $this->belongsTo(PhuCap::class, 'phu_cap_id');
    }
}
