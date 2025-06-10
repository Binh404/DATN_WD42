<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ChamCong extends Model
{
    use HasFactory;
    // $now = Carbon::now('Asia/Ho_Chi_Minh');
    protected $table = 'cham_cong';

    protected $fillable = [
        'nguoi_dung_id',
        'ngay_cham_cong',
        'gio_vao',
        'gio_ra',
        'so_gio_lam',
        'so_cong',
        'gio_tang_ca',
        'phut_di_muon',
        'phut_ve_som',
        'trang_thai',
        'vi_tri_check_in',
        'vi_tri_check_out',
        'dia_chi_ip',
        'ghi_chu',
        'trang_thai_duyet',
        'nguoi_phe_duyet_id',
        'thoi_gian_phe_duyet',
    ];

    protected $casts = [
        'ngay_cham_cong' => 'date',
        'gio_vao' => 'datetime',
        'gio_ra' => 'datetime',
        'so_gio_lam' => 'decimal:1',
        'so_cong' => 'decimal:1',
        'gio_tang_ca' => 'decimal:1',
        'phut_di_muon' => 'integer',
        'phut_ve_som' => 'integer',
        'thoi_gian_phe_duyet' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
// Relationships
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function nguoiPheDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_phe_duyet_id');
    }

    // Scopes
    public function scopeHangNgay($query, $date = null)
    {
        $date = $date ?? now()->format('Y-m-d');
        return $query->where('ngay_cham_cong', $date);
    }

    public function scopeThangHienTai($query, $userId = null)
    {
        $query->whereYear('ngay_cham_cong', now()->year)
              ->whereMonth('ngay_cham_cong', now()->month);

        if ($userId) {
            $query->where('nguoi_dung_id', $userId);
        }

        return $query;
    }

    public function scopeCuaNguoiDung($query, $userId)
    {
        return $query->where('nguoi_dung_id', $userId);
    }

    // Accessors & Mutators
    public function getTrangThaiTextAttribute()
    {
        return match($this->trang_thai) {
            'binh_thuong' => 'Bình thường',
            'di_muon' => 'Đi muộn',
            've_som' => 'Về sớm',
            'vang_mat' => 'Vắng mặt',
            'nghi_phep' => 'Nghỉ phép',
            default => 'Không xác định'
        };
    }

    public function getGioVaoFormatAttribute()
    {
        return $this->gio_vao ? Carbon::parse($this->gio_vao)->format('H:i') : '--:--';
    }

    public function getGioRaFormatAttribute()
    {
        return $this->gio_ra ? Carbon::parse($this->gio_ra)->format('H:i') : '--:--';
    }

    // Methods
    public function tinhSoGioLam()
    {
        if (!$this->gio_vao || !$this->gio_ra) {
            return 0;
        }

        $gioVao = Carbon::parse($this->gio_vao);
        $gioRa = Carbon::parse($this->gio_ra);

        // Tính số giờ làm việc (trừ giờ nghỉ trưa)
        $soGio = $gioVao->diffInMinutes($gioRa) / 60;

        // Trừ 1 giờ nghỉ trưa nếu làm trên 6 giờ
        if ($soGio > 6) {
            $soGio -= 1;
        }

        return round($soGio, 2);
    }

    public function tinhSoCong()
    {
        $soGioLam = $this->so_gio_lam;

        // Quy đổi số công: 8 giờ = 1 công
        return round($soGioLam / 8, 1);
    }

    public function kiemTraDiMuon()
    {
        if (!$this->gio_vao) return false;

        $gioVaoQuyDinh = Carbon::parse('08:30');
        $gioVaoThucTe = Carbon::parse($this->gio_vao);

        return $gioVaoThucTe->gt($gioVaoQuyDinh);
    }

    public function kiemTraVeSom()
    {
        if (!$this->gio_ra) return false;

        $gioRaQuyDinh = Carbon::parse('17:30');
        $gioRaThucTe = Carbon::parse($this->gio_ra);

        return $gioRaThucTe->lt($gioRaQuyDinh);
    }

    public function capNhatTrangThai()
    {
        $trangThai = 'binh_thuong';

        if ($this->kiemTraDiMuon()) {
            $trangThai = 'di_muon';
            $this->phut_di_muon = Carbon::parse('8:30')->diffInMinutes(Carbon::parse($this->gio_vao));
        }

        if ($this->kiemTraVeSom()) {
            $trangThai = $trangThai === 'di_muon' ? 'di_muon' : 've_som';
            $this->phut_ve_som = Carbon::parse($this->gio_ra)->diffInMinutes(Carbon::parse('17:30'));
        }

        $this->trang_thai = $trangThai;
        $this->so_gio_lam = $this->tinhSoGioLam();
        $this->so_cong = $this->tinhSoCong();

        return $this;
    }


    // Static methods
    public static function layBangChamCongThang($userId, $month = null, $year = null)
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return self::where('nguoi_dung_id', $userId)
                   ->whereYear('ngay_cham_cong', $year)
                   ->whereMonth('ngay_cham_cong', $month)
                   ->orderBy('ngay_cham_cong')
                   ->get();
    }

    public static function kiemTraDaChamCong($userId, $date = null)
    {
        $date = $date ?? now()->format('Y-m-d');

        return self::where('nguoi_dung_id', $userId)
                   ->where('ngay_cham_cong', $date)
                   ->exists();
    }

    public static function layBanGhiHomNay($userId)
    {
        return self::where('nguoi_dung_id', $userId)
                   ->where('ngay_cham_cong', now()->format('Y-m-d'))
                   ->first();
    }
    public static function layBanGhiTheoNgay($userId, $date)
    {
        return self::where('nguoi_dung_id', $userId)
                   ->where('ngay_cham_cong', $date)
                   ->first();
    }

}
