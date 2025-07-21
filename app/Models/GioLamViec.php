<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioLamViec extends Model
{
    use HasFactory;
    protected $table = 'gio_lam_viec';

    protected $fillable = [
        'gio_bat_dau',
        'gio_ket_thuc',
        'gio_nghi_trua',
        'so_phut_cho_phep_di_tre',
        'so_phut_cho_phep_ve_som',
        'gio_bat_dau_tang_ca',
    ];
}
