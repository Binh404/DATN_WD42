<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{
    protected $table = 'ung_tuyen';
    use HasFactory;

    protected $fillable = [
        'ma_ung_tuyen',
        'tin_tuyen_dung_id',
        'ten_ung_vien',
        'email',
        'so_dien_thoai',
        'kinh_nghiem',
        'ky_nang',
        'thu_gioi_thieu',
        'tai_cv',
        'diem_danh_gia',
        'trang_thai_email',
        'trang_thai_email_trungtuyen',
        'trang_thai_pv',
        'diem_phong_van',
        'ghi_chu',
        'nguoi_cap_nhat',
        'trang_thai',
        'ly_do',
        'ngay_cap_nhat',
        'nguoi_cap_nhat_id',
        'nguoi_cap_nhat_cuoi_id',
        'chuc_vu_id',
        'vai_tro_id',
        'phong_ban_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ungTuyen) {
            $ungTuyen->trang_thai_pv = 'chưa phỏng vấn';
        });
    }

    public function nguoiCapNhat()
    {
        return $this->belongsTo(User::class, 'nguoi_cap_nhat');
    }

    public function nguoiCapNhatTrangThai()
    {
        return $this->belongsTo(User::class, 'nguoi_cap_nhat_id');
    }

  
    public function tinTuyenDung()
    {
        return $this->belongsTo(TinTuyenDung::class, 'tin_tuyen_dung_id');
    }

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chuc_vu_id');
    }

    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }
}
