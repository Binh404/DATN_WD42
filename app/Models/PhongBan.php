<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBan extends Model
{
    use HasFactory;

    protected $table = 'phong_ban';

    protected $fillable = [
        'ten_phong_ban',
        'ma_phong_ban',
        'mo_ta',
        'trang_thai'
    ];

    protected $casts = [
        'trang_thai' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
} 