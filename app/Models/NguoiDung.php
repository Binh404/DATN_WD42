<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
// use Spatie\Permission\Traits\HasRoles;


class NguoiDung extends Authenticatable  implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait;


    protected $table = 'nguoi_dung';

    protected $fillable = [
        'ten_dang_nhap',
        'email',
        'password',
        'vai_tro_id',
        'email_verified_at',
        'token_ghi_nho',
        'trang_thai',
        'lan_dang_nhap_cuoi',
        'ip_dang_nhap_cuoi',
        'phong_ban_id',
        'chuc_vu_id',
    ];

    protected $hidden = [
        'password',
        'token_ghi_nho',
    ];

    protected $casts = [
        'email_verified_at' => 'boolean',
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
    public function hopDongLaoDongMoiNhat()
    {
        return $this->hasOne(HopDongLaoDong::class)->latestOfMany('ngay_bat_dau'); // ✅ chỉ trả về 1 record
    }

    public function luongNhanVien()
    {
        return $this->hasMany(LuongNhanVien::class, 'nguoi_dung_id');
    }
    public function chamCong()
    {
        return $this->hasMany(ChamCong::class, 'nguoi_dung_id');
    }
    public function soDuNghiPhepNhanVien()
    {
        return $this->hasMany(SoDuNghiPhepNhanVien::class, 'nguoi_dung_id');
    }

    public function vaiTros()
    {
        return $this->belongsToMany(VaiTro::class, 'nguoi_dung_vai_tro', 'nguoi_dung_id', 'vai_tro_id')
            ->withTimestamps();
    }
    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }

    public function quyenTrucTiep()
    {
        return $this->belongsToMany(Quyen::class, 'nguoi_dung_quyen', 'nguoi_dung_id', 'quyen_id')
            ->withTimestamps();
    }
    //bảng đơn xin nghi
    public function donXinNghi()
    {
        return $this->hasMany(DonXinNghi::class, 'nguoi_dung_id');
    }

    public function donXinNghiDuocDuyet()
    {
        return $this->hasMany(DonXinNghi::class, 'nguoi_duyet_id');
    }

    public function donXinNghiBanGiao()
    {
        return $this->hasMany(DonXinNghi::class, 'ban_giao_cho_id');
    }


    public function coVaiTro($tenVaiTro)
    {
        return $this->vaiTros()->where('ten', $tenVaiTro)->exists();
    }

    public function coBatKyVaiTro(array $dsTenVaiTro)
    {
        return $this->vaiTro()->whereIn('ten', $dsTenVaiTro)->exists();
    }

    public function duyetDonNghi()
    {
        return $this->hasMany(LichSuDuyetDonNghi::class, 'nguoi_duyet_id');
    }
     public function dangKyTangCa()
    {
        return $this->hasOne(DangKyTangCa::class, 'nguoi_dung_id');
    }
    public function cacDeXuatTao()
    {
        return $this->hasMany(DonDeXuat::class, 'nguoi_tao_id');
    }

    public function cacDeXuatNhan()
    {
        return $this->hasMany(DonDeXuat::class, 'nguoi_duoc_de_xuat_id');
    }

    public function cacDeXuatDuyet()
    {
        return $this->hasMany(DonDeXuat::class, 'nguoi_duyet_id');
    }
}