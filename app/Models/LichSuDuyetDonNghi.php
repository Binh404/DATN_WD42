<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuDuyetDonNghi extends Model
{
    use HasFactory;
    protected $table = 'lich_su_duyet_don_nghi';

    protected $fillable = [
        'don_xin_nghi_id',
        'cap_duyet',
        'nguoi_duyet_id',
        'ket_qua',
        'ghi_chu',
        'thoi_gian_duyet',
    ];

    public $timestamps = true;

    // Don nghỉ phép được duyệt
    public function donXinNghi()
    {
        return $this->belongsTo(DonXinNghi::class, 'don_xin_nghi_id');
    }

    // Người thực hiện duyệt
    public function nguoiDuyet()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_duyet_id');
    }
}
