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
        'luong_co_ban',
        'trang_thai',
    ];

    protected $casts = [
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
