<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongViec extends Model
{
     use HasFactory;

    protected $table = 'congviec';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id';  // Khóa chính
    protected $fillable = [
        'ten_cong_viec',
        'mo_ta',
        'trang_thai',
        'do_uu_tien',
        'ngay_bat_dau',
        'deadline',
        'ngay_hoan_thanh',
    ];  // Các trường được phép mass assign

    // Mối quan hệ với bảng Phân công công việc
    public function phancongs()
    {
        return $this->hasMany(PhanCong::class, 'cong_viec_id', 'id');
    }
}
