<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhauTruLuong extends Model
{
    use HasFactory;

    protected $table = 'khau_tru_luong';

    protected $fillable = [
        'luong_nhan_vien_id',
        'loai_khau_tru',
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
}
