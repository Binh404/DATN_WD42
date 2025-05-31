<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanCongCongViec extends Model
{
    use HasFactory;

    protected $table = 'phan_cong_cong_viec';

    protected $fillable = [
        'nguoi_giao_id',
        'nguoi_nhan_id',
        'cong_viec_id',
        'phong_ban_id',
        'vai_tro_trong_cv',
        'ghi_chu',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nguoiGiao()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_giao_id');
    }

    public function nguoiNhan()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_nhan_id');
    }

    public function congViec()
    {
        return $this->belongsTo(CongViec::class, 'cong_viec_id');
    }

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id');
    }
}
