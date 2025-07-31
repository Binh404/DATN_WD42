<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonDeXuat extends Model
{
    protected $table = 'don_de_xuat';

        protected $fillable = [
        'nguoi_tao_id',
        'nguoi_duoc_de_xuat_id',
        'loai_de_xuat',
        'vai_tro_nguoi_tao',
        'trang_thai',
        'ghi_chu',
        'ly_do_tu_choi',
        'nguoi_duyet_id',
        'thoi_gian_duyet',
        'ngay_nghi_du_kien',
    ];
     protected $dates = [
        'thoi_gian_duyet',
        'ngay_nghi_du_kien',
        'created_at',
        'updated_at',
    ];

    // Người tạo đề xuất (nhân viên, HR, trưởng phòng)
    public function nguoiTao()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tao_id');
    }

    // Người được đề xuất
    public function nguoiDuocDeXuat()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_duoc_de_xuat_id');
    }

    // Người duyệt (HR hoặc admin)
    public function nguoiDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_duyet_id');
    }
}