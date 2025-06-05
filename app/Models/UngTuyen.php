<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{

    protected $table = 'ung_tuyen';
    use HasFactory;

    protected $fillable = [
        'tin_tuyen_dung_id',
        'ma_ung_tuyen',
        'ten_ung_vien',
        'email',
        'so_dien_thoai',
        'kinh_nghiem',
        'ky_nang',
        'thu_gioi_thieu',
        'tai_cv'
    ];

    public function tinTuyenDung() {
        return $this->belongsTo(TinTuyenDung::class, 'tin_tuyen_dung_id');
    }
    public function calculateMatchingPercentage()
    {
        $matchingScore = 0;
        $totalCriteria = 0;
        
        // Get related job posting
        $tinTuyenDung = $this->tinTuyenDung;
        
        // Match skills (30%)
        if ($this->ky_nang && $tinTuyenDung->ky_nang_yeu_cau) {
            $ungVienSkills = array_map('trim', explode(',', strtolower($this->ky_nang)));
            $requiredSkills = array_map('strtolower', $tinTuyenDung->ky_nang_yeu_cau);
            
            $matchedSkills = array_intersect($ungVienSkills, $requiredSkills);
            $skillScore = count($matchedSkills) / count($requiredSkills) * 30;
            $matchingScore += $skillScore;
        }
        $totalCriteria += 30;
        
        // Match experience (40%)
        if ($this->kinh_nghiem) {
            $expYears = (int) filter_var($this->kinh_nghiem, FILTER_SANITIZE_NUMBER_INT);
            if ($expYears >= $tinTuyenDung->kinh_nghiem_toi_thieu && 
                $expYears <= $tinTuyenDung->kinh_nghiem_toi_da) {
                $matchingScore += 40;
            } elseif ($expYears >= $tinTuyenDung->kinh_nghiem_toi_thieu) {
                $matchingScore += 20;
            }
        }
        $totalCriteria += 40;
        
        // Match cover letter keywords (30%)
        if ($this->thu_gioi_thieu) {
            $keywordsToMatch = [
                strtolower($tinTuyenDung->tieu_de),
                strtolower($tinTuyenDung->mo_ta_cong_viec)
            ];
            
            $letterContent = strtolower($this->thu_gioi_thieu);
            $matchCount = 0;
            foreach ($keywordsToMatch as $keyword) {
                if (str_contains($letterContent, $keyword)) {
                    $matchCount++;
                }
            }
            
            $coverLetterScore = ($matchCount / count($keywordsToMatch)) * 30;
            $matchingScore += $coverLetterScore;
        }
        $totalCriteria += 30;
        
        // Calculate final percentage
        return round(($matchingScore / $totalCriteria) * 100);
    }
}
