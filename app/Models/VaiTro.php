<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VaiTro extends SpatieRole
{
    use HasFactory;

    protected $table = 'vai_tro';

    protected $fillable = [
        'ten',
        'ten_hien_thi',
        'mo_ta',
        // 'la_vai_tro_he_thong',
        // 'trang_thai',
    ];

    // protected $casts = [
    //     'la_vai_tro_he_thong' => 'boolean',
    //     'trang_thai' => 'boolean',
    // ];

    // Relationships
    public function quyens()
    {
        return $this->belongsToMany(Quyen::class, 'vai_tro_quyen', 'vai_tro_id', 'quyen_id')
                    ->withTimestamps();
    }

    public function nguoiDungs()
    {
        return $this->belongsToMany(NguoiDung::class, 'nguoi_dung_vai_tro', 'vai_tro_id', 'nguoi_dung_id')
                    ->withTimestamps();
    }

    public function nguoiDung()
    {
        return $this->hasMany(NguoiDung::class, 'vai_tro_id');
    }
}
