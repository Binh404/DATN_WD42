<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{

    protected $table = 'ung_tuyen';
    use HasFactory;

    protected $fillable = [
        'job_id',
        'ten_ung_vien',
        'email',
        'so_dien_thoai',
        'kinh_nghiem',
        'ky_nang',
        'thu_gioi_thieu',
        'cv_path'
    ];
}
