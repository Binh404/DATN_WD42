<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Quyen extends SpatiePermission
{
    protected $table = 'quyen';

    protected $fillable = [
        'ten', // cột bạn đang dùng để lưu tên quyền
        'ten_hien_thi',
        'mo_ta',
        'nhom_quyen_id',
        'phan_he',
        'hanh_dong',
        'guard_name',
    ];

    // Map thuộc tính name cho Spatie
    public function getNameAttribute()
    {
        return $this->attributes['ten'];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['ten'] = $value;
    }

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