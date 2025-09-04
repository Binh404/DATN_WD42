<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoDuNghiPhepNhanVien extends Model
{
     use HasFactory;

    protected $table = 'so_du_nghi_phep_nhan_vien';

    protected $fillable = [
        'nguoi_dung_id',
        'loai_nghi_phep_id',
        'nam',
        'so_ngay_duoc_cap',
        'so_ngay_da_dung',
        'so_ngay_cho_duyet',
        'so_ngay_con_lai',
        'so_ngay_chuyen_tu_nam_truoc',
    ];

    protected $casts = [
        'nam' => 'integer',
        'so_ngay_duoc_cap' => 'decimal:1',
        'so_ngay_da_dung' => 'decimal:1',
        'so_ngay_cho_duyet' => 'decimal:1',
        'so_ngay_con_lai' => 'decimal:1',
        'so_ngay_chuyen_tu_nam_truoc' => 'decimal:1',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function loaiNghiPhep()
    {
        return $this->belongsTo(LoaiNghiPhep::class, 'loai_nghi_phep_id');
    }
}
