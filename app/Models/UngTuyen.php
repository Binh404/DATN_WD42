<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{

    protected $table = 'ung_tuyen';
    use HasFactory;

    protected $fillable = [
        'tin_tuyen_dung_id',
        'ten_ung_vien',
        'email',
        'so_dien_thoai',
        'kinh_nghiem',
        'ky_nang',
        'thu_gioi_thieu',
        'tai_cv'
    ];

    public function tinTuyenDung() {
        return $this->belongsTo(TinTuyenDung::class, 'tin_tuyen_dung_id');
    }
}
