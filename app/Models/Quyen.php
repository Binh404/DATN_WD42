<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    use HasFactory;

    protected $table = 'quyen';

    protected $fillable = [
        'ten',
        'ten_hien_thi',
        'mo_ta',
        'nhom_quyen_id',
        'phan_he',
        'hanh_dong',
    ];

    // Relationships
    public function nhomQuyen()
    {
        return $this->belongsTo(NhomQuyen::class, 'nhom_quyen_id');
    }

    public function vaiTros(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(VaiTro::class, 'vai_tro_quyen', 'quyen_id', 'vai_tro_id')
                    ->withTimestamps();
    }

    public function nguoiDungs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(NguoiDung::class, 'nguoi_dung_quyen', 'quyen_id', 'nguoi_dung_id')
                    ->withTimestamps();
    }
}
