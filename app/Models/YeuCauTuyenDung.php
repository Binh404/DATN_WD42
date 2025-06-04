<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuCauTuyenDung extends Model
{
    use HasFactory;

    protected $table = 'yeu_cau_tuyen_dung';

    protected $fillable = [
        'ma',
        'nguoi_tao_id',
        'phong_ban_id',
        'chuc_vu_id',
        'chi_nhanh_id',
        'so_luong',
        'loai_hop_dong',
        'luong_toi_thieu',
        'luong_toi_da',
        'trinh_do_hoc_van',
        'kinh_nghiem_toi_thieu',
        'kinh_nghiem_toi_da',
        'mo_ta_cong_viec',
        'yeu_cau',
        'ky_nang_yeu_cau',
        'ghi_chu',
        'trang_thai',
        'nguoi_duyet_id',
        'thoi_gian_duyet',
    ];

    protected $casts = [
        'thoi_gian_duyet' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Người tạo yêu cầu (trưởng phòng)
     */
    public function nguoiTao()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tao_id');
    }

    /**
     * Người duyệt yêu cầu (giám đốc)
     */
    public function nguoiDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_duyet_id');
    }

    /**
     * Phòng ban liên quan
     */
    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id');
    }

    /**
     * Chức vụ cần tuyển
     */
    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chuc_vu_id');
    }

    /**
     * Chi nhánh tuyển dụng (nếu có)
     */
    public function chiNhanh()
    {
        return $this->belongsTo(ChiNhanh::class, 'chi_nhanh_id');
    }
}
