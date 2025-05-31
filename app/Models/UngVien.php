<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngVien extends Model
{
    use HasFactory;

    protected $table = 'ung_vien';

    protected $fillable = [
        'tin_tuyen_dung_id',
        'ma_ho_so',
        'ho',
        'ten',
        'email',
        'so_dien_thoai',
        'dia_chi',
        'ngay_sinh',
        'gioi_tinh',
        'trinh_do_hoc_van',
        'so_nam_kinh_nghiem',
        'luong_hien_tai',
        'luong_mong_muon',
        'duong_dan_cv',
        'thu_xin_viec',
        'url_portfolio',
        'url_linkedin',
        'ky_nang',
        'ngay_co_the_lam_viec',
        'nguon_ung_tuyen',
        'ten_nguoi_gioi_thieu',
        'trang_thai',
        'diem_phong_van',
        'ghi_chu_phong_van',
        'ly_do_tu_choi',
        'nguoi_dung_id',
        'thoi_gian_nop',
        'nguoi_cap_nhat_cuoi_id',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'so_nam_kinh_nghiem' => 'decimal:1',
        'luong_hien_tai' => 'decimal:2',
        'luong_mong_muon' => 'decimal:2',
        'ky_nang' => 'array',
        'ngay_co_the_lam_viec' => 'date',
        'diem_phong_van' => 'decimal:2',
        'thoi_gian_nop' => 'datetime',
    ];

    // Relationships
    public function tinTuyenDung()
    {
        return $this->belongsTo(TinTuyenDung::class, 'tin_tuyen_dung_id');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function nguoiCapNhatCuoi()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_cap_nhat_cuoi_id');
    }

    public function taiLieus()
    {
        return $this->hasMany(TaiLieu::class, 'ung_vien_id');
    }

    // Enums
    public const GIOI_TINH = [
        'nam' => 'Nam',
        'nu' => 'Nữ',
        'khac' => 'Khác',
    ];

    public const NGUON_UNG_TUYEN = [
        'website' => 'Website',
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIn',
        'gioi_thieu' => 'Giới thiệu',
        'khac' => 'Khác',
    ];

    public const TRANG_THAI = [
        'moi_nop' => 'Mới nộp',
        'da_xem' => 'Đã xem',
        'phong_van' => 'Phỏng vấn',
        'tu_choi' => 'Từ chối',
        'trung_tuyen' => 'Trúng tuyển',
    ];

    // Helper methods
    public function getHoTenAttribute(): string
    {
        return $this->ho . ' ' . $this->ten;
    }
}
