<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiNghiPhep extends Model
{
    use HasFactory;

    protected $table = 'loai_nghi_phep';

    protected $fillable = [
        'ten',
        'ma',
        'mo_ta',
        'so_ngay_nam',
        'toi_da_ngay_lien_tiep',
        'so_ngay_bao_truoc',
        'cho_phep_chuyen_nam',
        'toi_da_ngay_chuyen',
        'gioi_tinh_ap_dung',
        'yeu_cau_giay_to',
        'co_luong',
        'mau_sac',
        'trang_thai',
    ];

    protected $casts = [
        'so_ngay_nam' => 'integer',
        'toi_da_ngay_lien_tiep' => 'integer',
        'so_ngay_bao_truoc' => 'integer',
        'cho_phep_chuyen_nam' => 'boolean',
        'toi_da_ngay_chuyen' => 'integer',
        'yeu_cau_giay_to' => 'boolean',
        'co_luong' => 'boolean',
        'trang_thai' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function soDuNghiPhep()
    {
        return $this->hasMany(SoDuNghiPhepNhanVien::class, 'loai_nghi_phep_id');
    }

    public function donXinNghi()
    {
        return $this->hasMany(DonXinNghi::class, 'loai_nghi_phep_id');
    }
}
