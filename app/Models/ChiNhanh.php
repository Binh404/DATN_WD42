<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ChiNhanh extends Model
{
    use HasFactory;

    protected $table = 'chi_nhanh';

    protected $fillable = [
        'ten',
        'ma',
        'dia_chi',
        'so_dien_thoai',
        'email',
        'thanh_pho',
        'tinh_thanh',
        'ma_buu_dien',
        'quan_ly_id',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function phongBan()
    {
        return $this->hasMany(PhongBan::class, 'chi_nhanh_id');
    }

    public function quanLy()
    {
        return $this->belongsTo(NguoiDung::class, 'quan_ly_id');
    }
}
