<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungVaiTro extends Model
{
     use HasFactory;

    protected $table = 'nguoi_dung_vai_tro';
    public $incrementing = false;
    protected $primaryKey = ['nguoi_dung_id', 'vai_tro_id'];

    protected $fillable = [
        'nguoi_dung_id',
        'vai_tro_id',
        'model_type',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    // Relationships
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }
}
