<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungQuyen extends Model
{
     use HasFactory;

    protected $table = 'nguoi_dung_quyen';
    public $incrementing = false;
    protected $primaryKey = ['nguoi_dung_id', 'quyen_id'];

    protected $fillable = [
        'nguoi_dung_id',
        'quyen_id',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    // Relationships
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    public function quyen()
    {
        return $this->belongsTo(Quyen::class, 'quyen_id');
    }
}
