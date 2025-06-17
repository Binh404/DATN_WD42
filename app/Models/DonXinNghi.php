<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonXinNghi extends Model
{
     use HasFactory;

    protected $table = 'don_xin_nghi';

    protected $fillable = [
        'ma_don_nghi',
        'nguoi_dung_id',
        'loai_nghi_phep_id',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'so_ngay_nghi',
        'ly_do',
        'tai_lieu_ho_tro',
        'lien_he_khan_cap',
        'sdt_khan_cap',
        'ban_giao_cho_id',
        'ghi_chu_ban_giao',
        'trang_thai',
        'nguoi_duyet_id',
        'thoi_gian_duyet',
        'ly_do_tu_choi',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
        'so_ngay_nghi' => 'decimal:1',
        'tai_lieu_ho_tro' => 'array',
        'thoi_gian_duyet' => 'datetime',
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

    public function banGiaoCho()
    {
        return $this->belongsTo(NguoiDung::class, 'ban_giao_cho_id');
    }

    // public function nguoiDuyet()
    // {
    //     return $this->belongsTo(NguoiDung::class, 'nguoi_duyet_id');
    // }

    public function lichSuDuyet()
    {
        return $this->hasMany(LichSuDuyetDonNghi::class, 'don_xin_nghi_id');
    }
}
