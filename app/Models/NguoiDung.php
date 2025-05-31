<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Model
{
    use  HasFactory, Notifiable;

    protected $table = 'nguoi_dung';

    protected $fillable = [
        'ten_dang_nhap',
        'email',
        'mat_khau',
        'email_da_xac_minh',
        'token_ghi_nho',
        'trang_thai',
        'lan_dang_nhap_cuoi',
        'ip_dang_nhap_cuoi',
        'phong_ban_id',
        'chuc_vu_id',
    ];

    protected $hidden = [
        'mat_khau',
        'token_ghi_nho',
    ];

    protected $casts = [
        'email_da_xac_minh' => 'boolean',
        'trang_thai' => 'integer',
        'lan_dang_nhap_cuoi' => 'datetime',
        'ip_dang_nhap_cuoi' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function hoSo()
    {
        return $this->hasOne(HoSoNguoiDung::class, 'nguoi_dung_id');
    }

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'phong_ban_id');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'chuc_vu_id');
    }

    public function hopDongLaoDong()
    {
        return $this->hasMany(HopDongLaoDong::class, 'nguoi_dung_id');
    }

    public function luongNhanVien()
    {
        return $this->hasMany(LuongNhanVien::class, 'nguoi_dung_id');
    }

    public function vaiTro()
    {
        return $this->belongsToMany(VaiTro::class, 'nguoi_dung_vai_tro', 'nguoi_dung_id', 'vai_tro_id')
                    ->withTimestamps();
    }

    public function quyenTrucTiep()
    {
        return $this->belongsToMany(Quyen::class, 'nguoi_dung_quyen', 'nguoi_dung_id', 'quyen_id')
                    ->withTimestamps();
    }
}
