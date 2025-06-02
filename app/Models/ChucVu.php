<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
     use HasFactory;

    protected $table = 'chuc_vu';

    protected $fillable = [
        'ten',
        'ma',
        'mo_ta',
        'phong_ban_id',
        'cap_do',
        'luong_toi_thieu',
        'luong_toi_da',
        'trach_nhiem',
        'yeu_cau',
        'trang_thai',
    ];

    protected $casts = [
        'cap_do' => 'integer',
        'luong_toi_thieu' => 'decimal:2',
        'luong_toi_da' => 'decimal:2',
        'trach_nhiem' => 'json',
        'yeu_cau' => 'json',
        'trang_thai' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id');
    }

    public function nhanVien()
    {
        return $this->hasMany(NguoiDung::class, 'chuc_vu_id');
    }
}
