<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CongViec extends Model
{
    use HasFactory;

    protected $table = 'cong_viec';

    protected $fillable = [
        'ten_cong_viec',
        'mo_ta',
        'trang_thai',
        'do_uu_tien',
        'ngay_bat_dau',
        'deadline',
        'ngay_hoan_thanh',
        'tien_do',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'datetime',
        'deadline' => 'datetime',
        'ngay_hoan_thanh' => 'datetime',
        'tien_do' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function phanCong()
    {
        return $this->hasMany(PhanCongCongViec::class, 'cong_viec_id');
    }
}
