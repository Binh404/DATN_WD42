<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{

    protected $table = 'ung_tuyen';
    use HasFactory;

    protected $fillable = [
        'ma_ung_tuyen',
        'tin_tuyen_dung_id',
        'ten_ung_vien',
        'email',
        'so_dien_thoai',
        'kinh_nghiem',
        'ky_nang',
        'thu_gioi_thieu',
        'tai_cv',
        'diem_danh_gia',
        'trang_thai_pv',
        'diem_phong_van',
        'ghi_chu',
        'nguoi_cap_nhat',
        'trang_thai',
        'ly_do',
        'ngay_cap_nhat',
        'nguoi_cap_nhat_id',
        'nguoi_cap_nhat_cuoi_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ungTuyen) {
            $ungTuyen->diem_danh_gia = $ungTuyen->tinhDiemDanhGia();
            $ungTuyen->trang_thai_pv = 'chưa phỏng vấn'; // Sửa lại chữ thường để khớp với enum
        });
    }

    public function nguoiCapNhat()
    {
        return $this->belongsTo(User::class, 'nguoi_cap_nhat');
    }

    public function nguoiCapNhatTrangThai()
    {
        return $this->belongsTo(User::class, 'nguoi_cap_nhat_id');
    }

    public function tinhDiemDanhGia()
    {
        $tinTuyenDung = $this->tinTuyenDung;
        if (!$tinTuyenDung) {
            return 0;
        }

        $totalScore = 0;
        $weights = [
            'ky_nang' => 0.4,      // 40% cho kỹ năng
            'kinh_nghiem' => 0.3,  // 30% cho kinh nghiệm
            'phu_hop' => 0.3       // 30% cho độ phù hợp (từ thư giới thiệu)
        ];

        // Đánh giá kỹ năng (40 điểm)
        if ($this->ky_nang && $tinTuyenDung->ky_nang_yeu_cau) {
            $ungVienSkills = array_map('trim', explode(',', strtolower($this->ky_nang)));
            $requiredSkills = array_map('strtolower', $tinTuyenDung->ky_nang_yeu_cau);
            $matchedSkills = array_intersect($ungVienSkills, $requiredSkills);
            $skillScore = count($matchedSkills) / max(1, count($requiredSkills)) * 100;
            $totalScore += $skillScore * $weights['ky_nang'];
        }

        // Đánh giá kinh nghiệm (30 điểm)
       // Đánh giá kinh nghiệm (30 điểm)
if ($this->kinh_nghiem && $tinTuyenDung->kinh_nghiem_toi_thieu !== null) {
    preg_match_all('/\d+/', $this->kinh_nghiem, $matches);
    $numbers = array_map('intval', $matches[0]);
    $expYears = count($numbers) == 2 ? array_sum($numbers) / 2 : $numbers[0];

    $minExp = $tinTuyenDung->kinh_nghiem_toi_thieu;
    $maxExp = $tinTuyenDung->kinh_nghiem_toi_da;

    if ($expYears >= $minExp) {
        // Nếu nằm trong khoảng hoặc vượt quá tối đa vẫn cộng 100%
        $totalScore += 100 * $weights['kinh_nghiem'];
    } else {
        // Không đủ kinh nghiệm
        $totalScore += 0;
    }
}

        
        
        
        // Đánh giá độ phù hợp từ thư giới thiệu (30 điểm)
        if ($this->thu_gioi_thieu && $tinTuyenDung->mo_ta_cong_viec) {
            $keywordsToMatch = [
                
                strtolower($tinTuyenDung->mo_ta_cong_viec)
            ];
            
            $letterContent = strtolower($this->thu_gioi_thieu);
            $matchCount = 0;
            foreach ($keywordsToMatch as $keyword) {
                if (str_contains($letterContent, $keyword)) {
                    $matchCount++;
                }
            }
            
            $matchScore = ($matchCount / count($keywordsToMatch)) * 100;
            $totalScore += $matchScore * $weights['phu_hop'];
        }

        return round($totalScore, 2);
    }

    public function tinTuyenDung() {
        return $this->belongsTo(TinTuyenDung::class, 'tin_tuyen_dung_id');
    }
}
