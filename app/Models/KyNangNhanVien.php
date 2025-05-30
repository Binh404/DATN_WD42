<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KyNangNhanVien extends Model
{
    use HasFactory;

    protected $table = 'ky_nang_nhan_vien';

    protected $fillable = [
        'nguoi_dung_id',
        'ky_nang_id',
        'trinh_do',
        'so_nam_kinh_nghiem',
        'chung_chi',
        'ngay_cap_chung_chi',
        'ngay_het_han',
        'da_xac_minh',
        'nguoi_xac_minh_id',
    ];

    protected $casts = [
        'so_nam_kinh_nghiem' => 'decimal:1',
        'ngay_cap_chung_chi' => 'date',
        'ngay_het_han' => 'date',
        'da_xac_minh' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function kyNang()
    {
        return $this->belongsTo(KyNang::class, 'ky_nang_id');
    }

    public function nguoiXacMinh()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_xac_minh_id');
    }
}
