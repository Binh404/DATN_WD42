<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Luong extends Model
{
    use HasFactory;

    protected $table = 'luong';

    protected $fillable = [
        'nguoi_dung_id',
        'hop_dong_lao_dong_id',
        'luong_co_ban',
        'phu_cap',
        'tien_thuong',
        'tien_phat',
    ];

    protected $casts = [
        'luong_co_ban' => 'decimal:2',
        'phu_cap' => 'decimal:2',
        'tien_thuong' => 'decimal:2',
        'tien_phat' => 'decimal:2',
    ];

    /**
     * Quan hệ với bảng nguoi_dung
     */
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    /**
     * Quan hệ với bảng hop_dong_lao_dong
     */
    public function hopDongLaoDong()
    {
        return $this->belongsTo(HopDongLaoDong::class, 'hop_dong_lao_dong_id');
    }

    /**
     * Tính tổng lương
     */
    public function getTongLuongAttribute()
    {
        return $this->luong_co_ban + $this->phu_cap + $this->tien_thuong - $this->tien_phat;
    }
} 