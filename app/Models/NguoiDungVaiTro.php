<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungVaiTro extends Model
{
     use HasFactory;

    protected $table = 'nguoi_dung_vai_tro';
    public $incrementing = false;
    protected $primaryKey = ['role_id', 'vai_tro_id'];

    protected $fillable = [
        'role_id',
        'vai_tro_id',
        'model_type',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    // Relationships
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'role_id');
    }

    public function vaiTro()
    {
        return $this->belongsTo(VaiTro::class, 'vai_tro_id');
    }
}
