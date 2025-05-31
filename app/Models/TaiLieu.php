<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
    use HasFactory;

    protected $table = 'tai_lieu';

    protected $fillable = [
        'nguoi_dung_id',
        'ung_vien_id',
        'loai_tai_lieu',
        'tieu_de',
        'mo_ta',
        'ten_file_goc',
        'duong_dan_file',
        'kich_thuoc_file',
        'loai_mime',
        'bao_mat',
        'ngay_het_han',
        'nguoi_tai_len_id',
        'thoi_gian_tai_len',
        'trang_thai',
    ];

    protected $casts = [
        'kich_thuoc_file' => 'integer',
        'bao_mat' => 'boolean',
        'ngay_het_han' => 'date',
        'thoi_gian_tai_len' => 'datetime',
    ];

    // Relationships
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function ungVien()
    {
        return $this->belongsTo(UngVien::class, 'ung_vien_id');
    }

    public function nguoiTaiLen()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_tai_len_id');
    }

    // Enums
    public const LOAI_TAI_LIEU = [
        'cv' => 'CV',
        'bang_cap' => 'Bằng cấp',
        'chung_chi' => 'Chứng chỉ',
        'hop_dong' => 'Hợp đồng',
        'khac' => 'Khác',
    ];

    public const TRANG_THAI = [
        'dang_xu_ly' => 'Đang xử lý',
        'hop_le' => 'Hợp lệ',
        'khong_hop_le' => 'Không hợp lệ',
    ];

    // Helper methods
    public function getFileSizeFormatted(): string
    {
        $bytes = $this->kich_thuoc_file;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
