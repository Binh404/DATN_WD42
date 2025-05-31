<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    use HasFactory;

    protected $table = 'cham_cong';

    protected $fillable = [
        'nguoi_dung_id',
        'ngay_cham_cong',
        'gio_vao',
        'gio_ra',
        'so_gio_lam',
        'so_cong',
        'gio_tang_ca',
        'phut_di_muon',
        'phut_ve_som',
        'trang_thai',
        'vi_tri_check_in',
        'vi_tri_check_out',
        'dia_chi_ip',
        'ghi_chu',
        'nguoi_phe_duyet_id',
        'thoi_gian_phe_duyet',
    ];

    protected $casts = [
        'ngay_cham_cong' => 'date',
        'gio_vao' => 'datetime',
        'gio_ra' => 'datetime',
        'so_gio_lam' => 'decimal:1',
        'so_cong' => 'decimal:1',
        'gio_tang_ca' => 'decimal:1',
        'phut_di_muon' => 'integer',
        'phut_ve_som' => 'integer',
        'thoi_gian_phe_duyet' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function nguoiPheDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_phe_duyet_id');
    }
}
