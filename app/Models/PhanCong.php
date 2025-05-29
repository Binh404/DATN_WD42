<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanCong extends Model
{
     use HasFactory;

    protected $table = 'phancong_congviec';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'id';  // Khóa chính
    protected $fillable = [
        'nguoi_giao_id',
        'nguoi_nhan_id',
        'phong_ban_id',
        'cong_viec_id',  // Tạo khóa ngoại tham chiếu đến công việc
    ];  // Các trường được phép mass assign

    // Mối quan hệ với bảng Công việc
    public function congviec()
    {
        return $this->belongsTo(CongViec::class, 'cong_viec_id', 'id');
    }

    // Mối quan hệ với bảng User (người giao công việc)
    public function nguoiGiao()
    {
        return $this->belongsTo(User::class, 'nguoi_giao_id', 'id');
    }

    // Mối quan hệ với bảng User (người nhận công việc)
    public function nguoiNhan()
    {
        return $this->belongsTo(User::class, 'nguoi_nhan_id', 'id');
    }

    // Mối quan hệ với bảng Phòng ban
    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id', 'id');
    }
}
