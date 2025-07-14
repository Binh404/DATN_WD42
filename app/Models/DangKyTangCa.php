<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class DangKyTangCa extends Model
{
    use HasFactory;

    protected $table = 'dang_ky_tang_ca';

    protected $fillable = [
        'nguoi_dung_id',
        'ngay_tang_ca',
        'gio_bat_dau',
        'gio_ket_thuc',
        'so_gio_tang_ca',
        'loai_tang_ca',
        'ly_do_tang_ca',
        'trang_thai',
        'nguoi_duyet_id',
        'thoi_gian_duyet',
        'ly_do_tu_choi'
    ];

    protected $casts = [
        'ngay_tang_ca' => 'date',
        'gio_bat_dau' => 'datetime:H:i',
        'gio_ket_thuc' => 'datetime:H:i',
        'so_gio_tang_ca' => 'decimal:2',
        'thoi_gian_duyet' => 'datetime'
    ];

    // Constants cho enum values
    const LOAI_TANG_CA = [
        'ngay_thuong' => 'Ngày thường',
        'ngay_nghi' => 'Ngày nghỉ',
        'le_tet' => 'Lễ Tết'
    ];

    const TRANG_THAI = [
        'cho_duyet' => 'Chờ duyệt',
        'da_duyet' => 'Đã duyệt',
        'tu_choi' => 'Từ chối',
        'huy' => 'Hủy'
    ];

    /**
     * Quan hệ với bảng nguoi_dung (người đăng ký)
     */
    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    /**
     * Quan hệ với bảng nguoi_dung (người duyệt)
     */
    public function nguoiDuyet(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_duyet_id');
    }

    /**
     * Scope để lọc theo trạng thái
     */
    public function scopeByTrangThai($query, $trangThai)
    {
        return $query->where('trang_thai', $trangThai);
    }
    public function scopeByEmployee($query, $employeeId)
    {
        return $query->where('nguoi_dung_id', $employeeId);
    }


    /**
     * Scope để lọc theo người dùng
     */
    public function scopeByNguoiDung($query, $nguoiDungId)
    {
        return $query->where('nguoi_dung_id', $nguoiDungId);
    }

    /**
     * Scope để lọc theo tháng
     */
    public function scopeByNgayTangCa($query, $ngayTangCa)
    {
        return $query->where('ngay_tang_ca', $ngayTangCa);
    }
    public function scopeByThang($query, $thang)
    {
        return $query->whereMonth('ngay_tang_ca', $thang);
                    // ->whereYear('ngay_tang_ca', $nam);
    }
    public function scopeByNam($query, $nam)
    {
        return $query->whereYear('ngay_tang_ca', $nam);
    }
    public function scopePending($query)
    {
        return $query->where('trang_thai', 'cho_duyet');
    }
    public function scopeApproved($query)
    {
        return $query->where('trang_thai', 'da_duyet');
    }

    /**
     * Accessor để hiển thị tên loại tăng ca
     */
    public function getLoaiTangCaTextAttribute()
    {
        return self::LOAI_TANG_CA[$this->loai_tang_ca] ?? $this->loai_tang_ca;
    }

    /**
     * Accessor để hiển thị tên trạng thái
     */
    public function getTrangThaiTextAttribute()
    {
        return self::TRANG_THAI[$this->trang_thai] ?? $this->trang_thai;
    }

    /**
     * Accessor để kiểm tra có thể hủy không
     */
    public function getCoTheHuyAttribute()
    {
        return in_array($this->trang_thai, ['cho_duyet']);
    }

    /**
     * Accessor để kiểm tra có thể duyệt không
     */
    public function getCotheDuyetAttribute()
    {
        return $this->trang_thai === 'cho_duyet';
    }

    /**
     * Mutator để tự động tính số giờ tăng ca
     */
//     public function setGioBatDauAttribute($value)
//     {
//         $this->attributes['gio_bat_dau'] = $value;
//         $this->tinhSoGioTangCa();
//     }

//    public function setGioKetThucAttribute($value)
//     {
//         $this->attributes['gio_ket_thuc'] = $value;
//         // Only calculate if both times are set
//         if (isset($this->attributes['gio_bat_dau']) && isset($this->attributes['gio_ket_thuc'])) {
//             $this->tinhSoGioTangCa();
//         }
//     }
    public function calculateOvertimeHours()
    {
        if (!$this->gio_bat_dau || !$this->gio_ket_thuc) {
            return 0;
        }

        $gioBatDau = Carbon::createFromFormat('H:i', $this->gio_bat_dau);
        $gioKetThuc = Carbon::createFromFormat('H:i', $this->gio_ket_thuc);

        if ($gioKetThuc->lessThan($gioBatDau)) {
            $gioKetThuc->addDay();
        }

        return round($gioBatDau->diffInMinutes($gioKetThuc) / 60, 2);
    }

    /**
     * Tính toán số giờ tăng ca
     */
    private function tinhSoGioTangCa()
    {
        if ($this->attributes['gio_bat_dau'] && $this->attributes['gio_ket_thuc']) {
            $gioBatDau = Carbon::createFromFormat('H:i', $this->attributes['gio_bat_dau']);
            $gioKetThuc = Carbon::createFromFormat('H:i', $this->attributes['gio_ket_thuc']);

            // Nếu giờ kết thúc nhỏ hơn giờ bắt đầu thì cộng thêm 1 ngày
            if ($gioKetThuc->lessThan($gioBatDau)) {
                $gioKetThuc->addDay();
            }

            $soGio = $gioBatDau->diffInMinutes($gioKetThuc) / 60;
            $this->attributes['so_gio_tang_ca'] = round($soGio, 2);
        }
    }
}
