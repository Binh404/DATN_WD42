<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KyNang extends Model
{
    use HasFactory;

    protected $table = 'ky_nang';

    protected $fillable = [
        'ten',
        'danh_muc',
        'mo_ta',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kyNangNhanVien()
    {
        return $this->hasMany(KyNangNhanVien::class, 'ky_nang_id');
    }
}
